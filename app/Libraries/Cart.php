<?php
namespace App\Libraries;

use CodeIgniter\Session\Session;

class Cart
{
    protected $session;
    protected $_cart_contents = [];

    public $product_id_rules   = '\.a-z0-9_-';
    public $product_name_rules = '\w \-\.\:';
    public $product_name_safe  = true;

    public function __construct()
    {
        $this->session = session();

        $this->_cart_contents = $this->session->get('cart_contents');

        if ($this->_cart_contents === null) {
            $this->_cart_contents = ['cart_total' => 0, 'total_items' => 0];
        }
    }

    public function insert(array $items = [])
    {
        if (empty($items)) {
            return false;
        }

        $save_cart = false;
        if (isset($items['id'])) {
            if (($rowid = $this->_insert($items))) {
                $save_cart = true;
            }
        } else {
            foreach ($items as $val) {
                if (is_array($val) && isset($val['id'])) {
                    if ($this->_insert($val)) {
                        $save_cart = true;
                    }
                }
            }
        }

        if ($save_cart) {
            $this->_save_cart();
            return $rowid ?? true;
        }

        return false;
    }

    protected function _insert(array $items)
    {
        if (!isset($items['id'], $items['qty'], $items['price'], $items['name'])) {
            return false;
        }

        $items['qty'] = (float) $items['qty'];
        if ($items['qty'] == 0) {
            return false;
        }

        if (!preg_match('/^['.$this->product_id_rules.']+$/i', $items['id'])) {
            return false;
        }

        if ($this->product_name_safe && !preg_match('/^['.$this->product_name_rules.']+$/iu', $items['name'])) {
            return false;
        }

        $items['price'] = (float) $items['price'];

        $rowid = isset($items['options']) && count($items['options']) > 0
            ? md5($items['id'].serialize($items['options']))
            : md5($items['id']);

        $old_quantity = isset($this->_cart_contents[$rowid]['qty'])
            ? (int) $this->_cart_contents[$rowid]['qty']
            : 0;

        $items['rowid'] = $rowid;
        $items['qty'] += $old_quantity;

        $this->_cart_contents[$rowid] = $items;

        return $rowid;
    }

    public function update(array $items = [])
    {
        if (empty($items)) {
            return false;
        }

        $save_cart = false;

        if (isset($items['rowid'])) {
            if ($this->_update($items)) {
                $save_cart = true;
            }
        } else {
            foreach ($items as $val) {
                if (is_array($val) && isset($val['rowid'])) {
                    if ($this->_update($val)) {
                        $save_cart = true;
                    }
                }
            }
        }

        if ($save_cart) {
            $this->_save_cart();
            return true;
        }

        return false;
    }

    protected function _update(array $items)
    {
        if (!isset($items['rowid'], $this->_cart_contents[$items['rowid']])) {
            return false;
        }

        if (isset($items['qty'])) {
            $items['qty'] = (float) $items['qty'];
            if ($items['qty'] == 0) {
                unset($this->_cart_contents[$items['rowid']]);
                return true;
            }
        }

        foreach ($items as $key => $value) {
            if ($key !== 'id' && $key !== 'name') {
                $this->_cart_contents[$items['rowid']][$key] = $value;
            }
        }

        return true;
    }

    protected function _save_cart()
    {
        $this->_cart_contents['total_items'] = $this->_cart_contents['cart_total'] = 0;

        foreach ($this->_cart_contents as $key => $val) {
            if (!is_array($val) || !isset($val['price'], $val['qty'])) {
                continue;
            }

            $this->_cart_contents['cart_total'] += ($val['price'] * $val['qty']);
            $this->_cart_contents['total_items'] += $val['qty'];
            $this->_cart_contents[$key]['subtotal'] = ($val['price'] * $val['qty']);
        }

        if (count($this->_cart_contents) <= 2) {
            $this->session->remove('cart_contents');
            return false;
        }

        $this->session->set('cart_contents', $this->_cart_contents);
        return true;
    }

    public function total()
    {
        return $this->_cart_contents['cart_total'];
    }

    public function total_items()
    {
        return $this->_cart_contents['total_items'];
    }

    public function contents($newest_first = false)
    {
        $cart = $newest_first ? array_reverse($this->_cart_contents) : $this->_cart_contents;
        unset($cart['total_items'], $cart['cart_total']);
        return $cart;
    }

    public function get_item($row_id)
    {
        return (in_array($row_id, ['total_items', 'cart_total'], true) || !isset($this->_cart_contents[$row_id]))
            ? false
            : $this->_cart_contents[$row_id];
    }

    public function remove($rowid)
    {
        unset($this->_cart_contents[$rowid]);
        $this->_save_cart();
        return true;
    }

    public function destroy()
    {
        $this->_cart_contents = ['cart_total' => 0, 'total_items' => 0];
        $this->session->remove('cart_contents');
    }
}

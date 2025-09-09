<?php

namespace App\Controllers;

use App\Models\{AdminModel,BookModel};
use CodeIgniter\Controller;

class CartController extends BaseController
{
    protected $cart;
    protected $session;
    protected $adminModel;

    public function __construct()
    {
        // Load services
        
        $this->adminModel = new AdminModel();
         $this->bookModel = new BookModel();
    }

    public function index()
    {
        // Load dynamic category
        $view['category'] = $this->adminModel->getCategory();

        $view['user_view'] = "users/myCart";

        // In CI4, you typically pass data to the view like this
        echo view('layouts/user_layout', $view);
    }

    public function add()
{
    $id   = $this->request->getPost('id');
    $qty  = $this->request->getPost('qty') ?? 1;

    // Load your book model
    

    // Find the book by ID
    $book = $this->bookModel->find($id);

    if (!$book) {
        // Book does not exist
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Book not found'
        ]);
    }

    // Insert only if book exists
    $this->cart->insert([
        'id'         => $id,
        'qty'        => $qty,
        'name'       => $book->book_name,
        'price'      => $book->price,
        'book_image' => $book->book_image, // safely use book image
    ]);

    return $this->response->setJSON([
        'status'      => 'success',
        'total_items' => $this->cart->total_items(),
        'cart_total'  => $this->cart->total()
    ]);
}


    // public function getAdd($id)
    // {
    //     // Load dynamic category
    //     $view['category'] = $this->adminModel->get_category();

    //     // Get book info from database
    //     $books = $this->adminModel->get_book_detail($id);

    //     // Insert data into cart
    //     $data = [
    //         'id' => $books->id,
    //         'price' => $books->price,
    //         'name' => $books->book_name,
    //         'book_image' => $books->book_image,
    //         'qty' => 1
    //     ];

    //     $this->cart->product_name_rules = '[:print:]'; // Allow special characters
    //     $this->cart->insert($data);

    //     // Redirect to the previous page
    //     return redirect()->back();
    // }

    public function update()
{
    $contents = $this->request->getPost();
    $errorMessages = [];
    $updated = false;

    foreach ($contents as $content) {
        // Ensure rowid and qty exist
        if (!isset($content['rowid'], $content['qty'])) {
            continue;
        }

        $rowid = $content['rowid'];
        $qty = (int) $content['qty'];

        if ($qty < 0) {
            $errorMessages[] = '<i class="fas fa-exclamation-triangle"></i> Quantity cannot be less than 0';
        } elseif ($qty > 1000) {
            $errorMessages[] = '<i class="fas fa-exclamation-triangle"></i> You cannot buy more than 1000 books at a time Contact Admin';
        } else {
            $this->cart->update([
                'rowid' => $rowid,
                'qty'   => $qty
            ]);
            $updated = true;
        }
    }

    if (!empty($errorMessages)) {
        // Join all errors into a single flash message
        $this->session->setFlashdata('cart_error', implode('<br>', $errorMessages));
    }
     if ($updated && empty($errorMessages)) {
        $this->session->setFlashdata('cart_success', '<i class="fas fa-check-circle"></i> Cart updated successfully!');
    }
    return redirect()->to('/cart');
}

    public function delete_cart($rowid)
    {
        if ($this->cart->remove($rowid)) {
            $this->session->setFlashdata('remove_cart', 'Book removed from the cart.');
        }

        return redirect()->to('/cart');
    }

    public function remove($rowid)
    {
        if($this->cart->get_item($rowid)){
            $this->cart->remove($rowid);

            if($this->request->isAJAX()){
                return $this->response->setJSON([
                    'status' => 'success',
                    'total_items' => $this->cart->total_items(),
                    'cart_total'  => $this->cart->total()
                ]);
            }

            return redirect()->to(base_url('cart'))->with('remove_cart', 'Item removed successfully.');
        }

        if($this->request->isAJAX()){
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Item not found in cart.'
            ]);
        }

        return redirect()->to(base_url('cart'))->with('cart_error', 'Item not found.');
    }
}

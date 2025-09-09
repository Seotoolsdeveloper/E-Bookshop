<?php
namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;

class Checkout extends BaseController
{
    protected $cart;
    protected $adminModel;
    protected $userModel;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->cart = \Config\Services::cart();
        $this->adminModel = new AdminModel();
        $this->userModel = new UserModel();

        if (!session()->get('logged_in')) {
            session()->setFlashdata('no_access', 'You are not logged in! Please log in.');
            return redirect()->to(base_url('users/login'))->send();
        }
    }

    public function index()
{
    $cartItems = $this->cart->contents();

    $validationRules = [
        'name'        => 'required|trim',
        'contact'     => 'required|numeric',
        'email'       => 'required|valid_email',
        'address'     => 'required|max_length[255]',
        'zipcode'     => 'required|numeric',
        'city'        => 'required',
        'paymentcheck'=> 'required'
    ];

    if ($this->request->getMethod() === 'POST') {
        if (!$this->validate($validationRules)) {
            $data['validation'] = $this->validator;
        } else {
            $userModel = model('UserModel');
            if ($userModel->addOrders($cartItems, $this->request->getPost())) {
                session()->setFlashdata('success', 'Your order has been placed successfully.');
                $this->cart->destroy();
                return redirect()->to(route_to('checkout.place_order'));
            } else {
                session()->setFlashdata('error', 'Error placing order. Try again.');
                return redirect()->back();
            }
        }
    }

    if (empty($cartItems)) {
        session()->setFlashdata('cart_error', 'Your cart is empty! Add books to checkout.');
        return redirect()->to(base_url('cart'));
    }

    $data['category'] = $this->adminModel->getCategory();
    $data['user_view'] = 'users/checkout_page';
    return view('layouts/user_home', $data);
}

    public function place_order()
    {
        $data['category'] = $this->adminModel->getCategory();
        $data['user_view'] = 'users/place_order_page';
        return view('layouts/user_home', $data);
    }
}

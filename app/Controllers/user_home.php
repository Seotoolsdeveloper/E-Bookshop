<?php

namespace App\Controllers;

use App\Models\AdminModel ;
use App\Models\{UserModel,BookModel};
use CodeIgniter\Controller;

class User_home extends BaseController
{
    protected $cart;
    protected $adminModel;
    protected $userModel;
    protected $session;

    public function __construct()
    {
       
        $this->adminModel = new AdminModel();
        $this->userModel = new UserModel();
        $this->bookModel = new BookModel();

        

        // Only allow users with type 'U'
        $type = session()->get('type');
        if ($type != 'U') {
            $this->session->setFlashdata('no_access', '<i class="fas fa-exclamation-triangle"></i> You are not allowed or not logged in! Please log in with a user account');
            return redirect()->to(base_url('users/login'))->send();
        }
    }

    public function index()
    {
        $data['category'] = $this->adminModel->getCategory();

        $id = $this->session->get('id');
        $data['user_details'] = $this->userModel->getUserDetails($id);

        $data['user_view'] = "users/user_index";
        echo view('layouts/user_home', $data);
    }

   public function sellbooks()
{
    $data['category'] = $this->adminModel->getCategory();

    
    $this->session->setFlashdata('error', 'Fill all details');
    // Show the form (GET request or failed validation)
    $data['user_view'] = "users/sell_books";
    echo view('layouts/user_home', $data);
}

public function sellbook()
{
    $validation = [
        'book_name'    => 'required|trim',
        'description'  => 'required|min_length[100]',
        'author'       => 'required|trim',
        'publisher'    => 'required|trim',
        'price'        => 'required|trim',
        'quantity'     => 'required|numeric',
        'categoryId'   => 'required',
        'conditionBox' => 'required'
    ];

    $file = $this->request->getFile('userfile');

    if (!$this->validate($validation) || $file === null || !$file->isValid()) {

        $errors = $this->validator ? $this->validator->getErrors() : [];

        if ($file !== null && !$file->isValid()) {
            $errors['userfile'] = $file->getErrorString();
        }

        $this->session->setFlashdata('errors', $errors);
        return redirect()->back()->withInput(); // Keep old input

    } else {
        // Move file here and pass data to model
        $image_path = null;
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/image', $newName);
            $image_path = base_url("uploads/image/" . $newName);
        }

        // Gather form data
        $data = [
            'book_name'  => $this->request->getPost('book_name'),
            'description'=> $this->request->getPost('description'),
            'author'     => $this->request->getPost('author'),
            'publisher'  => $this->request->getPost('publisher'),
            'price'      => $this->request->getPost('price'),
            'quantity'   => $this->request->getPost('quantity'),
            'categoryId' => $this->request->getPost('categoryId'),
            'book_image' => $image_path,
        ];

        if ($this->userModel->addbooks($data)) {
            $this->session->setFlashdata('success', 'Book added successfully! This book will be published by admin soon.');
            return redirect()->to(base_url('user_home'));
        } else {
            $this->session->setFlashdata('error', 'Error inserting book!');
            return redirect()->back()->withInput();
        }
    }
}

    public function myBooks()
    {
        $data['category'] = $this->adminModel->getCategory();
        $data['books'] = $this->userModel->mybooks();
        $data['user_view'] = "users/users_books";
        echo view('layouts/user_home', $data);
    }

    public function myBooks_delete($id)
    {
        if ($this->userModel->delete_book($id)) {
            $this->session->setFlashdata('success', '<i class="fas fa-trash text-danger"></i> Book deleted successfully');
        } else {
            $this->session->setFlashdata('cart_error', 'Failed to delete book.');
        }
        return redirect()->to(base_url('user_home/myBooks'));
    }

    public function my_orders()
    {
        $data['category'] = $this->adminModel->getCategory();
        $data['orders'] = $this->userModel->myOrders();
        $data['user_view'] = "users/myOrders";
        echo view('layouts/user_home', $data);
    }

    public function order_view($orderId)
    {
        $data['category'] = $this->adminModel->getCategory();
        $data['order_detail'] = $this->adminModel->get_order_detail($orderId);

        $data['user_view'] = $data['order_detail'] ? "users/myOrder_detail" : "temp/404page";
        echo view('layouts/user_home', $data);
    }

    public function edit_profile($id)
{
    $data['category'] = $this->adminModel->getCategory();
    $data['user_details'] = $this->userModel->getUserDetails($id);

    $validationRules = [
        'name'       => 'required|trim',
        'contact'    => 'required|numeric',
        
        'address'    => 'required|max_length[80]',
        'city'       => 'required'
    ];
    if ($this->request->getPost('password')) {
        $validationRules['password']   = 'min_length[3]';
        $validationRules['repassword'] = 'matches[password]';
    }
    // Check if the form is submitted
    
    if ($this->request->getMethod() === 'POST') {

        if (!$this->validate($validationRules)) {
            // Validation failed
            $data['validation'] = $this->validator;
            $data['user_view'] = $data['user_details'] ? "users/edit_profile" : "temp/404page";
            return view('layouts/user_home', $data);
        } else {
            $updateData = [
                'name'    => $this->request->getPost('name'),
                'contact' => $this->request->getPost('contact'),
                'address' => $this->request->getPost('address'),
                'city'    => $this->request->getPost('city')
            ];

            // Only update password if entered
            if ($this->request->getPost('password')) {
                $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
            }
            // Validation passed, update profile
            if ($this->userModel->editprofile($id, $updateData)) {
                session()->setFlashdata('success', 'Your profile info updated successfully');
                return redirect()->to(base_url(route_to('user_home')));
            } else {
                session()->setFlashdata('error', 'Error updating profile!');
                return redirect()->back();
            }
        }

    } else {
        // Form not submitted yet, just display
        $data['user_view'] = $data['user_details'] ? "users/edit_profile" : "temp/404page";
        return view('layouts/user_home', $data);
    }
}

}

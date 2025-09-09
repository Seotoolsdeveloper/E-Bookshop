<?php

namespace App\Controllers;

use App\Models\AdminModel;
use App\Models\UserModel;
use App\Models\BookModel;

class Users extends BaseController
{
    protected $session;
    protected $cart;
    protected $adminModel;
    protected $userModel;
    protected $bookModel;

    public function __construct()
    {
        $this->session    = \Config\Services::session();
        $this->cart       = \Config\Services::cart();
        $this->adminModel = new AdminModel();
        $this->userModel  = new UserModel();
        $this->bookModel  = new BookModel();

        helper(['form', 'url']);
    }

    public function index()
    {
        return redirect()->back();
    }

    /* ================= REGISTRATION ================= */
    public function registration()
    {
        $validation =[
            'name'        => 'required|trim',
            'contact'     => 'required|numeric',
            'email'       => 'required|valid_email|is_unique[users.email]',
            'password'    => 'required|alpha_dash|min_length[3]',
            'repassword'  => 'required|matches[password]',
            'address'     => 'required|trim',
            'city'        => 'required|trim',
            'conditionBox'=> 'required'
        ];

        if (!$this->validate($validation)) {
            $data['category']  = $this->adminModel->getCategory();
            $data['user_view'] = "users/reg";
            return view('layouts/home_layout', $data);
        }

        $this->userModel->registerUser($this->request->getPost());
        $this->session->setFlashdata('reg_success', 'Registration successful.');
        return redirect()->to(base_url('users/login'));
    }

    /* ================= LOGIN ================= */
    public function login()
    {
        $validation = [
            'email'    => 'required|valid_email',
            'password' => 'required|alpha_dash|min_length[3]'
        ];

        if (!$this->validate($validation)) {
            $data['category']  = $this->adminModel->getCategory();
            $data['user_view'] = "users/login";
            return view('layouts/home_layout', $data);
        }

        $user = $this->userModel->loginUser(
            $this->request->getPost('email'),
            $this->request->getPost('password')
        );

        if ($user) {
            $this->session->set([
                'id'       => $user->id,
                'email'    => $user->email,
                'type'     => $user->type,
                'name'     => $user->name,
                'logged_in'=> true
            ]);

            return ($user->type == 'A')
                ? redirect()->to(base_url('admin/index'))
                : redirect()->to(base_url('/'));
        }

        $this->session->setFlashdata('login_fail', 'Invalid login.');
        return redirect()->back();
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('/'));
    }

    /* ================= ALL BOOKS (pagination) ================= */
    public function all_books()
    {

        
        $perPage = 18;
        $data['category'] = $this->adminModel->getCategory();
        $data['books']    = $this->bookModel->paginateBooks($perPage);
        $data['pager']    = $this->bookModel->pager;
        $data['user_view']= "users/all_books";

        $this->bookModel->generateSlugsForAllBooks();
    

        return view('layouts/home_layout', $data);
    }

    /* ================= SINGLE BOOK VIEW ================= */
    public function book_view($id)
    {
        $data['category']    = $this->adminModel->getCategory();
        $data['book_detail'] = $this->bookModel->getBookDetail($id);
        $data['reviews']     = $this->userModel->getReviews($id);
        $data['book_id'] = $id;
        $data['user_view'] = $data['book_detail']
            ? "users/book_detail"
            : "temp/404page";

        return view('layouts/home_layout', $data);
    }

    /* ================= SEARCH (pagination) ================= */
    public function search()
    {
       $query = $this->request->getGet('keywords'); // use 'keywords' as input name in form
        if (!$query) {
            return redirect()->to(base_url('/'));
        }

        $perPage = 18;
        $data['category']  = $this->adminModel->getCategory();
        $data['books']     = $this->bookModel->searchBooks($query, $perPage);
        $data['pager']     = $this->bookModel->pager;
        $data['searchTerm']= $query;
        $data['user_view'] = "users/search_books";

        return view('layouts/home_layout', $data);
    }
}

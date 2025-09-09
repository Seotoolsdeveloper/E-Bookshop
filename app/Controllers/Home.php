<?php
namespace App\Controllers;

use App\Models\AdminModel as Admin_model;

use App\Models\UserModel;
use App\Models\BookModel;
use CodeIgniter\Controller;

class Home extends BaseController
{
    protected $adminModel;
    protected $userModel;

    public function __construct()
    {
       
        // Load models
        $this->adminModel = new Admin_model();
        $this->userModel = new UserModel();
        $this->bookModel = new BookModel();

        // Load helpers if needed
        helper(['url', 'form', 'text']);
    }

    public function index()
    {
        // Load dynamic categories
        $data['category'] = $this->adminModel->getCategory();

        // Recent books
        $data['books'] = $this->bookModel->recentBooks();

        // CSE books
        $data['cse_books'] = $this->bookModel->cseBooks();

        return view('layouts/home_layout', $data);
    }
}

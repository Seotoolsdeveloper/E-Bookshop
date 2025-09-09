<?php

namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\Files\UploadedFile;

class Admin extends BaseController
{
    protected $session;
    protected $cart;
    protected $adminModel;

    public function __construct()
    {
        
        $this->adminModel = new AdminModel();

        // Only Admin access
        if (session()->get('type') !== 'A') {
            session()->setFlashdata('no_access', 'You are not allowed or not logged in!');
            return redirect()->to('/users/login')->send();
        }
    }

    /*=============== Admin Index Page =================*/
    public function index()
    {
        $view['admin_view'] = "admin/admin_index";
        echo view('layouts/admin_layout', $view);
    }

    /*================ CATEGORY ===================*/
    public function category()
    {
        $view['category'] = $this->adminModel->getCategory();
        $view['admin_view'] = "admin/category";
        echo view('layouts/admin_layout', $view);
    }

    public function add_category()
    {
        $rules = [
            'category'    => 'required|alpha_numeric_space',
            'tag'         => 'required|alpha',
            'description' => 'required'
        ];

        if (!$this->validate($rules)) {
            $view['admin_view'] = "admin/add_category";
            echo view('layouts/admin_layout', $view);
        } else {
            if ($this->adminModel->createCategory($this->request->getPost())) {
                $this->session->setFlashdata('success', 'Category created successfully');
                return redirect()->to('/admin/category');
            } else {
                echo 'Error creating category';
            }
        }
    }

    public function ctg_view($id)
    {
        $view['ctg_detail'] = $this->adminModel->getCtgDetail($id);
        $view['admin_view'] = $view['ctg_detail'] ? "admin/ctg_view" : "temp/404page";
        echo view('layouts/admin_layout', $view);
    }

    public function ctg_edit($id)
    {
        $view['ctg_detail'] = $this->adminModel->getCtgDetail($id);

        $rules = [
            'category'    => 'required|alpha_numeric_space',
            'tag'         => 'required|alpha',
            'description' => 'required'
        ];

        if (!$this->validate($rules)) {
            $view['admin_view'] = $view['ctg_detail'] ? "admin/ctg_edit" : "temp/404page";
            echo view('layouts/admin_layout', $view);
        } else {
            if ($this->adminModel->editCategory($id, $this->request->getPost())) {
                $this->session->setFlashdata('success', 'Category updated successfully');
                return redirect()->to('/admin/category');
            } else {
                echo 'Error updating category';
            }
        }
    }

    public function ctg_delete($id)
    {
        $this->adminModel->delete_category($id);
        $this->session->setFlashdata('success', 'Category deleted');
        return redirect()->to('/admin/category');
    }

    /*================ USERS ===================*/
    public function allusers()
    {
        $view['users_data'] = $this->adminModel->getUsers();
        $view['admin_view'] = "admin/view_users";
        echo view('layouts/admin_layout', $view);
    }

    public function add_users()
    {
        $rules = [
            'name'      => 'required|alpha_numeric_space',
            'contact'   => 'required|numeric',
            'email'     => 'required|valid_email|is_unique[users.email]',
            'password'  => 'required|alpha_dash|min_length[3]',
            'repassword'=> 'required|matches[password]',
            'type'      => 'required',
            'address'   => 'required|max_length[80]',
            'city'      => 'required|alpha_numeric_space'
        ];

        if (!$this->validate($rules)) {
            $view['admin_view'] = "admin/add_users";
            echo view('layouts/admin_layout', $view);
        } else {
            if ($this->adminModel->addUser($this->request->getPost())) {
                $this->session->setFlashdata('success', 'User added successfully');
                return redirect()->to('/admin/allusers');
            } else {
                echo 'Error adding user';
            }
        }
    }

    public function user_delete($id)
    {
        $this->adminModel->delete_user($id);
        $this->session->setFlashdata('success', 'User deleted');
        return redirect()->to('/admin/allusers');
    }

    /*================ BOOKS ===================*/
    public function books()
    {
        $pager = \Config\Services::pager();
        $perPage = 10;
        $page = $this->request->getVar('page') ?? 1;
        $view['books'] = $this->adminModel->getBooks($perPage, ($page-1)*$perPage);
        $view['pager'] = $pager;
        $view['admin_view'] = "admin/books";
        echo view('layouts/admin_layout', $view);
    }

    public function add_books()
    {
        $category = $this->adminModel->getCategory();
        $view['category'] = $category;

        $rules = [
            'book_name'   => 'required',
            'description' => 'required|min_length[100]',
            'author'      => 'required',
            'publisher'   => 'required',
            'price'       => 'required|numeric',
            'quantity'    => 'required|numeric',
            'categoryId'  => 'required'
        ];

        $file = $this->request->getFile('book_image');

        if (!$this->validate($rules) || !$file->isValid()) {
            $view['admin_view'] = "admin/add_books";
            echo view('layouts/admin_layout', $view);
        } else {
            $file->move(WRITEPATH.'uploads/images/');
            $this->adminModel->add_books($this->request->getPost(), $file->getName());
            $this->session->setFlashdata('success', 'Book added successfully');
            return redirect()->to('/admin/books');
        }
    }

    public function book_view($id)
    {
        $view['book_detail'] = $this->adminModel->getBookDetail($id);
        $view['admin_view'] = $view['book_detail'] ? "admin/book_view" : "temp/404page";
        echo view('layouts/admin_layout', $view);
    }

    public function book_edit($id)
    {
        $view['book_detail'] = $this->adminModel->getBookDetail($id);
        $view['category'] = $this->adminModel->getCategory();

        $rules = [
            'book_name'   => 'required',
            'description' => 'required|min_length[100]',
            'author'      => 'required',
            'publisher'   => 'required',
            'price'       => 'required|numeric',
            'quantity'    => 'required|numeric',
            'categoryId'  => 'required'
        ];

        $file = $this->request->getFile('book_image');

        if (!$this->validate($rules)) {
            $view['admin_view'] = $view['book_detail'] ? "admin/book_edit" : "temp/404page";
            echo view('layouts/admin_layout', $view);
        } else {
            if ($file->isValid()) {
                $file->move(WRITEPATH.'uploads/images/');
            }
            $this->adminModel->edit_book($id, $this->request->getPost(), $file->getName());
            $this->session->setFlashdata('success', 'Book updated successfully');
            return redirect()->to('/admin/books');
        }
    }

    public function book_delete($id)
    {
        $this->adminModel->delete_book($id);
        $this->session->setFlashdata('success', 'Book deleted');
        return redirect()->to('/admin/books');
    }

    /*================ EBOOKS ===================*/
    public function ebooks()
    {
        $view['ebooks'] = $this->adminModel->getEbooks();
        $view['admin_view'] = "admin/ebooks";
        echo view('layouts/admin_layout', $view);
    }

    public function add_ebooks()
    {
        $view['category'] = $this->adminModel->getCategory();

        $rules = [
            'ebook_name'  => 'required',
            'description' => 'required|min_length[100]',
            'author'      => 'required',
            'categoryId'  => 'required'
        ];

        $file = $this->request->getFile('ebook_file');

        if (!$this->validate($rules) || !$file->isValid()) {
            $view['admin_view'] = "admin/add_ebooks";
            echo view('layouts/admin_layout', $view);
        } else {
            $file->move(WRITEPATH.'uploads/files/');
            $this->adminModel->add_ebooks($this->request->getPost(), $file->getName());
            $this->session->setFlashdata('success', 'Ebook added successfully');
            return redirect()->to('/admin/ebooks');
        }
    }

    public function ebook_view($id)
    {
        $view['ebook_detail'] = $this->adminModel->getEbookDetail($id);
        $view['admin_view'] = $view['ebook_detail'] ? "admin/ebook_view" : "temp/404page";
        echo view('layouts/admin_layout', $view);
    }

    public function delete_ebook($id)
    {
        $this->adminModel->delete_ebook($id);
        $this->session->setFlashdata('success', 'Ebook deleted');
        return redirect()->to('/admin/ebooks');
    }

    /*================ ORDERS ===================*/
    public function orders()
    {
        $view['orders'] = $this->adminModel->getOrders();
        $view['admin_view'] = "admin/display_orders";
        echo view('layouts/admin_layout', $view);
    }

    public function order_view($orderId)
    {
        $view['order_detail'] = $this->adminModel->getOrderDetail($orderId);
        $view['admin_view'] = $view['order_detail'] ? "admin/order_detail" : "temp/404page";
        echo view('layouts/admin_layout', $view);
    }

    public function acceptorder($orderId)
    {
        if ($this->adminModel->acceptOrder($orderId, $this->request->getPost())) {
            $this->session->setFlashdata('success', 'Order accepted');
            return redirect()->to("/admin/order_view/$orderId");
        }
    }

    public function delete_order($orderId)
    {
        $this->adminModel->deleteOrder($orderId);
        $this->session->setFlashdata('success', 'Order deleted');
        return redirect()->to('/admin/orders');
    }

    /*================ DELIVERY ===================*/
    public function ready_to_deliver()
    {
        $view['orders'] = $this->adminModel->getOrdersToDeliver();
        $view['admin_view'] = "admin/ready_to_deliver";
        echo view('layouts/admin_layout', $view);
    }

    public function delivery_details($orderId)
    {
        $view['order_detail'] = $this->adminModel->getOrderDetail($orderId);
        $view['admin_view'] = $view['order_detail'] ? "admin/delivery_details" : "temp/404page";
        echo view('layouts/admin_layout', $view);
    }

    public function confirm_delivery($orderId)
    {
        if ($this->adminModel->confirmDelivery($orderId, $this->request->getPost())) {
            $this->session->setFlashdata('success', 'Delivery confirmed');
            return redirect()->to('/admin/ready_to_deliver');
        }
    }

    public function cancel_delivery($orderId)
    {
        if ($this->adminModel->cancel_delivery($orderId, $this->request->getPost())) {
            $this->session->setFlashdata('success', 'Delivery cancelled');
            return redirect()->to('/admin/ready_to_deliver');
        }
    }



public function settings()
{
    $model = new \App\Models\SettingsModel();

    // Default keys
    $defaultKeys = [
        'site_name',
        'meta_title',
        'meta_description',
        'contact_email',
        'contact_phone',
        'address',
        'currency',
        'shipping_cost'
    ];

    if ($this->request->getMethod() === 'post') {
        $keys = $this->request->getPost('setting_key');
        $values = $this->request->getPost('setting_value');

        if (is_array($keys) && is_array($values)) {
            foreach ($keys as $i => $key) {
                $key = trim($key);
                if ($key === '') continue; // skip empty keys
                $value = $values[$i] ?? '';
                $model->saveSetting($key, $value);
            }
        }

        return redirect()->to(current_url())->with('success', 'Settings updated successfully.');
    }

    // GET request - fetch existing settings
    $settings = $model->findAll();
    $existingKeys = array_column($settings, 'setting_key');

    // Add default keys that are not already in DB
    foreach ($defaultKeys as $key) {
        if (!in_array($key, $existingKeys)) {
            $settings[] = [
                'setting_key' => $key,
                'setting_value' => ''
            ];
        }
    }

    $data['settings'] = $settings;
    $data['admin_view'] = "admin/settings";
    echo view('layouts/admin_layout', $data);
}
}

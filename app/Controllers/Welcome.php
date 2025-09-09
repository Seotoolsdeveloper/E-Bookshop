<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Welcome extends BaseController
{
    public function index()
    {
        echo view('welcome_message');
    }
}

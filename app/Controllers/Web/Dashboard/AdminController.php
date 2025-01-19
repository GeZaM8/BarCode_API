<?php

namespace App\Controllers\Web\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    public function index()
    {
        return view('dashboard/admin_home', [
            'title' => 'Admin',
            'current_page' => 'home',
        ]);
    }

    public function presence()
    {


        return view('dashboard/admin_presence', [
            'title' => 'Admin',
            'current_page' => 'presence',
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/web');
    }
}

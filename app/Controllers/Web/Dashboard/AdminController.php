<?php

namespace App\Controllers\Web\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $absenModel;
    protected $kelasModel;
    protected $userModel;
    protected $userRole;
    protected $jurusanModel;

    public function __construct()
    {
        helper('weburl');
        $this->absenModel   = new \App\Models\Absensi();
        $this->kelasModel   = new \App\Models\Kelas();
        $this->userModel    = new \App\Models\User();
        $this->userRole     = new \App\Models\UserRole();
        $this->jurusanModel = new \App\Models\Jurusan();
    }

    public function index()
    {
        return view('dashboard/admin_home', [
            'title' => 'Admin',
            'current_page' => 'home',
            'users_count' => $this->userModel->countAllResults(),
            'kelas_count' => $this->kelasModel->countAllResults(),
            'jurusan_count' => $this->jurusanModel->countAllResults(),
        ]);
    }

    public function presence()
    {
        $data_yer = $this->absenModel->select("MIN(year(tanggal)) as start_year, MAX(year(tanggal)) as end_year")->first();
        $class = $this->kelasModel->findAll();

        return view('dashboard/admin_presence', [
            'title' => 'Admin',
            'current_page' => 'presence',
            'start_year' => $data_yer->start_year ?? date("Y"),
            'end_year' => $data_yer->end_year ?? date("Y"),
            'class' => $class,
        ]);
    }

    public function users()
    {
        return view('dashboard/admin_users', [
            'title' => 'Admin',
            'current_page' => 'data.users',
            'roles' => $this->userRole->findAll(),
        ]);
    }

    public function kelas()
    {
        return view('dashboard/admin_kelas', [
            'title' => 'Admin',
            'current_page' => 'data.kelas',
        ]);
    }

    public function jurusan()
    {
        return view('dashboard/admin_jurusan', [
            'title' => 'Admin',
            'current_page' => 'data.jurusan',
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/web');
    }
}

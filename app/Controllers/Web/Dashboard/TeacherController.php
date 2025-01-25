<?php

namespace App\Controllers\Web\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TeacherController extends BaseController
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
        return view('dashboard/teacher_home', [
            'title' => 'Teacher',
            'current_page' => 'home',
            'users_count' => $this->userModel->countAllResults(),
            'kelas_count' => $this->kelasModel->countAllResults(),
            'jurusan_count' => $this->jurusanModel->countAllResults(),
        ]);
    }
}

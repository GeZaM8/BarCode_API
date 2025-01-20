<?php

namespace App\Controllers\Web\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminController extends BaseController
{
    protected $absenModel;
    protected $kelasModel;
    protected $userModel;

    public function __construct()
    {
        helper('weburl');
        $this->absenModel = new \App\Models\Absensi();
        $this->kelasModel = new \App\Models\Kelas();
        $this->userModel = new \App\Models\User();
    }

    public function index()
    {
        return view('dashboard/admin_home', [
            'title' => 'Admin',
            'current_page' => 'home',
        ]);
    }

    public function presence()
    {
        $data_yer = $this->absenModel->select("MIN(year(tanggal)) as start_year, MAX(year(tanggal)) as end_year")->first();
        $class = $this->kelasModel->findAll();

        return view('dashboard/admin_presence', [
            'title' => 'Admin',
            'current_page' => 'presence',
            'start_year' => $data_yer->start_year,
            'end_year' => $data_yer->end_year,
            'class' => $class,
        ]);
    }

    public function getPresence()
    {
        $year = $this->request->getVar('year');
        $month = $this->request->getVar('month');
        $day = $this->request->getVar('day');
        $class = $this->request->getVar('kelas');

        if ($year && $month && $day) {
            $userFilter = $this->userModel->getUsersWithDetails()->where("u.id_role", "1");

            if ($class) {
                $userFilter->where("kelas", $class);
            }
            $userFilter = $userFilter->orderBy('kelas', "ASC")->orderBy("no_absen", "ASC")->get()->getResultObject();
        }

        $result = $this->absenModel->withDetailUsers()->select("*, month(tanggal) as bulan, year(tanggal) as tahun");


        if ($year) {
            $result->where("year(tanggal)", $year);
        }
        if ($month) {
            $result->where("month(tanggal)", $month);
        }
        if ($day) {
            $result->where("day(tanggal)", $day);
        }
        if ($class) {
            $result->where("kelas", $class);
        }

        $payload = [
            "student" => $userFilter ?? [],
            "presence" => $result->orderBy('kelas', "ASC")->orderBy("tanggal", "DESC")->orderBy("no_absen", "ASC")->findAll(),
        ];

        return $this->respond($payload);
    }

    public function users()
    {
        return view('dashboard/admin_users', [
            'title' => 'Admin',
            'current_page' => 'users',
        ]);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/web');
    }
}

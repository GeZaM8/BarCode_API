<?php

namespace App\Controllers\Web\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AdminBackendController extends BaseController
{
    protected $absenModel;
    protected $kelasModel;
    protected $userModel;
    protected $userRole;
    protected $jurusanModel;

    public function __construct()
    {
        $this->absenModel   = new \App\Models\Absensi();
        $this->kelasModel   = new \App\Models\Kelas();
        $this->userModel    = new \App\Models\User();
        $this->userRole     = new \App\Models\UserRole();
        $this->jurusanModel = new \App\Models\Jurusan();
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

    public function getUsers()
    {
        $role  = $this->request->getVar('role');
        $class = $this->request->getVar('kelas');

        $builder = $this->userModel->getUsersWithDetails();

        if ($role) {
            $builder->where("u.id_role", $role)->orderBy("kelas", "ASC")->orderBy("no_absen", "ASC");

            if ($role == 1)
                if ($class)
                    $builder->where("kelas", $class);
        }

        $payload = [
            "type"  => $role,
            "users" => $builder->get()->getResultObject(),
        ];

        return $this->respond($payload);
    }

    public function getKelas()
    {
        $kelas = $this->kelasModel->findAll();
        return $this->respond($kelas);
    }

    public function getJurusan()
    {
        $jurusan = $this->jurusanModel->findAll();
        return $this->respond($jurusan);
    }
}

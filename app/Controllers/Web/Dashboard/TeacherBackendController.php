<?php

namespace App\Controllers\Web\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class TeacherBackendController extends BaseController
{
    protected $absenModel;
    protected $kelasModel;
    protected $userModel;
    protected $userSiswaModel;
    protected $userGuruModel;
    protected $userRole;
    protected $jurusanModel;

    public function __construct()
    {
        $this->absenModel   = new \App\Models\Absensi();
        $this->kelasModel   = new \App\Models\Kelas();
        $this->userModel    = new \App\Models\User();
        $this->userRole     = new \App\Models\UserRole();
        $this->jurusanModel = new \App\Models\Jurusan();

        $this->userSiswaModel = new \App\Models\USiswa();
        $this->userGuruModel  = new \App\Models\UGuru();
    }


    // ======================================================================
    // Get Data
    // ======================================================================

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

        $result = $this->absenModel->withDetailUsers();


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

    public function getPresenceDetail($id)
    {
        $result = $this->absenModel->withDetailUsers()->where("id_absensi", $id)->first();

        return $this->respond($result);
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
                    $builder->where("k.id_kelas", $class);
        }

        $payload = [
            "type"  => $role,
            "users" => $builder->get()->getResultObject(),
        ];

        return $this->respond($payload);
    }

    public function getKelas($id = null)
    {
        if ($id) {
            $kelas = $this->kelasModel->find($id);
        } else {
            $kelas = $this->kelasModel->orderBy('kelas', 'ASC')->findAll();
        }

        return $this->respond($kelas);
    }

    public function getJurusan($id = null)
    {
        if ($id) {
            $jurusan = $this->jurusanModel->find($id);
        } else {
            $jurusan = $this->jurusanModel->orderBy('nama_jurusan', 'ASC')->findAll();
        }
        return $this->respond($jurusan);
    }
}

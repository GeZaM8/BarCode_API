<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\USiswa;
use Exception;

class Auth extends BaseController
{
    public function login()
    {
        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        $userModel = new User();
        $user = $userModel->getUsersWithDetails()->where("email", $email)->where("u.id_role", 1)->get()->getRowObject();

        if (!$user)
            return $this->fail("Email atau Password Salah");
        if ($user->password == $password) {
            return $this->respond($user);
        } else {
            return $this->fail("Email atau Password Salah Woi");
        }
    }

    public function registerSiswa()
    {
        $dataUser = [
            "email" => $this->request->getVar("email"),
            "password" => $this->request->getVar("password"),
            "id_role" => "1"
        ];

        $db = \Config\Database::connect();
        $db->transBegin();

        $userModel = new User();
        $siswaModel = new USiswa();

        $insertUser = $userModel->insert($dataUser);

        if ($insertUser) {
            $dataSiswa = [
                "id_user" => $insertUser,
                "nama" => $this->request->getVar("nama"),
                "id_kelas" => $this->request->getVar("kelas"),
                "kode_jurusan" => $this->request->getVar("kode_jurusan"),
                "no_absen" => $this->request->getVar("no_absen"),
                "nis" => $this->request->getVar("nis"),
                "nisn" => $this->request->getVar("nisn")
            ];

            $insertSiswa = $siswaModel->insert($dataSiswa);

            if ($insertSiswa) {
                $db->transCommit();
                return $this->respond(['messages' => "Register Berhasil"]);
            } else {
                $db->transRollback();
                return $this->fail(['messages' => $siswaModel->errors()]);
            }
        } else {
            $db->transRollback();
            return $this->fail("Email sudah Terdaftar");
        }
    }
}

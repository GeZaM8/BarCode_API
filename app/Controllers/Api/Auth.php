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
        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        $nama = $this->request->getVar("nama");
        $kelas = $this->request->getVar("kelas");
        $kode_jusursan = $this->request->getVar("kode_jurusan");
        $no_absen = $this->request->getVar("no_absen");
        $nis = $this->request->getVar("nis");
        $nisn = $this->request->getVar("nisn");

        $dataUser = [
            "email" => $email,
            "password" => $password,
            "id_role" => "1"
        ];

        $userModel = new User();

        $db = \Config\Database::connect();
        $db->transBegin();

        $insertUser = $userModel->insert($dataUser);

        if ($insertUser) {
            $dataSiswa = [
                "id_user" => $insertUser,
                "nama" => $nama,
                "kelas" => $kelas,
                "kode_jurusan" => $kode_jusursan,
                "no_absen" > $no_absen,
                "nis" => $nis,
                "nisn" => $nisn
            ];

            $siswaModel = new USiswa();
            $insertSiswa = $siswaModel->insert($dataSiswa);

            if ($insertSiswa) {
                $db->transCommit();
                return $this->respond(['messages' => "Register Berhasil"]);
            } else {
                $db->transRollback();
                return $this->fail("NIS, NISN, atau Nomor Absen Terdaftar");
            }
        } else {
            $db->transRollback();
            return $this->fail("Email sudah Terdaftar");
        }
    }
}

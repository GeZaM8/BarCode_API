<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\USiswa;
use Exception;

class Auth extends BaseController
{
    protected $siswaModel;
    protected $userModel;

    public function __construct()
    {
        $this->siswaModel = new USiswa();
        $this->userModel = new User();
    }
    public function login()
    {
        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        $user = $this->userModel->getUsersWithDetails()->where("email", $email)->where("u.id_role", 1)->get()->getRowObject();

        if (!$user)
            return $this->fail("Email atau Password Salah");
        if ($user->password == $password) {
            return $this->respond($user);
        } else {
            return $this->fail("Email atau Password Salah Woi");
        }
    }

    public function aktivasiSiswa()
    {
        $nis = $this->request->getVar("nis");
        $nisn = $this->request->getVar("nisn");

        $dataUpdate = [
            "email" => $this->request->getVar("email"),
            "password" => $this->request->getVar("password"),
        ];

        $siswa = $this->siswaModel->getSiswaWithDetails()->where(["nis" => $nis, "nisn" => $nisn])->first();
        if (!empty($siswa->email))
            return $this->fail("Akun ini sudah diaktivasi");
        if (empty($siswa))
            return $this->fail("Tidak ditemukan siswa dengan NIS: $nis dan NISN: $nisn\nHubungi operator untuk pembuatan akun");
        $userUpdate = $this->userModel->update($siswa->id_user, $dataUpdate);

        if ($userUpdate)
            return $this->respond(["messages" => "Aktivasi Berhasil"]);
        else
            return $this->fail("Terjadi kesalahan saat aktivasi");
    }
}

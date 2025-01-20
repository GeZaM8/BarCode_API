<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\USiswa;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function updateUser()
    {
        $id_user = $this->request->getVar("id_user");
        $email = $this->request->getVar("email");

        $nama = $this->request->getVar("nama");
        $kelas = $this->request->getVar("kelas");
        $no_absen = $this->request->getVar("no_absen");
        $nis = $this->request->getVar("nis");
        $nisn = $this->request->getVar("nisn");

        $img = $this->request->getFile("foto");

        $newName = $img->getRandomName();
        $img->move(APPPATH . "public/upload", $newName);

        return $this->respond(["foto" => $img->getName()]);
        $dataUser = [
            "email" => $email
        ];
        $dataSiswa = [
            "nama" => $nama,
            "kelas" => $kelas,
            "no_absen" => $no_absen,
            "nis" => $nis,
            "nisn" => $nisn,
        ];

        $userModel = new User();
        $siswaModel = new USiswa();

        $updateSiswa = $siswaModel->update(['id_user' => $id_user], $dataSiswa);

        if ($updateSiswa) {
            $updateUser = $userModel->update(['id_user' => $id_user], $dataUser);
            if ($updateUser) {
                return $this->respond(["messages" => "Update Berhasil"]);
            } else {
                return $this->fail("Email sudah Terdaftar");
            }
        } else {
            return $this->fail("NIS, NISN, atau Nomor Absen sudah Terdaftar");
        }
    }
}

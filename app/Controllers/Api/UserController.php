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

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
        $extension = $img->getExtension();
        // return $this->respond(["a" => $extension])

        if (!in_array($extension, $allowedExtensions)) {
            return $this->fail("Gambar hanya boleh png, jpg, jpeg, dan webp");
        }

        $dataUser = [
            "email" => $email
        ];
        $dataSiswa = [
            "nama" => $nama,
            "id_kelas" => $kelas,
            "no_absen" => $no_absen,
            "nis" => $nis,
            "nisn" => $nisn,
            "foto" => $newName
        ];

        $userModel = new User();
        $siswaModel = new USiswa();

        $updateSiswa = $siswaModel->update(['id_user' => $id_user], $dataSiswa);

        if ($updateSiswa) {
            $updateUser = $userModel->update(['id_user' => $id_user], $dataUser);
            if ($updateUser) {
                $img->move(ROOTPATH . "public/assets/upload", $newName);
                return $this->respond(["messages" => "Update Berhasil"]);
            } else {
                return $this->fail("Email sudah Terdaftar");
            }
        } else {
            return $this->fail("NIS, NISN, atau Nomor Absen sudah Terdaftar");
        }
    }
}

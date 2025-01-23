<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\User;
use App\Models\USiswa;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends BaseController
{
    public function getSiswa($id)
    {
        $siswaModel = new USiswa();

        $siswa = $siswaModel->getSiswaWithDetails()->where("u_siswa.id_user", $id)->first();

        return $this->respond($siswa);
    }
    public function updateUser()
    {
        $data = $this->request->getVar("data");
        $dataJson = json_decode($data);

        $id_user = $this->request->getVar("id_user");
        $email = $this->request->getVar("email");

        $id_user = $dataJson->id_user;
        $email = $dataJson->email;
        $nama = $dataJson->nama;
        $kelas = $dataJson->kelas;
        $no_absen = $dataJson->absen;  // Ensure the field name is correct
        $nis = $dataJson->nis;
        $nisn = $dataJson->nisn;
        $img = $this->request->getFile("foto");

        $newName = $img->getRandomName();

        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
        $extension = $img->getExtension();

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
                $img->move(base_url("assets/upload"), $newName);
                return $this->respond(["messages" => "Update Berhasil"]);
            } else {
                return $this->fail("Email sudah Terdaftar");
            }
        } else {
            return $this->fail("NIS, NISN, atau Nomor Absen sudah Terdaftar");
        }
    }
}

<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use Exception;

class SiswaController extends BaseController
{
    protected $userModel;
    protected $siswaModel;
    protected $kelasModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\User();
        $this->siswaModel = new \App\Models\USiswa();
        $this->kelasModel = new \App\Models\Kelas();
    }

    public function updateSiswa()
    {
        $data = $this->request->getVar("data");
        $dataJson = json_decode($data);

        $id_user = $dataJson->id_user;
        $email = $dataJson->email;
        $nama = $dataJson->nama;
        $kelas = $dataJson->kelas;
        $no_absen = $dataJson->absen;
        $nis = $dataJson->nis;
        $nisn = $dataJson->nisn;
        $id_kelas = $this->kelasModel->where("kelas", $kelas)->first()->id_kelas;
        if (empty($id_kelas)) return $this->fail("Kelas tidak ditemukan");

        $img = $this->request->getFile("foto");
        $photoOld = $this->siswaModel->where("id_user", $id_user)->first()->foto;
        $photo = $img->getRandomName();
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
            "id_kelas" => $id_kelas,
            "no_absen" => $no_absen,
            "nis" => $nis,
            "nisn" => $nisn,
            "foto" => $photo
        ];

        $updateSiswa = $this->siswaModel->update($id_user, $dataSiswa);

        if ($updateSiswa) {
            $img->move("assets/upload/profile/", $photo);

            try {
                if (!empty($photoOld))
                    unlink("assets/upload/profile/" . $photoOld);
            } catch (Exception $e) {
            }

            $updateUser = $this->userModel->update(['id_user' => $id_user], $dataUser);
            if ($updateUser) {
                return $this->respond(["messages" => "Update Berhasil"]);
            } else {
                return $this->fail("Email sudah Terdaftar");
            }
        } else {
            return $this->fail("NIS, NISN, atau Nomor Absen sudah Terdaftar");
        }
    }

    public function getSiswa($id)
    {
        $siswa = $this->siswaModel->getSiswaWithDetails()->where("u_siswa.id_user", $id)->first();
        $siswa->foto = base_url("assets/upload/profile/" . $siswa->foto);

        return $this->respond($siswa);
    }
}

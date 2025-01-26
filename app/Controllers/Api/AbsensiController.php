<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Absensi;
use App\Models\QRCode;
use Exception;

class AbsensiController extends BaseController
{
    protected $absensiModel;
    protected $qrcodeModel;

    public function __construct()
    {
        $this->absensiModel = new Absensi();
        $this->qrcodeModel = new QRCode();
    }

    public function setAbsensi()
    {
        $data = $this->request->getVar("data");
        $dataJson = json_decode($data);

        $id_user = $dataJson->id_user;
        $jwt = $dataJson->qrcode;

        $qrcode = new QRCode();

        if ($qrcode->orderBy("id_qrcode", "DESC")->first()->key_qrcode != $jwt) {
            return $this->fail("QRCode invalid/expire");
        };

        $time = time();

        $absensiBefore = $this->absensiModel->where("id_user", $id_user)->where('tanggal', date("Y-m-d", $time))->first();
        if ($absensiBefore) {
            return $this->fail("Anda sudah absen hari ini");
        }

        $status = $dataJson->status;
        $mood = $dataJson->mood;
        $reason = $dataJson->reason;

        $tanggal = date("Y-m-d", $time);
        $timestamp = date("H:i:s", $time);

        $img = $this->request->getFile("foto");
        $photo = $img->getRandomName();
        $allowedExtensions = ['png', 'jpg', 'jpeg', 'webp'];
        $extension = $img->getExtension();
        if (!in_array($extension, $allowedExtensions)) {
            return $this->fail("Gambar hanya boleh png, jpg, jpeg, dan webp");
        }

        $data = [
            'id_user' => $id_user,
            'status' => $status,
            'mood' => $mood,
            'reason' => $reason,
            'tanggal' => $tanggal,
            'timestamp' => $timestamp,
            'foto' => $photo
        ];
        $result = $this->absensiModel->insert($data);

        if ($result) {
            $img->move("assets/upload/absensi", $photo);
            return $this->respond(['messages' => "Anda Berhasil Absensi"]);
        } else {
            return $this->fail("Anda Gagal Absensi");
        }
    }

    public function getAbsensi($id_user = null, $id_absensi = null)
    {
        $absensi = $this->absensiModel->withDetailUsers()->orderBy("tanggal", "DESC");
        if ($id_absensi != null) {
            $absensiUser = $absensi->where(["absensi.id_user" => $id_user, "id_absensi" => $id_absensi])->first();
            $absensiUser->hari = date('l', strtotime($absensiUser->tanggal));

            $absensiUser->foto = base_url("assets/upload/absensi/" . $absensiUser->foto);

            return $this->respond($absensiUser);
        } elseif ($id_user != null) {
            $absensiUser = $absensi->where("absensi.id_user", $id_user)->findAll();
        } else {
            $absensiUser = $absensi->findAll();
        }

        array_map(function ($item) {
            $item->hari = date('l', strtotime($item->tanggal));
            $item->foto = base_url("assets/upload/absensi/" . $item->foto);
            return $item;
        }, @$absensiUser);

        return $this->respond($absensiUser);
    }

    public function validateQRCode()
    {
        $jwt = $this->request->getVar("qrcode");

        if ($this->qrcodeModel->orderBy("id_qrcode", "DESC")->first()->key_qrcode != $jwt) {
            return $this->fail("QRCode invalid/expire");
        }
        return $this->respond(["messages" => "Anda berhasil melakukan this->absensiModel"]);
    }
}

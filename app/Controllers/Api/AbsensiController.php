<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Absensi;
use App\Models\QRCode;

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
        $jwt = $this->request->getVar("qrcode");
        $id_user = $this->request->getVar("id_user");

        $qrcode = new QRCode();

        if ($qrcode->orderBy("id_qrcode", "DESC")->first()->key_qrcode != $jwt) {
            return $this->fail("QRCode invalid/expire");
        };

        $time = time();

        $absensiBefore = $this->absensiModel->where("id_user", $id_user)->where('tanggal', date("Y-m-d", $time))->first();
        if ($absensiBefore) {
            return $this->fail("Anda sudah absen hari ini");
        }

        $id_user = $this->request->getVar("id_user");
        $status = $this->request->getVar("status");
        $mood = $this->request->getVar("mood");
        $reason = $this->request->getVar("reason");

        $tanggal = date("Y-m-d", $time);
        $timestamp = date("H:i:s", $time);
        // return $this->respond(["tanggal" => $tanggal, "timestamp" => $timestamp]);

        $data = [
            'id_user' => $id_user,
            'status' => $status,
            'mood' => $mood,
            'reason' => $reason,
            'tanggal' => $tanggal,
            'timestamp' => $timestamp
        ];
        $result = $this->absensiModel->insert($data);

        if ($result) {
            return $this->respond(['messages' => "Anda Berhasil Absensi"]);
        } else {
            return $this->fail("Anda Gagal Absensi");
        }
    }

    public function getAbsensi($id_user = null)
    {
        if ($id_user != null) {
            $absensiUser = $this->absensiModel->where("id_user", $id_user)->findAll();
        } else {
            $absensiUser = $this->absensiModel->findAll();
        }

        array_map(function ($item) {
            $item->hari = date('l', strtotime($item->tanggal));
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

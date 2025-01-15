<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Absensi;
use App\Models\QRCode;
use CodeIgniter\HTTP\ResponseInterface;

class AbsensiController extends BaseController
{
    public function setAbsensi()
    {
        $jwt = $this->request->getVar("qrcode");

        $qrcode = new QRCode();

        if ($qrcode->orderBy("id_qrcode", "DESC")->first()->key_qrcode != $jwt) {
            return $this->fail("QRCode invalid/expire");
        };

        $absensi = new Absensi();
        $time = time();

        $absensiBefore = $absensi->where('tanggal', date("Y-m-d", $time));
        if ($absensiBefore) {
            return $this->fail("Anda sudah absen hari ini");
        }

        $id_user = $this->request->getVar("id_user");
        $status = $this->request->getVar("status");
        $mood = $this->request->getVar("mood");
        $reason = $this->request->getVar("reason");

        $tanggal = date("Y-m-d", $time);
        $timestamp = date("H:i:s", $time);

        $data = [
            'id_user' => $id_user,
            'status' => $status,
            'mood' => $mood,
            'reason' => $reason,
            'tanggal' => $tanggal,
            'timestamp' => $timestamp
        ];
        $result = $absensi->insert($data);

        if ($result) {
            return $this->respond(['messages' => "Anda Berhasil Absensi"]);
        } else {
            return $this->fail("Anda Gagal Absensi");
        }
    }

    public function getAbsensi($id_user = null)
    {
        $absensi = new Absensi();

        if ($id_user != null) {
            $absensiUser = $absensi->where("id_user", $id_user)->findAll();
        } else {
            $absensiUser = $absensi->findAll();
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

        $qrcode = new QRCode();

        if ($qrcode->orderBy("id_qrcode", "DESC")->first()->key_qrcode != $jwt) {
            return $this->fail("QRCode invalid/expire");
        }
        return $this->respond(["messages" => "Anda berhasil melakukan absensi"]);
    }
}

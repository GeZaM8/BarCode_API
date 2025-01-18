<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use chillerlan\QRCode\QRCode;
use Faker\Factory;
use Firebase\JWT\JWT;

class QRCodeController extends BaseController
{
    public function index()
    {
        $key = getenv("jwt_key");

        $qrCode = new \App\Models\QRCode();

        $dataBefore = $qrCode->where('tanggal_aktif', date("Y-m-d", time()))->first();

        if (!$dataBefore) {
            $faker = Factory::create();
            $uuid = $faker->uuid;
            $tanggal = date("Y-m-d", time());

            $barcodeData = [
                "data" => $uuid,
                "tanggal" => $tanggal,
            ];

            $jwt = JWT::encode($barcodeData, $key, 'HS256');
            $qrCode->insert([
                'key_qrcode' => $jwt,
                'tanggal_aktif' => $tanggal,
            ]);
        } else {
            $jwt = $dataBefore->key_qrcode;
        }

        $data = [
            "image" => (new QRCode)->render($jwt)
        ];
        return view("barcode_renderer", $data);
    }
}

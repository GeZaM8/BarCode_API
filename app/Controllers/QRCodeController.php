<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use chillerlan\QRCode\Common\EccLevel;
use chillerlan\QRCode\Data\QRMatrix;
use chillerlan\QRCode\Output\QROutputInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Faker\Factory;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use QRSvgWithLogo;
use SVGWithLogoOptions;

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

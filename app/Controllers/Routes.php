<?php

use App\Controllers\AbsensiController;
use App\Controllers\Auth;
use App\Controllers\Home;
use App\Controllers\QRCodeController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('/', ['filter' => "api"], static function ($routes) {
    $routes->get("/woi", [Home::class, "registerUser"]);

    $routes->post("/login", [Auth::class, "login"]);
    $routes->post("/absensi", [AbsensiController::class, "setAbsensi"]);

    $routes->get("/absensi/(:num)", [AbsensiController::class, "getAbsensi/$1"]);
    $routes->get("/absensi", [AbsensiController::class, "getAbsensi"]);
});
$routes->get('/', [Home::class, "index"]);
$routes->get("/qrcode", [QRCodeController::class, "index"]);

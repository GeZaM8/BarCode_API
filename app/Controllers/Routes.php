<?php

use App\Controllers\Api\AbsensiController;
use App\Controllers\Api\Auth;
use App\Controllers\Api\QRCodeController;
use App\Controllers\Web\AuthController;
use App\Controllers\Web\Dashboard\HomeController;
use App\Controllers\Web\Home;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', static function () {
    return redirect()->to("/web");
});

//============================================//
// Api Route
//============================================//

$routes->group('/', ['filter' => "api"], static function ($routes) {
    $routes->post("/login", [Auth::class, "login"]);
    $routes->post("/register", [Auth::class, "registerSiswa"]);
    $routes->post("/absensi", [AbsensiController::class, "setAbsensi"]);
    $routes->post("/validate/qrcode", [AbsensiController::class, "validateQRCode"]);

    $routes->get("/absensi/(:num)", [AbsensiController::class, "getAbsensi/$1"]);
    $routes->get("/absensi", [AbsensiController::class, "getAbsensi"]);
});

//============================================//
// Web Route
//============================================//

$routes->group("web", static function (RouteCollection $routes) {
    $routes->get('/', [AuthController::class, "login_page"], ['filter' => 'UserAccess']);
    $routes->post('login', [AuthController::class, "login"]);

    $routes->group("admin", ['filter' => 'DashboardAccess:3'], static function (RouteCollection $routes) {
        $routes->get("/", [HomeController::class, "index"]);
    });
    $routes->group("teacher", ['filter' => 'DashboardAccess:2'], static function (RouteCollection $routes) {
        $routes->get("/", [HomeController::class, "index"]);
    });
});
$routes->get("qrcode", [QRCodeController::class, "index"], ['filter' => 'DashboardAccess:2,3']);

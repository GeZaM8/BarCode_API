<?php

use App\Controllers\Api\AbsensiController;
use App\Controllers\Api\Auth;
use App\Controllers\Api\QRCodeController;
use App\Controllers\Api\UserController;
use App\Controllers\Web\AuthController;
use App\Controllers\Web\Dashboard\AdminBackendController;
use App\Controllers\Web\Dashboard\AdminController;
use App\Controllers\Web\Dashboard\TeacherController;
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

$routes->group('/', ['filter' => "api"], static function (RouteCollection $routes) {
    $routes->post("/login", [Auth::class, "login"]);
    $routes->post("/register", [Auth::class, "registerSiswa"]);
    $routes->post("/absensi", [AbsensiController::class, "setAbsensi"]);
    $routes->post("/validate/qrcode", [AbsensiController::class, "validateQRCode"]);

    $routes->get("/absensi/(:num)", [AbsensiController::class, "getAbsensi/$1"]);
    $routes->get("/absensi", [AbsensiController::class, "getAbsensi"]);

    $routes->post("/update/siswa", [UserController::class, "updateUser"]);
});

//============================================//
// Web Route
//============================================//

$routes->get("qrcode", [QRCodeController::class, "index"], ['filter' => 'DashboardAccess:2,3']);

$routes->group("web", static function (RouteCollection $routes) {
    $routes->get('/', [AuthController::class, "login_page"], ['filter' => 'UserAccess']);
    $routes->post('login', [AuthController::class, "login"]);

    $routes->group("admin", ['filter' => 'DashboardAccess:3'], static function (RouteCollection $routes) {
        $routes->get("/", [AdminController::class, "index"]);
        $routes->get("presence", [AdminController::class, "presence"]);
        $routes->get("users", [AdminController::class, "users"]);
        $routes->get("kelas", [AdminController::class, "kelas"]);
        $routes->get("jurusan", [AdminController::class, "jurusan"]);
        $routes->get("logout", [AdminController::class, "logout"]);

        $routes->group("api", static function (RouteCollection $routes) {
            $routes->get("get-presence", [AdminBackendController::class, "getPresence"]);
            $routes->get("get-users", [AdminBackendController::class, "getUsers"]);
            $routes->get("get-kelas/(:num)", [AdminBackendController::class, "getKelas/$1"]);
            $routes->get("get-kelas", [AdminBackendController::class, "getKelas"]);
            $routes->get("get-jurusan", [AdminBackendController::class, "getJurusan"]);

            $routes->post("edit-kelas/(:num)", [AdminBackendController::class, "editKelas/$1"]);
        });
    });
    $routes->group("teacher", ['filter' => 'DashboardAccess:2'], static function (RouteCollection $routes) {
        $routes->get("/", [TeacherController::class, "index"]);
        $routes->get("logout", [TeacherController::class, "logout"]);
    });
});

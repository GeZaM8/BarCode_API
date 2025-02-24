<?php

use App\Controllers\Api\AbsensiController;
use App\Controllers\Api\Auth;
use App\Controllers\Api\KelasController;
use App\Controllers\Api\QRCodeController;
use App\Controllers\Api\SiswaController;
use App\Controllers\Api\UserController;
use App\Controllers\Web\AuthController;
use App\Controllers\Web\Dashboard\AdminBackendController;
use App\Controllers\Web\Dashboard\AdminController;
use App\Controllers\Web\Dashboard\TeacherBackendController;
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
    $routes->post("/aktivasi", [Auth::class, "aktivasiSiswa"]);

    $routes->post("/validate/qrcode", [AbsensiController::class, "validateQRCode"]);

    $routes->post("/absensi", [AbsensiController::class, "setAbsensi"]);
    $routes->get("/absensi/(:num)/(:num)", [[AbsensiController::class, "getAbsensi"], '$1/$2']);
    $routes->get("/absensi/(:num)", [[AbsensiController::class, "getAbsensi"], '$1']);
    $routes->get("/absensi", [AbsensiController::class, "getAbsensi"]);

    $routes->get("/siswa/(:num)", [[SiswaController::class, "getSiswa"], '$1']);
    $routes->post("/update/siswa", [SiswaController::class, "updateSiswa"]);

    $routes->get("/kelas", [KelasController::class, "getKelas"]);
});

//============================================//
// Web Route
//============================================//

$routes->get("qrcode", [QRCodeController::class, "index"]);

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
            $routes->get("get-presence/(:num)", [AdminBackendController::class, "getPresenceDetail/$1"]);
            $routes->get("get-users", [AdminBackendController::class, "getUsers"]);
            $routes->get("get-kelas/(:num)", [AdminBackendController::class, "getKelas/$1"]);
            $routes->get("get-kelas", [AdminBackendController::class, "getKelas"]);
            $routes->get("get-jurusan/(:segment)", [AdminBackendController::class, "getJurusan/$1"]);
            $routes->get("get-jurusan", [AdminBackendController::class, "getJurusan"]);

            $routes->post("change-password-user", [AdminBackendController::class, "changePasswordUser"]);
            $routes->post("edit-kelas/(:num)", [AdminBackendController::class, "editKelas/$1"]);
            $routes->post("edit-jurusan/(:segment)", [AdminBackendController::class, "editJurusan/$1"]);

            $routes->post("add-users", [AdminBackendController::class, "addUser"]);
            $routes->post("add-kelas", [AdminBackendController::class, "addKelas"]);
            $routes->get("add-jurusan", [AdminBackendController::class, "addJurusan"]);

            $routes->post("add-users-xls", [AdminBackendController::class, "addUserExcel"]);

            $routes->delete("delete-users/(:num)", [AdminBackendController::class, "deleteUser/$1"]);
            $routes->delete("delete-kelas/(:num)", [AdminBackendController::class, "deleteKelas/$1"]);
            $routes->delete("delete-jurusan/(:segment)", [AdminBackendController::class, "deleteJurusan/$1"]);
        });
    });
    $routes->group("teacher", ['filter' => 'DashboardAccess:2'], static function (RouteCollection $routes) {
        $routes->get("/", [TeacherController::class, "index"]);
        $routes->get("logout", [TeacherController::class, "logout"]);
        $routes->get("presence", [TeacherController::class, "presence"]);
        $routes->get("users", [TeacherController::class, "users"]);
        $routes->get("kelas", [TeacherController::class, "kelas"]);
        $routes->get("jurusan", [TeacherController::class, "jurusan"]);
        $routes->get("logout", [TeacherController::class, "logout"]);

        $routes->group("api", static function (RouteCollection $routes) {
            $routes->get("get-presence", [TeacherBackendController::class, "getPresence"]);
            $routes->get("get-presence/(:num)", [TeacherBackendController::class, "getPresenceDetail/$1"]);
            $routes->get("get-users", [TeacherBackendController::class, "getUsers"]);
            $routes->get("get-kelas/(:num)", [TeacherBackendController::class, "getKelas/$1"]);
            $routes->get("get-kelas", [TeacherBackendController::class, "getKelas"]);
            $routes->get("get-jurusan/(:segment)", [TeacherBackendController::class, "getJurusan/$1"]);
            $routes->get("get-jurusan", [TeacherBackendController::class, "getJurusan"]);
        });
    });
});

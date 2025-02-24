<?php

namespace App\Controllers\Web\Dashboard;

use App\Controllers\BaseController;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\HTTP\ResponseInterface;

class AdminBackendController extends BaseController
{
    protected $absenModel;
    protected $kelasModel;
    protected $userModel;
    protected $userSiswaModel;
    protected $userGuruModel;
    protected $userRole;
    protected $jurusanModel;

    public function __construct()
    {
        $this->absenModel   = new \App\Models\Absensi();
        $this->kelasModel   = new \App\Models\Kelas();
        $this->userModel    = new \App\Models\User();
        $this->userRole     = new \App\Models\UserRole();
        $this->jurusanModel = new \App\Models\Jurusan();

        $this->userSiswaModel = new \App\Models\USiswa();
        $this->userGuruModel  = new \App\Models\UGuru();
    }


    // ======================================================================
    // Get Data
    // ======================================================================

    public function getPresence()
    {
        $year = $this->request->getVar('year');
        $month = $this->request->getVar('month');
        $day = $this->request->getVar('day');
        $class = $this->request->getVar('kelas');

        if ($year && $month && $day) {
            $userFilter = $this->userModel->getUsersWithDetails()->where("u.id_role", "1");

            if ($class) {
                $userFilter->where("kelas", $class);
            }
            $userFilter = $userFilter->orderBy('kelas', "ASC")->orderBy("no_absen", "ASC")->get()->getResultObject();
        }

        $result = $this->absenModel->withDetailUsers();


        if ($year) {
            $result->where("year(tanggal)", $year);
        }
        if ($month) {
            $result->where("month(tanggal)", $month);
        }
        if ($day) {
            $result->where("day(tanggal)", $day);
        }
        if ($class) {
            $result->where("kelas", $class);
        }

        $payload = [
            "student" => $userFilter ?? [],
            "presence" => $result->orderBy('kelas', "ASC")->orderBy("tanggal", "DESC")->orderBy("no_absen", "ASC")->findAll(),
        ];

        return $this->respond($payload);
    }

    public function getPresenceDetail($id)
    {
        $result = $this->absenModel->withDetailUsers()->where("id_absensi", $id)->first();

        return $this->respond($result);
    }

    public function getUsers()
    {
        $role  = $this->request->getVar('role');
        $class = $this->request->getVar('kelas');

        $builder = $this->userModel->getUsersWithDetails();

        if ($role) {
            $builder->where("u.id_role", $role)->orderBy("kelas", "ASC")->orderBy("no_absen", "ASC");

            if ($role == 1)
                if ($class)
                    $builder->where("k.id_kelas", $class);
        }

        $payload = [
            "type"  => $role,
            "users" => $builder->get()->getResultObject(),
        ];

        return $this->respond($payload);
    }

    public function getKelas($id = null)
    {
        if ($id) {
            $kelas = $this->kelasModel->find($id);
        } else {
            $kelas = $this->kelasModel->orderBy('kelas', 'ASC')->findAll();
        }

        return $this->respond($kelas);
    }

    public function getJurusan($id = null)
    {
        if ($id) {
            $jurusan = $this->jurusanModel->find($id);
        } else {
            $jurusan = $this->jurusanModel->orderBy('nama_jurusan', 'ASC')->findAll();
        }
        return $this->respond($jurusan);
    }

    // ======================================================================
    // Edit Data
    // ======================================================================

    public function changePasswordUser()
    {
        $data = (array) $this->request->getVar();

        $user = $this->userModel->where("id_user", $data['id_user'])->first();

        if (empty($user))
            return $this->respond(['message' => 'User Tidak Ditemukan'], 404);

        if (empty($user->email))
            return $this->respond(['message' => 'User perlu diaktivasi dulu'], 404);

        $this->userModel->save($data);

        return $this->respond(['message' => 'Success Update Password']);
    }

    public function editKelas($id)
    {
        $data = $this->request->getVar();

        $this->kelasModel->update($id, $data);

        return $this->respond(['message' => 'Success Update Kelas']);
    }

    public function editJurusan($id)
    {
        $data = $this->request->getVar();
        try {
            $this->jurusanModel->update($id, $data);

            return $this->respond(['message' => 'Success Update Jurusan']);
        } catch (\Exception $e) {
            return $this->respond(['message' => $e->getMessage()], 500);
        }
    }

    // ======================================================================
    // Add Data
    // ======================================================================

    public function addUser()
    {
        $data = (array) $this->request->getVar();
        $id_user = null;

        try {
            switch ($data['id_role']) {
                case 1:
                    $id_user = $this->userModel->insert([
                        "id_role" => $data['id_role'],
                    ]);
                    $this->userSiswaModel->insert([
                        "id_user" => $id_user,
                        "nama" => $data['nama'],
                        "id_kelas" => $data['id_kelas'],
                        "kode_jurusan" => $data['kode_jurusan'],
                        "no_absen" => $data['no_absen'],
                        "nis" => $data['nis'],
                        "nisn" => $data['nisn']
                    ]);
                    break;
                case 2:
                    $id_user = $this->userModel->insert([
                        "email" => $data['email'],
                        "password" => $data['password'],
                        "id_role" => $data['id_role'],
                    ]);
                    $this->userGuruModel->insert([
                        "id_user" => $id_user,
                        "nama" => $data['nama'],
                        "nip" => $data['nip']
                    ]);
                    break;
                case 3:
                    $id_user = $this->userModel->insert([
                        "email" => $data['email'],
                        "password" => $data['password'],
                        "id_role" => $data['id_role'],
                    ]);
                    break;
            }
            return $this->respond(['message' => 'Success Add User']);
        } catch (DatabaseException $e) {
            $this->userModel->delete($id_user);
            return $this->respond(['message' => $e->getMessage()], 500);
        }
    }

    public function addUserExcel()
    {
        $valid = $this->validate(
            [
                'file' => [
                    'label' => 'File',
                    'rules' => 'uploaded[file]|max_size[file,10240]|ext_in[file,xls,xlsx]',
                ],
            ]
        );

        if (!$valid) {
            return $this->respond(['message' => "File tidak valid"], 500);
        }

        $data = (array) $this->request->getVar();
        $file = $this->request->getFile('file');
        $ext = $file->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else if ($ext == 'xlsx') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }

        $spreadsheet = $render->load($file);
        $data_excel = $spreadsheet->getActiveSheet()->toArray();

        $id_user = null;
        foreach ($data_excel as $x => $row) {
            if ($x == 0) {
                continue;
            }

            $nama = $row[0];
            $kelas = $row[1];
            $jurusan = $row[2];
            $no_absen = $row[3];
            $nis = $row[4];
            $nisn = $row[5];

            try {
                $kelasData = $this->kelasModel->where('kelas', $kelas)->first();
                if (!$kelasData) {
                    return $this->respond(['message' => "Kelas tidak ditemukan, " . $kelasData], 500);
                }
                $id_kelas = $kelasData->id_kelas;

                $this->userModel->insert([
                    "id_role" => $data['id_role'],
                ]);

                $id_user = $this->userModel->getInsertID();

                $this->userSiswaModel->insert([
                    "id_user" => $id_user,
                    "nama" => $nama,
                    "id_kelas" => $id_kelas,
                    "kode_jurusan" => $jurusan,
                    "no_absen" => $no_absen,
                    "nis" => $nis,
                    "nisn" => $nisn
                ]);
            } catch (DatabaseException $e) {
                $this->userModel->delete($id_user);
                return $this->respond(['message' => $e->getMessage()], 500);
            }
        }
    }

    public function addKelas()
    {
        $data = $this->request->getVar();

        $this->kelasModel->insert($data);

        return $this->respond(['message' => 'Success Update Kelas']);
    }

    public function addJurusan()
    {
        $data = $this->request->getVar();

        $this->jurusanModel->insert($data);

        return $this->respond(['message' => 'Success Add Jurusan']);
    }

    // ======================================================================
    // Delete Data
    // ======================================================================

    public function deleteUser($id)
    {
        try {
            $this->userSiswaModel->where("id_user", $id)->delete();
            $this->userGuruModel->where("id_user", $id)->delete();
            $this->userModel->delete($id);
            return $this->respond(['message' => 'Success Delete User']);
        } catch (DatabaseException $e) {
            return $this->respond(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteKelas($id)
    {
        try {
            $this->kelasModel->delete($id);
            return $this->respond(['message' => 'Success Delete Kelas']);
        } catch (\Exception $e) {
            return $this->respond(['message' => $e->getMessage()], 500);
        }
    }

    public function deleteJurusan($id)
    {
        try {
            $this->jurusanModel->delete($id);
            return $this->respond(['message' => 'Success Delete Jurusan']);
        } catch (\Exception $e) {
            return $this->respond(['message' => $e->getMessage()], 500);
        }
    }
}

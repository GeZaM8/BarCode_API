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
        $valid = $this->validate([
            'file' => [
                'label' => 'File',
                'rules' => 'uploaded[file]|max_size[file,10240]|ext_in[file,xls,xlsx]',
            ],
        ]);

        if (!$valid) {
            return $this->respond([
                'status' => 'error',
                'message' => 'File tidak valid',
                'errors' => $this->validator->getErrors()
            ], 400);
        }

        $data = (array) $this->request->getVar();
        $file = $this->request->getFile('file');
        $ext = $file->getClientExtension();
        
        try {
            $render = ($ext == 'xls') ? new \PhpOffice\PhpSpreadsheet\Reader\Xls() : new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $render->load($file);
            $data_excel = $spreadsheet->getActiveSheet()->toArray();
            
            $errors = [];
            $success_count = 0;
            $processed_rows = 0;

            foreach ($data_excel as $x => $row) {
                if ($x == 0) continue; 
                
                
                if (empty($row[0]) && empty($row[1]) && empty($row[2])) continue;
                
                $processed_rows++;

                try {
                    $kelasData = $this->kelasModel->where('kelas', trim($row[1]))->first();
                    
                    if (!$kelasData) {
                        $errors[] = "Baris " . ($x + 1) . ": Kelas '{$row[1]}' tidak ditemukan";
                        continue;
                    }

                    if (empty($row[0])) {
                        $errors[] = "Baris " . ($x + 1) . ": Nama tidak boleh kosong";
                        continue;
                    }

                    if (empty($row[2])) {
                        $errors[] = "Baris " . ($x + 1) . ": Jurusan tidak boleh kosong";
                        continue;
                    }

                    $this->userModel->insert([
                        "id_role" => $data['id_role'],
                    ]);
                    
                    $id_user = $this->userModel->getInsertID();
                    
                    $this->userSiswaModel->insert([
                        "id_user" => $id_user,
                        "nama" => trim($row[0]),
                        "id_kelas" => $kelasData->id_kelas,
                        "kode_jurusan" => strtoupper(trim($row[2])),
                        "no_absen" => !empty($row[3]) ? $row[3] : null,
                        "nis" => !empty($row[4]) ? $row[4] : null,
                        "nisn" => !empty($row[5]) ? $row[5] : null
                    ]);

                    $success_count++;

                } catch (DatabaseException $e) {
                    if (isset($id_user)) {
                        $this->userModel->delete($id_user);
                    }
                    $errors[] = "Baris " . ($x + 1) . ": " . $this->simplifyErrorMessage($e->getMessage());
                }
            }

            $response = [
                'status' => $errors ? 'partial' : 'success',
                'message' => $success_count . " dari " . $processed_rows . " data berhasil diupload" . ($errors ? " dengan beberapa error" : ""),
                'success_count' => $success_count,
                'total_rows' => $processed_rows
            ];

            if ($errors) {
                $response['errors'] = $errors;
            }

            return $this->respond($response, 200);

        } catch (\Exception $e) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Gagal memproses file: ' . $e->getMessage()
            ], 500);
        }
    }

    private function simplifyErrorMessage($message) 
    {
        if (strpos($message, 'Duplicate entry') !== false) {
            if (strpos($message, 'users.email') !== false) {
                return 'Email sudah terdaftar';
            }
            if (strpos($message, 'u_siswa.nis') !== false) {
                return 'NIS sudah terdaftar';
            }
            if (strpos($message, 'u_siswa.nisn') !== false) {
                return 'NISN sudah terdaftar';
            }
        }
        return $message;
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

    public function exportUsers()
    {
        $role = $this->request->getVar('role');
        $class = $this->request->getVar('kelas');

        // Get data
        $builder = $this->userModel->getUsersWithDetails();
        
        // Filter berdasarkan role
        if ($role) {
            $builder->where("u.id_role", $role);
            if ($role == 1 && $class) {
                $builder->where("k.id_kelas", $class);
            }
        }
        
        $users = $builder->orderBy("kelas", "ASC")->orderBy("no_absen", "ASC")->get()->getResultObject();

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers dan data berdasarkan role
        switch ($role) {
            case '1': // Siswa
                $headers = ['No', 'Nama', 'Kelas', 'Jurusan', 'No. Absen', 'NIS', 'NISN'];
                $data = array_map(function($index, $user) {
                    return [
                        $index + 1,
                        $user->nama ?? '',
                        $user->kelas ?? '',
                        $user->kode_jurusan ?? '',
                        $user->no_absen ?? '',
                        $user->nis ?? '',
                        $user->nisn ?? ''
                    ];
                }, array_keys($users), $users);
                $sheet->setTitle('Data Siswa');
                break;

            case '2': // Guru
                $headers = ['No', 'Nama', 'NIP', 'Email'];
                $data = array_map(function($index, $user) {
                    return [
                        $index + 1,
                        $user->nama ?? '',
                        $user->nip ?? '',
                        $user->email ?? ''
                    ];
                }, array_keys($users), $users);
                $sheet->setTitle('Data Guru');
                break;

            case '3': // Admin
                $headers = ['No', 'Nama', 'Email'];
                $data = array_map(function($index, $user) {
                    return [
                        $index + 1,
                        $user->nama ?? '',
                        $user->email ?? ''
                    ];
                }, array_keys($users), $users);
                $sheet->setTitle('Data Admin');
                break;

            default: // Semua role
                $headers = ['No', 'Nama', 'Role', 'Email', 'Kelas', 'Jurusan'];
                $data = array_map(function($index, $user) {
                    return [
                        $index + 1,
                        $user->nama ?? '',
                        $user->name_role ?? '',
                        $user->email ?? '',
                        $user->kelas ?? '',
                        $user->kode_jurusan ?? ''
                    ];
                }, array_keys($users), $users);
                $sheet->setTitle('Data Semua Pengguna');
                break;
        }

        // Add headers
        foreach (range(0, count($headers) - 1) as $i) {
            $col = chr(65 + $i);
            $sheet->setCellValue($col . '1', $headers[$i]);
            $sheet->getStyle($col . '1')->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'] // Indigo color
                ],
                'font' => [
                    'color' => ['rgb' => 'FFFFFF']
                ]
            ]);
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Add data
        foreach ($data as $rowIndex => $rowData) {
            $row = $rowIndex + 2;
            foreach ($rowData as $colIndex => $value) {
                $col = chr(65 + $colIndex);
                $sheet->setCellValue($col . $row, $value);
            }
            
            // Add zebra striping
            if ($row % 2 == 0) {
                $sheet->getStyle("A{$row}:" . chr(64 + count($headers)) . $row)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setRGB('F3F4F6');
            }
        }

        // Style the table
        $lastColumn = chr(64 + count($headers));
        $lastRow = count($data) + 1;
        $tableRange = "A1:{$lastColumn}{$lastRow}";
        
        // Add borders
        $sheet->getStyle($tableRange)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);

        // Center align specific columns based on role
        if ($role == '1') {
            // Center align No, No. Absen, NIS, NISN columns
            foreach (['A', 'E', 'F', 'G'] as $col) {
                $sheet->getStyle($col . '2:' . $col . $lastRow)
                    ->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }
        } else {
            // Center align No column for other roles
            $sheet->getStyle('A2:A' . $lastRow)
                ->getAlignment()
                ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Create filename based on role
        $roleNames = [
            '1' => 'siswa',
            '2' => 'guru',
            '3' => 'admin',
            '' => 'semua_pengguna'
        ];
        $roleName = $roleNames[$role] ?? 'semua_pengguna';
        $filename = "data_{$roleName}_" . date('Y-m-d_His') . '.xlsx';

        // Set response headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Save to output
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}

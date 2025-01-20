<?php

namespace App\Models;

use CodeIgniter\Model;

class User extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["email", "password", "id_role"];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getUsersWithDetails()
    {
        $db = $this->db;

        $siswaQuery = $db->table('u_siswa d')
            ->select("id_user, 1 as id_role, nama, id_kelas, kode_jurusan, no_absen, nis, nisn, NULL as nip");

        $teacherQuery = $db->table('u_guru d')
            ->select("id_user, 2 as id_role, nama, NULL as id_kelas, NULL as kode_jurusan, NULL as no_absen, NULL as nis, NULL as nisn, nip");

        $unionQuery = $siswaQuery->getCompiledSelect() . " UNION ALL " . $teacherQuery->getCompiledSelect();

        $query = $db->table('users u')
            ->select('u.*, d.id_role, d.nama, d.id_kelas, d.kode_jurusan, d.no_absen, d.nis, d.nisn, d.nip, r.name_role, k.kelas')
            ->join("($unionQuery) d", 'u.id_user = d.id_user AND u.id_role = d.id_role', 'left')
            ->join("user_roles r", 'u.id_role = r.id_role', 'left')
            ->join("kelas k", "k.id_kelas = d.id_kelas", "left");

        return $query;
    }
}

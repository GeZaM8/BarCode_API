<?php

namespace App\Models;

use CodeIgniter\Model;

class USiswa extends Model
{
    protected $table            = 'u_siswa';
    protected $primaryKey       = 'id_user';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id_user", "nama", "kelas", "kode_jurusan", "no_absen", "nis", "nisn", "foto"];

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

    public function getSiswaWithDetails()
    {
        $builder = $this
            ->join("kelas k", "u_siswa.id_kelas = k.id_kelas", "left")
            ->join("jurusan j", "u_siswa.kode_jurusan = j.kode_jurusan", "left")
            ->join("users u", "u_siswa.id_user = u.id_user");
        return $builder;
    }
}

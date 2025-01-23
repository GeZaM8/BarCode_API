<?php

namespace App\Models;

use CodeIgniter\Model;

class Absensi extends Model
{
    protected $table            = 'absensi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id_user", "status", "mood", "reason", "tanggal", "timestamp"];

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

    public function withDetailUsers()
    {
        return $this->select("absensi.*, u.*, us.nama, us.id_kelas, us.kode_jurusan, us.no_absen, us.nis, us.nisn, us.foto, k.kelas, month(tanggal) as bulan, year(tanggal) as tahun")
            ->join('users u', 'u.id_user = absensi.id_user', 'left')
            ->join('u_siswa us', 'us.id_user = absensi.id_user', 'left')
            ->join('kelas k', 'k.id_kelas = us.id_kelas', 'left');
    }
}

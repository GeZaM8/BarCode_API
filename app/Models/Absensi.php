<?php

namespace App\Models;

use CodeIgniter\Model;

class Absensi extends Model
{
    protected $table            = 'absensi';
    protected $primaryKey       = 'id_absensi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ["id_user", "status", "mood", "reason", "tanggal", "timestamp", "foto"];

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
        return $this->select("absensi.*, u.email, u.id_role, us.nama, us.id_kelas, us.kode_jurusan, us.no_absen, us.nis, us.nisn, us.foto as foto_profile, k.kelas, month(tanggal) as bulan, year(tanggal) as tahun")
            ->join('users u', 'u.id_user = absensi.id_user', 'left')
            ->join('u_siswa us', 'us.id_user = absensi.id_user', 'left')
            ->join('kelas k', 'k.id_kelas = us.id_kelas', 'left');
    }

    public function getLeaderBoard($sortBy = "kehadiran") 
    {
        $orderColumn = ($sortBy === "kecepatan") ? "kecepatan_persen" : "kehadiran_persen";

        return $this
            ->select("
                absensi.id_user,
                us.nama,
                ROUND((COUNT(absensi.id_user) / (SELECT COUNT(DISTINCT tanggal) FROM absensi)) * 100, 2) AS kehadiran_persen,
                ROUND((SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) / COUNT(absensi.id_user)) * 100, 2) AS kecepatan_persen
            ")
            ->join("u_siswa us", "us.id_user = absensi.id_user", "left")
            ->groupBy("absensi.id_user")
            ->orderBy($orderColumn, "DESC")
            ->limit(10)
            ->findAll();
    }
}

<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\Kelas;
use CodeIgniter\HTTP\ResponseInterface;

class KelasController extends BaseController
{
    protected $kelasModel;

    public function __construct()
    {
        $this->kelasModel = new Kelas();
    }

    public function getKelas()
    {
        return $this->respond($this->kelasModel->findAll());
    }
}

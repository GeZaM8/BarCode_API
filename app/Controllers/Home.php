<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

class Home extends BaseController
{
    use ResponseTrait;
    public function index(): string
    {
        return view('welcome_message');
    }

    public function registerUser()
    {
        return $this->respond(["fakta" => "WOI Ramadian Gay"]);
    }
}

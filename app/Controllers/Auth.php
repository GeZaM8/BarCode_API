<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class Auth extends BaseController
{
    public function login()
    {
        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        $userModel = new User();
        $user = $userModel->where("email", $email)->join("detailusers", "detailusers.id_user = users.id_user")->first();

        if (!$user)
            return $this->fail(messages: "Email atau Password Salah");

        if ($user->password == $password) {
            return $this->respond($user);
        } else {
            return $this->fail(messages: "Email atau Password Salah Woi");
        }
    }
}

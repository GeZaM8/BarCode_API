<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\User;

class Auth extends BaseController
{
    public function login()
    {
        $email = $this->request->getVar("email");
        $password = $this->request->getVar("password");

        $userModel = new User();
        $user = $userModel->getUserJoinSiswa()->where("email", $email)->first();

        if (!$user)
            return $this->fail(messages: "Email atau Password Salah");

        if ($user->password == $password) {
            return $this->respond($user);
        } else {
            return $this->fail(messages: "Email atau Password Salah Woi");
        }
    }
}

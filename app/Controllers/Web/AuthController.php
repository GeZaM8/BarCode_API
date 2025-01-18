<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\User;

class AuthController extends BaseController
{
    public function login_page()
    {
        return view('login', ['title' => 'Login']);
    }

    public function login()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new User();
        $user = $userModel->where('email', $email)->first();

        if (!$user)
            return redirect()->back()->with('error', ['Username or Password is wrong']);

        if ($user->password == $password) {
            return redirect()->to("dashboard");
        }
    }
}

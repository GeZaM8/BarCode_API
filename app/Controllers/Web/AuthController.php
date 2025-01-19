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
            return redirect()->back()->with('error', ['Email atau Password salah']);

        if ($user->password == $password) {
            session()->set('auth_login', [
                "id" => $user->id_user,
                "email" => $user->email
            ]);
            return redirect()->back();
        }

        return redirect()->back()->with('error', ['Email atau Password salah']);
    }
}

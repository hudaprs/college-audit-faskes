<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function loginAction()
    {
        $validation = $this->validate([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);

        if (!$validation) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back();
        }

        $user = new User;
        $user = $user->where('email', preg_replace('/\s+/', '', $this->request->getVar('email')))->first();

        // Check if email exists
        if ($user) {
            $isPasswordCorrect = password_verify($this->request->getVar('password'), $user->password);
            // Check if password correct
            if ($isPasswordCorrect) {
                session()->set([
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role
                ]);
            } else {
                session()->setFlashdata('error', 'Invalid Credentials');
                return redirect()->back();
            }
            return redirect()->to(base_url());
        } else {
            session()->setFlashdata('error', 'Invalid Credentials');
            return redirect()->back();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/auth/login'));
    }
}
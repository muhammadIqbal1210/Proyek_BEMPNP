<?php 

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Login extends BaseController
{
    public function index(): string
    {
        helper(['form']);
        // Pastikan view dipanggil sesuai nama file Anda (misal: login.php)
        return view('login');
    }

    public function loginAuth()
    {
        $session = session();
        helper(['form']);
        $model = new UserModel();
        
        // 1. Definisikan Aturan Validasi
        $rules = [
            'email'    => [
                'rules'  => 'required|valid_email',
                'errors' => [
                    'required'    => 'Email harus diisi.',
                    'valid_email' => 'Format email tidak valid.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[8]',
                'errors' => [
                    'required'   => 'Kata sandi harus diisi.',
                    'min_length' => 'Kata sandi minimal 8 karakter.'
                ]
            ],
        ];

        // 2. Jalankan Validasi
        if (!$this->validate($rules)) {
            // PERBAIKAN: Gunakan ->with('errors', ...) agar bisa di-looping di View
            return redirect()->to('/login')
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $model->where('email', $email)->first();

        if ($user) {
            $verifyPass = password_verify($password, $user['password']);
            
            if ($verifyPass) {
                $sesData = [
                    'user_id'    => $user['id'],
                    'username'   => $user['username'],
                    'email'      => $user['email'],
                    'role'       => $user['role'],
                    'isLoggedIn' => true
                ];
                $session->set($sesData);
                // Redirect admins (including superadmin) to admin dashboard
                if (in_array($user['role'], ['admin', 'superadmin'])) {
                    return redirect()->to('/admin/dashboard');
                }

                // Default: member dashboard
                return redirect()->to('/member/dashboard');

            } else {
                // Password Salah
                return redirect()->to('/login')
                    ->withInput()
                    ->with('error', 'Kata sandi yang Anda masukkan salah.');
            }
        } else {
            // Email Tidak Ditemukan
            return redirect()->to('/login')
                ->withInput()
                ->with('error', 'Akun dengan email tersebut tidak ditemukan.');
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar.');
    }
}
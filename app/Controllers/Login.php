<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Login extends BaseController
{
    // Method 1: index() - Menampilkan Form Login (GET /login)
    public function index(): string
    {
        helper(['form']);
        $data['validation'] = \Config\Services::validation(); 
        
        // Menampilkan view login
        return view('login', $data);
    }

    // Method 2: loginAuth() - Memproses Otentikasi (POST /login/auth)
    public function loginAuth()
    {
        $session = session();
        helper(['form']);
        $model = new UserModel();
        
        // 1. Definisikan Aturan Validasi untuk Login
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[8]',
        ];

        // 2. Jalankan Validasi
        if (!$this->validate($rules)) {
            // Jika validasi form gagal, kembali ke form login dengan error
            return redirect()->to('/login')->withInput()->with('validation', $this->validator);
        }
        
        // 3. Ambil Input
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        // 4. Cari User berdasarkan Email
        // Gunakan where() dan first() untuk mencari baris pertama
        $user = $model->where('email', $email)->first();

        if ($user) {
            // 5. Verifikasi Password
            $verifyPass = password_verify($password, $user['password']);
            
            if ($verifyPass) {
                // 6. Login Berhasil: Set Session Data
                $sesData = [
                    'id_user'       => $user['id'],
                    'username'      => $user['username'],
                    'email'         => $user['email'],
                    'role'          => $user['role'], // Ambil role dari database
                    'isLoggedIn'    => TRUE
                ];
                $session->set($sesData);
                
                // 7. Redirect Berdasarkan Role
                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard'); // Redirect Admin
                } else {
                    return redirect()->to('/member/dashboard'); // Redirect Member/User Biasa
                }

            } else {
                // Password Salah
                $session->setFlashdata('error', 'Kata sandi salah.');
                return redirect()->to('/login')->withInput();
            }
        } else {
            // Email Tidak Ditemukan
            $session->setFlashdata('error', 'Email belum terdaftar.');
            return redirect()->to('/login')->withInput();
        }
    }
}
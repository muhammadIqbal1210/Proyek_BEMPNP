<?php 

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProfileModel;
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
        $userModel = new UserModel();
        $profileModel = new ProfileModel();
        
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

        $user = $userModel->where('email', $email)->first();

        if ($user) {
            if ($user) {

                // Memeriksa apakah key 'is_active' ada di database, jika belum ada atau bernilai 0, maka blokir login
                $isActive = isset($user['is_active']) ? $user['is_active'] : 1; 

                if (!$isActive) {
                    return redirect()->to('/login')
                        ->withInput()
                        ->with('error', 'Akun Anda tidak aktif. Hubungi admin untuk mengaktifkannya kembali.');
                }
            }
            

            $verifyPass = password_verify($password, $user['password']);
            
            if ($verifyPass) {
                // Ambil profile data berdasarkan user_id
                $profile = $profileModel->where('user_id', $user['id'])->first();
                
                $sesData = [
                    'user_id'      => $user['id'],
                    'username'     => $user['username'],
                    'email'        => $user['email'],
                    'role'         => $user['role'],
                    'is_active'    => $user['is_active'],
                    'isLoggedIn'   => true,
                ];
                
                // Tambahkan profile data jika tersedia
                if ($profile) {
                    $sesData['nama_lengkap'] = $profile['nama_lengkap'];
                    $sesData['kementerian']  = $profile['kementerian'];
                    $sesData['jabatan']      = $profile['jabatan'];
                    $sesData['alamat']       = $profile['alamat'];
                    $sesData['no_telepon']   = $profile['no_telepon'];
                }
                
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
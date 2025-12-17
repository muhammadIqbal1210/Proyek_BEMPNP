<?php namespace App\Controllers;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends Controller {
    public function login() {
        // --- PERBAIKAN: Pindahkan helper di luar conditional POST ---
        helper('form');

        if ($this->request->getMethod() === 'post') {
            $model = new UserModel();
            $username = $this->request->getVar('username');
            $password = $this->request->getVar('password');

            $user = $model->where('username', $username)->first();
            
            // Periksa jika user ditemukan DAN password cocok
            if ($user && password_verify($password, $user['password'])) {
                // Login berhasil
                session()->set(['user_id' => $user['id'], 'role' => $user['role']]);
                
                // --- LOGIKA PENGALIHAN BERDASARKAN ROLE ---
                if ($user['role'] === 'admin') {
                    return redirect()->to('/admin/dashboard');
                }
                
                // Default untuk 'member' atau role lainnya
                return redirect()->to('/dashboard'); 
                // ------------------------------------------

            } else {
                // Login gagal 
                session()->setFlashdata('error', 'Username atau Password salah.');
            }
        }
        
        // Memuat view login
        return view('login');
    }

    // =========================================================
    // --- METODE REGISTER BARU ---
    // =========================================================
    public function register()
    {
        // --- PERBAIKAN: Pindahkan helper di luar conditional POST ---
        helper(['form']);
        $validation = \Config\Services::validation();
        $model = new UserModel();

        if ($this->request->getMethod() === 'post') {
            // 1. Tentukan Aturan Validasi Controller (Form Validation)
            $rules = [
                'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
                'email'    => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[8]',
                'pass_confirm' => 'required|matches[password]',
            ];

            if ($this->validate($rules)) {
                // 2. Simpan Data ke Database
                $data = [
                    'username' => $this->request->getVar('username'),
                    'email'    => $this->request->getVar('email'),
                    'password' => $this->request->getVar('password'), 
                    'role'     => 'member', // Default role untuk pendaftaran
                ];

                $result = $model->save($data);
                
                if ($result) {
                    // SAVE BERHASIL
                    session()->setFlashdata('success', 'Pendaftaran berhasil! Silakan masuk.');
                    return redirect()->to('/login'); // Redirection Register Sukses
                } else {
                    // --- DEBUGGING KRUSIAL: LOG MODEL ERROR ---
                    $modelErrors = $model->errors();
                    log_message('error', 'Penyimpanan Database Gagal. Errors Model: ' . json_encode($modelErrors));
                    session()->setFlashdata('error', 'Pendaftaran gagal karena kesalahan database. Cek logs.');
                    
                    // Kita kembalikan ke view dengan error Model agar terlihat.
                    $this->validator->setRules($modelErrors);
                    $data['validation'] = $this->validator;
                }

            } else {
                // 3. Jika Validasi Controller Gagal
                log_message('error', 'Validasi Register Gagal (Form Validation). Errors: ' . json_encode($this->validator->getErrors()));
                $data['validation'] = $this->validator;
            }
        }
            
        // Memuat view register, membawa data validasi jika ada error POST
        $data['validation'] = $validation;
        return view('register', $data);
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}
<?php namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use CodeIgniter\API\ResponseTrait;

class Register extends BaseController
{
    use ResponseTrait;
    
    // Method 1: index() - Menangani request GET (Menampilkan Form)
    public function index()
    {
        helper(['form']);
        
        // Inisialisasi service validation untuk dikirim ke view
        $data['validation'] = \Config\Services::validation(); 

        // Tampilkan view register. 
        // Data input lama (set_value) dan error validasi akan diisi otomatis 
        // jika ada redirect dari method store()
        return view('register', $data); 
    }

    // Method 2: store() - Menangani request POST (Memproses Data)
    public function store()
    {
        $session = session();
        helper(['form']);

        // 1. Definisikan Aturan Validasi
        $rules = [
            'username'      => 'required|min_length[3]|max_length[20]|is_unique[users.username]', // Pastikan is_unique ada
            'email'         => 'required|valid_email|is_unique[users.email]',
            'password'      => 'required|min_length[8]',
            'pass_confirm'  => 'required|matches[password]',
        ];

        // 2. Jalankan Validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke form register (Method index)
            // withInput() penting agar data form dan error validation terbawa
            return redirect()->to('/register')->withInput()->with('validation', $this->validator);
        } 
        
        // 3. Jika Validasi Sukses: Siapkan Data
        $model = new UserModel();
        
        $data = [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'password' => $this->request->getVar('password'), 
            'role'     => 'member', // Default role
        ];

        // 4. Simpan Data ke Database
        if ($model->save($data)) {
            $session->setFlashdata('success', 'Pendaftaran berhasil! Silakan masuk.');
            return redirect()->to('/login');
        } else {
            // Jika save() gagal karena alasan DB error
            $session->setFlashdata('error', 'Gagal menyimpan data ke database. Cek log server.');
            return redirect()->to('/register')->withInput();
        }
    }
}
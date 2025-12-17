<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel; // Gunakan Model yang sudah ada

class UserController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // Inisialisasi Model Pengguna
        $this->userModel = new UserModel();
    }

    /**
     * Menampilkan daftar semua pengguna (disertai pencarian/filter)
     */
    public function index()
    {
        // --- Ambil input dari GET request (pencarian dan filter) ---
        $keyword = $this->request->getGet('keyword');
        $role = $this->request->getGet('role');

        // --- Inisialisasi Query Model ---
        $query = $this->userModel;

        // Terapkan Filter Keyword (Pencarian)
        if (!empty($keyword)) {
            // Mencari di kolom 'username' atau 'email'
            $query = $query->groupStart()
                            ->like('username', $keyword)
                            ->orLike('email', $keyword)
                            ->groupEnd();
        }

        // Terapkan Filter Role
        if (!empty($role)) {
            $query = $query->where('role', $role);
        }

        // Ambil data yang sudah difilter
        $user_list = $query->findAll();


        $data = [
            'title'             => 'Pengelolaan Akun Pengguna',
            'halaman'           => 'Daftar Akun Pengguna',
            'user_list'         => $user_list, // Data untuk tabel
            'content'           => 'admin/user/index', // View utama 

            'filters' => [
                'keyword' => $keyword,
                'role' => $role,
            ],
        ];
        return view('template/wrapper', $data); 
    }
    public function store()
    {
        // 1. Tentukan aturan validasi
        $rules = [
            'username' => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
            'email'    => 'required|max_length[255]|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[8]',
            'role'     => 'required|in_list[guest,member,admin]',
        ];

        // 2. Lakukan validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 3. Data siap disimpan
        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'), // Akan di-hash oleh Model
            'role'     => $this->request->getPost('role'),
        ];

        // 4. Simpan ke database
        $this->userModel->save($data);

        // 5. Redirect dengan pesan sukses
        return redirect()->to(base_url('admin/user'))->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    /**
     * Mengambil data pengguna spesifik (dipanggil via AJAX untuk modal edit)
     * @param int $id ID Pengguna
     * @return \CodeIgniter\HTTP\Response
     */
    public function edit($id = null)
    {
        $user = $this->userModel->find($id);

        if ($user) {
            // Hapus password agar tidak dikirim ke frontend
            unset($user['password']); 
            return $this->response->setJSON($user);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['status' => 'error', 'message' => 'Pengguna tidak ditemukan.']);
        }
    }

    /**
     * Memperbarui data pengguna (UPDATE)
     * @param int $id ID Pengguna
     */
    public function update($id = null)
    {
        // Cek pengguna yang akan diupdate
        $oldUser = $this->userModel->find($id);
        if (!$oldUser) {
            return redirect()->to(base_url('admin/user'))->with('error', 'Pengguna tidak ditemukan untuk diperbarui.');
        }

        // 1. Tentukan aturan validasi dasar
        $rules = [
            'role'     => 'required|in_list[guest,member,admin]',
        ];
        
        // 2. Aturan untuk Username (hanya unik jika username berubah)
        $usernameRule = 'required|min_length[3]|max_length[100]';
        if ($oldUser['username'] !== $this->request->getPost('username')) {
            $usernameRule .= '|is_unique[users.username]';
        }
        $rules['username'] = $usernameRule;

        // 3. Aturan untuk Email (hanya unik jika email berubah)
        $emailRule = 'required|max_length[255]|valid_email';
        if ($oldUser['email'] !== $this->request->getPost('email')) {
            $emailRule .= '|is_unique[users.email]';
        }
        $rules['email'] = $emailRule;
        
        // 4. Aturan untuk Password (opsional, hanya jika diisi)
        $password = $this->request->getPost('password');
        if (!empty($password)) {
            $rules['password'] = 'min_length[8]';
        }

        // 5. Lakukan validasi
        if (!$this->validate($rules)) {
            // Jika validasi gagal, kembalikan ke halaman sebelumnya dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 6. Data siap disimpan
        $data = [
            'id'       => $id,
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'role'     => $this->request->getPost('role'),
        ];
        
        // Hanya tambahkan password jika diisi
        if (!empty($password)) {
            $data['password'] = $password; // Akan di-hash oleh Model
        }

        // 7. Simpan ke database
        $this->userModel->save($data);

        // 8. Redirect dengan pesan sukses
        return redirect()->to(base_url('admin/user'))->with('success', 'Akun pengguna berhasil diperbarui.');
    }

    /**
     * Menghapus data pengguna (DELETE)
     * @param int $id ID Pengguna
     */
    public function delete($id = null)
    {
        if ($this->userModel->delete($id)) {
            return redirect()->to(base_url('admin/user'))->with('success', 'Akun pengguna berhasil dihapus.');
        } else {
            return redirect()->to(base_url('admin/user'))->with('error', 'Gagal menghapus akun pengguna.');
        }
    }
}
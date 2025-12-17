<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LombaModel; 

class Lomba extends BaseController
{
    protected $lombaModel;
    protected $helpers = ['form', 'url', 'filesystem']; // Tambahkan filesystem untuk upload

    public function __construct()
    {
        // Inisialisasi model
        $this->lombaModel = new LombaModel();
    }

    /**
     * Menampilkan daftar Lomba (Read) dan Filter/Search.
     */
    public function index()
    {
        // --- 1. Ambil input dari GET request (pencarian dan filter) ---
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status_lomba');

        // --- 2. Inisialisasi Query Model ---
        $query = $this->lombaModel;

        // Terapkan Filter Keyword (Pencarian)
        if (!empty($keyword)) {
            // Mencari di kolom 'title' atau kolom relevan lainnya
            $query = $query->like('title', $keyword);
        }

        // Terapkan Filter Status
        // Pastikan $status TIDAK kosong agar tidak memfilter status=""
        if (!empty($status)) {
            $query = $query->where('status_lomba', $status);
        }

        
        // Ambil data yang sudah difilter
        $perPage = 10;
        $lomba_list = $query->paginate($perPage, 'lomba');
        $pager = $query->pager;
        // $lomba_list = $query->findAll();

        $poster_base_url = base_url('uploads/lomba') . '/';

        // --- 3. Siapkan data untuk View ---
        $data = [
            'title'         => 'Pengelolaan Lomba',
            'halaman'       => 'Daftar Lomba',
            'poster_base_url' => $poster_base_url,
            'lomba_list' => $lomba_list, // Data untuk tabel
            'content'       => 'admin/lomba/index', // View utama
            'pager'         => $pager,
            // Kirim state filter kembali ke view agar form tetap terisi
            'filters' => [
                'keyword' => $keyword,
                'status_lomba' => $status,
            ],
        ];
        
        // Memuat view dengan layout admin
        return view('template/wrapper', $data); 
    }

    /**
     * Menyimpan data Lomba baru (Create).
     */
    public function store()
    {
        if (!$this->validate($this->lombaModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = null;
        $poster = $this->request->getFile('poster_file'); // Cek nama input field di form create Anda

        if ($poster && $poster->isValid() && !$poster->hasMoved()) {
            $newName = $poster->getName();
            // Perhatikan, WRITEPATH adalah folder internal. Untuk akses publik, 
            // file harus di-move ke folder 'public/uploads/lomba/'.
            // Di CI4, cara termudah adalah menggunakan move() ke folder FCPATH (public)
            
            // Pindahkan file ke folder publik (FCPATH menunjuk ke folder public)
            $poster->move(FCPATH . 'uploads/lomba', $newName);
            
            $filePath = $newName;
        }

        // 3. Siapkan Data untuk disimpan
        $data = [
            'nama_lomba'           => $this->request->getPost('nama_lomba'),
            'kategori'             => $this->request->getPost('kategori'),
            'deskripsi'            => $this->request->getPost('deskripsi'),
            'status_lomba'         => $this->request->getPost('status_lomba'),
            'link_informasi'       => $this->request->getPost('link_informasi'),
            'poster'               => $filePath, // Simpan nama file
        ];

        // 4. Simpan ke database
        if ($this->lombaModel->save($data)) {
            return redirect()->to(base_url('admin/lomba'))->with('success', 'Lomba berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
    public function edit($id = null)
    {
        // Ambil data lomba berdasarkan ID
        $lomba = $this->lombaModel->find($id);

        if (!$lomba) {
            // Mengembalikan status 404 jika data tidak ditemukan
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Lomba tidak ditemukan.']);
        }
        
        // Mengembalikan data sebagai JSON untuk diolah oleh JavaScript (seperti modal edit)
        return $this->response->setJSON($lomba);
    }

    /**
     * Memperbarui data Lomba yang sudah ada (Update).
     * @param int $id ID lomba
     */
    public function update($id)
    {
        // 1. Ambil data lama
        $old_data = $this->lombaModel->find($id);

        if (!$old_data) {
            return redirect()->to(base_url('admin/lomba'))->with('error', 'Lomba tidak ditemukan.');
        }

        // 2. Validasi Input
        if (!$this->validate($this->lombaModel->getValidationRules())) {
            // Redirect ke index dengan error flashdata (Mirip Pengumuman)
            return redirect()->to(base_url('admin/lomba'))->with('errors', $this->validator->getErrors());
        }

        $filePath = $old_data['poster']; // Pertahankan file lama
        $poster = $this->request->getFile('poster_file');
        $remove_poster = $this->request->getPost('remove_poster'); // Checkbox untuk hapus poster
        $uploadPath = FCPATH . 'uploads/lomba/'; // Menggunakan FCPATH

        // 3. Handle File Upload Baru atau Penghapusan File Lama
        if ($poster && $poster->isValid() && !$poster->hasMoved()) {
            // Hapus file lama jika ada file baru di-upload
            if ($filePath && file_exists($uploadPath . $filePath)) {
                unlink($uploadPath . $filePath);
            }
            
            // Pindahkan file baru
            $newName = $poster->getName();
            $poster->move($uploadPath, $newName);
            $filePath = $newName;

        } elseif ($remove_poster && $old_data['poster']) {
            // Hapus file jika pengguna mencentang kotak 'remove_poster'
            if (file_exists($uploadPath . $old_data['poster'])) {
                unlink($uploadPath . $old_data['poster']);
            }
            $filePath = null;
        }

        // 4. Siapkan Data untuk diperbarui
        $data = [
            'id'                    => $id, // Penting: sertakan ID untuk update
            'nama_lomba'            => $this->request->getPost('nama_lomba'),
            'kategori'              => $this->request->getPost('kategori'),
            'deskripsi'             => $this->request->getPost('deskripsi'),
            'status_lomba'          => $this->request->getPost('status_lomba'),
            'link_informasi'        => $this->request->getPost('link_informasi'),
            'poster'                => $filePath,
        ];

        // 5. Update ke database
        if ($this->lombaModel->save($data)) {
            return redirect()->to(base_url('admin/lomba'))->with('success', 'Lomba berhasil diperbarui.');
        } else {
            // Ini akan terjadi jika ada masalah database, bukan validasi
            return redirect()->to(base_url('admin/lomba'))->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }
    /**
     * Menghapus data Lomba (Delete).
     */
    public function delete($id)
    {
        $lomba = $this->lombaModel->find($id);

        if (!$lomba) {
            return redirect()->to(base_url('admin/lomba'))->with('error', 'Lomba tidak ditemukan.');
        }

        // 1. Hapus file panduan jika ada
        $poster = $lomba['poster'];
        if ($poster && file_exists(WRITEPATH . 'uploads/lomba/' . $poster)) {
            unlink(WRITEPATH . 'uploads/lomba/' . $poster);
        }

        // 2. Hapus dari database
        if ($this->lombaModel->delete($id)) {
            return redirect()->to(base_url('admin/lomba'))->with('success', 'Lomba berhasil dihapus.');
        } else {
            return redirect()->to(base_url('admin/lomba'))->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
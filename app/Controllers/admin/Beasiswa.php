<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeasiswaModel; 

class Beasiswa extends BaseController
{
    protected $beasiswaModel;
    protected $helpers = ['form', 'url', 'filesystem']; // Tambahkan filesystem untuk upload

    public function __construct()
    {
        // Inisialisasi model
        $this->beasiswaModel = new BeasiswaModel();
    }

    /**
     * Menampilkan daftar Beasiswa (Read) dan Filter/Search.
     */
    public function index()
    {
        // --- 1. Ambil input dari GET request (pencarian dan filter) ---
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status_beasiswa');

        // --- 2. Inisialisasi Query Model ---
        $query = $this->beasiswaModel;

        // Terapkan Filter Keyword (Pencarian)
        if (!empty($keyword)) {
            // Mencari di kolom 'title' atau kolom relevan lainnya
            $query = $query->like('title', $keyword);
        }

        // Terapkan Filter Status
        // Pastikan $status TIDAK kosong agar tidak memfilter status=""
        if (!empty($status)) {
            $query = $query->where('status_beasiswa', $status);
        }

        
        // Ambil data yang sudah difilter
        $perPage = 10;
        $beasiswa_list = $query->paginate($perPage, 'beasiswa');
        $pager = $query->pager;
        // $beasiswa_list = $query->findAll();

        $poster_base_url = base_url('uploads/beasiswa') . '/';

        // --- 3. Siapkan data untuk View ---
        $data = [
            'title'         => 'Pengelolaan Beasiswa',
            'halaman'       => 'Daftar Beasiswa',
            'poster_base_url' => $poster_base_url,
            'beasiswa_list' => $beasiswa_list, // Data untuk tabel
            'content'       => 'admin/beasiswa/index', // View utama
            'pager'         => $pager,
            // Kirim state filter kembali ke view agar form tetap terisi
            'filters' => [
                'keyword' => $keyword,
                'status_beasiswa' => $status,
            ],
        ];
        
        // Memuat view dengan layout admin
        return view('template/wrapper', $data); 
    }

    /**
     * Menyimpan data Beasiswa baru (Create).
     */
    public function store()
    {
        if (!$this->validate($this->beasiswaModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = null;
        $poster = $this->request->getFile('poster_file'); // Cek nama input field di form create Anda

        if ($poster && $poster->isValid() && !$poster->hasMoved()) {
            $newName = $poster->getName();
            // Perhatikan, WRITEPATH adalah folder internal. Untuk akses publik, 
            // file harus di-move ke folder 'public/uploads/beasiswa/'.
            // Di CI4, cara termudah adalah menggunakan move() ke folder FCPATH (public)
            
            // Pindahkan file ke folder publik (FCPATH menunjuk ke folder public)
            $poster->move(FCPATH . 'uploads/beasiswa', $newName);
            
            $filePath = $newName;
        }

        // 3. Siapkan Data untuk disimpan
        $data = [
            'nama_beasiswa'             => $this->request->getPost('nama_beasiswa'),
            'deskripsi'                 => $this->request->getPost('deskripsi'),
            'tanggal_buka'              => $this->request->getPost('tanggal_buka'),
            'tanggal_tutup'             => $this->request->getPost('tanggal_tutup'),
            'status_beasiswa'           => $this->request->getPost('status_beasiswa'),
            'link_informasi'            => $this->request->getPost('link_informasi'),
            'poster'                    => $filePath, // Simpan nama file
        ];

        // 4. Simpan ke database
        if ($this->beasiswaModel->save($data)) {
            return redirect()->to(base_url('admin/beasiswa'))->with('success', 'Beasiswa berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
    public function edit($id = null)
    {
        // Ambil data beasiswa berdasarkan ID
        $beasiswa = $this->beasiswaModel->find($id);

        if (!$beasiswa) {
            // Mengembalikan status 404 jika data tidak ditemukan
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Beasiswa tidak ditemukan.']);
        }
        
        // Mengembalikan data sebagai JSON untuk diolah oleh JavaScript (seperti modal edit)
        return $this->response->setJSON($beasiswa);
    }

    /**
     * Memperbarui data Beasiswa yang sudah ada (Update).
     * @param int $id ID beasiswa
     */
    public function update($id)
    {
        // 1. Ambil data lama
        $old_data = $this->beasiswaModel->find($id);

        if (!$old_data) {
            return redirect()->to(base_url('admin/beasiswa'))->with('error', 'Beasiswa tidak ditemukan.');
        }

        // 2. Validasi Input
        if (!$this->validate($this->beasiswaModel->getValidationRules())) {
            // Redirect ke index dengan error flashdata (Mirip Pengumuman)
            return redirect()->to(base_url('admin/beasiswa'))->with('errors', $this->validator->getErrors());
        }

        $filePath = $old_data['poster']; // Pertahankan file lama
        $poster = $this->request->getFile('poster_file');
        $remove_poster = $this->request->getPost('remove_poster'); // Checkbox untuk hapus poster
        $uploadPath = FCPATH . 'uploads/beasiswa/'; // Menggunakan FCPATH

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
            'id'                      => $id, // Penting: sertakan ID untuk update
            'nama_beasiswa'           => $this->request->getPost('nama_beasiswa'),
            'deskripsi'               => $this->request->getPost('deskripsi'),
            'tanggal_buka'            => $this->request->getPost('tanggal_buka'),
            'tanggal_tutup'           => $this->request->getPost('tanggal_tutup'),
            'status_beasiswa'         => $this->request->getPost('status_beasiswa'),
            'link_informasi'          => $this->request->getPost('link_informasi'),
            'poster'                  => $filePath,
        ];

        // 5. Update ke database
        if ($this->beasiswaModel->save($data)) {
            return redirect()->to(base_url('admin/beasiswa'))->with('success', 'Beasiswa berhasil diperbarui.');
        } else {
            // Ini akan terjadi jika ada masalah database, bukan validasi
            return redirect()->to(base_url('admin/beasiswa'))->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }
    /**
     * Menghapus data Beasiswa (Delete).
     */
    public function delete($id)
    {
        $beasiswa = $this->beasiswaModel->find($id);

        if (!$beasiswa) {
            return redirect()->to(base_url('admin/beasiswa'))->with('error', 'Beasiswa tidak ditemukan.');
        }

        // 1. Hapus file panduan jika ada
        $poster = $beasiswa['poster'];
        if ($poster && file_exists(WRITEPATH . 'uploads/beasiswa/' . $poster)) {
            unlink(WRITEPATH . 'uploads/beasiswa/' . $poster);
        }

        // 2. Hapus dari database
        if ($this->beasiswaModel->delete($id)) {
            return redirect()->to(base_url('admin/beasiswa'))->with('success', 'Beasiswa berhasil dihapus.');
        } else {
            return redirect()->to(base_url('admin/beasiswa'))->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
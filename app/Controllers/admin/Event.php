<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EventModel; 

class Event extends BaseController
{
    protected $eventModel;
    protected $helpers = ['form', 'url', 'filesystem']; // Tambahkan filesystem untuk upload

    public function __construct()
    {
        // Inisialisasi model
        $this->eventModel = new EventModel();
    }

    /**
     * Menampilkan daftar Event (Read) dan Filter/Search.
     */
    public function index()
    {
        // --- 1. Ambil input dari GET request (pencarian dan filter) ---
        $keyword = $this->request->getGet('keyword');

        // --- 2. Inisialisasi Query Model ---
        $query = $this->eventModel;

        // Terapkan Filter Keyword (Pencarian)
        if (!empty($keyword)) {
            // Mencari di kolom 'title' atau kolom relevan lainnya
            $query = $query->like('title', $keyword);
        }
        
        // Ambil data yang sudah difilter
        $perPage = 10;
        $event_list = $query->paginate($perPage, 'event');
        $pager = $query->pager;
        // $event_list = $query->findAll();

        $file_base_url = base_url('uploads/event') . '/';

        // --- 3. Siapkan data untuk View ---
        $data = [
            'title'         => 'Pengelolaan Event',
            'halaman'       => 'Daftar Event',
            'file_base_url' => $file_base_url,
            'event_list'    => $event_list, // Data untuk tabel
            'content'       => 'admin/event/index', // View utama
            'pager'         => $pager,
            // Kirim state filter kembali ke view agar form tetap terisi
            'filters' => [
                'keyword' => $keyword,
            ],
        ];
        
        // Memuat view dengan layout admin
        return view('template/wrapper', $data); 
    }

    /**
     * Menyimpan data Event baru (Create).
     */
    public function store()
    {
        if (!$this->validate($this->eventModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = null;
        $file = $this->request->getFile('file_save'); // Cek nama input field di form create Anda

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getName();
            // Perhatikan, WRITEPATH adalah folder internal. Untuk akses publik, 
            // file harus di-move ke folder 'public/uploads/event/'.
            // Di CI4, cara termudah adalah menggunakan move() ke folder FCPATH (public)
            
            // Pindahkan file ke folder publik (FCPATH menunjuk ke folder public)
            $file->move(FCPATH . 'uploads/event', $newName);
            
            $filePath = $newName;
        }

        // 3. Siapkan Data untuk disimpan
        $data = [
            'nama_event'           => $this->request->getPost('nama_event'),
            'deskripsi'            => $this->request->getPost('deskripsi'),
            'waktu'                => $this->request->getPost('waktu'),
            'biaya'                => $this->request->getPost('biaya'),
            'link_informasi'       => $this->request->getPost('link_informasi'),
            'file'                 => $filePath, // Simpan nama file
        ];

        // 4. Simpan ke database
        if ($this->eventModel->save($data)) {
            return redirect()->to(base_url('admin/event'))->with('success', 'Event berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }
    public function edit($id = null)
    {
        // Ambil data event berdasarkan ID
        $event = $this->eventModel->find($id);

        if (!$event) {
            // Mengembalikan status 404 jika data tidak ditemukan
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Event tidak ditemukan.']);
        }
        
        // Mengembalikan data sebagai JSON untuk diolah oleh JavaScript (seperti modal edit)
        return $this->response->setJSON($event);
    }

    /**
     * Memperbarui data Event yang sudah ada (Update).
     * @param int $id ID event
     */
    public function update($id)
    {
        // 1. Ambil data lama
        $old_data = $this->eventModel->find($id);

        if (!$old_data) {
            return redirect()->to(base_url('admin/event'))->with('error', 'Event tidak ditemukan.');
        }

        // 2. Validasi Input
        if (!$this->validate($this->eventModel->getValidationRules())) {
            // Redirect ke index dengan error flashdata (Mirip Pengumuman)
            return redirect()->to(base_url('admin/event'))->with('errors', $this->validator->getErrors());
        }

        $filePath = $old_data['file']; // Pertahankan file lama
        $file = $this->request->getFile('file_save');
        $remove_file = $this->request->getPost('remove_file'); // Checkbox untuk hapus file
        $uploadPath = FCPATH . 'uploads/event/'; // Menggunakan FCPATH

        // 3. Handle File Upload Baru atau Penghapusan File Lama
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Hapus file lama jika ada file baru di-upload
            if ($filePath && file_exists($uploadPath . $filePath)) {
                unlink($uploadPath . $filePath);
            }
            
            // Pindahkan file baru
            $newName = $file->getName();
            $file->move($uploadPath, $newName);
            $filePath = $newName;

        } elseif ($remove_file && $old_data['file']) {
            // Hapus file jika pengguna mencentang kotak 'remove_file'
            if (file_exists($uploadPath . $old_data['file'])) {
                unlink($uploadPath . $old_data['file']);
            }
            $filePath = null;
        }

        // 4. Siapkan Data untuk diperbarui
        $data = [
            'id'                  => $id, // Penting: sertakan ID untuk update
            'nama_event'          => $this->request->getPost('nama_event'),
            'waktu'               => $this->request->getPost('waktu'),
            'biaya'               => $this->request->getPost('biaya'),
            'deskripsi'           => $this->request->getPost('deskripsi'),
            'link_informasi'      => $this->request->getPost('link_informasi'),
            'file'                => $filePath,
        ];

        // 5. Update ke database
        if ($this->eventModel->save($data)) {
            return redirect()->to(base_url('admin/event'))->with('success', 'Event berhasil diperbarui.');
        } else {
            // Ini akan terjadi jika ada masalah database, bukan validasi
            return redirect()->to(base_url('admin/event'))->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }
    /**
     * Menghapus data Event (Delete).
     */
    public function delete($id)
    {
        $event = $this->eventModel->find($id);

        if (!$event) {
            return redirect()->to(base_url('admin/event'))->with('error', 'Event tidak ditemukan.');
        }

        // 1. Hapus file panduan jika ada
        $file = $event['file'];
        if ($file && file_exists(WRITEPATH . 'uploads/event/' . $file)) {
            unlink(WRITEPATH . 'uploads/event/' . $file);
        }

        // 2. Hapus dari database
        if ($this->eventModel->delete($id)) {
            return redirect()->to(base_url('admin/event'))->with('success', 'Event berhasil dihapus.');
        } else {
            return redirect()->to(base_url('admin/event'))->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengumumanModel;
use CodeIgniter\Files\File; // Untuk menangani upload file

class Pengumuman extends BaseController
{
    protected $pengumumanModel;
    protected $helpers = ['form', 'url']; // Tambahkan helper form dan url
    
    // Terapkan filter admin untuk keamanan
    protected $filters = ['admin'];

    public function __construct()
    {
        // Inisialisasi Model
        $this->pengumumanModel = new PengumumanModel();
    }

    // Menampilkan halaman index (Daftar Pengumuman)
    public function index()
    {
        // --- 1. Ambil input dari GET request (pencarian dan filter) ---
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');

        // --- 2. Inisialisasi Query Model ---
        $query = $this->pengumumanModel;

        // Terapkan Filter Keyword (Pencarian)
        if (!empty($keyword)) {
            // Mencari di kolom 'title' atau kolom relevan lainnya
            $query = $query->like('title', $keyword);
        }

        // Terapkan Filter Status
        // Pastikan $status TIDAK kosong agar tidak memfilter status=""
        if (!empty($status)) {
            $query = $query->where('status', $status);
        }

        // Ambil data yang sudah difilter
        // Jika tidak ada filter, ini setara dengan findAll()
        $pengumuman_list = $query->findAll();

        // --- 3. Siapkan data untuk View ---
        $data = [
            'title'             => 'Pengelolaan Pengumuman',
            'halaman'           => 'Daftar Pengumuman',
            'pengumuman_list'   => $pengumuman_list, // Data untuk tabel
            'content'           => 'admin/pengumuman/index', // View utama
            // Kirim state filter kembali ke view agar form tetap terisi
            'filters' => [
                'keyword' => $keyword,
                'status' => $status,
            ],
        ];
        
        // Memuat view dengan layout admin
        return view('template/wrapper', $data); 
    }
    public function store()
    {
        // 1. Validasi Input
        $rules = [
            'title'                 => 'required|min_length[5]|max_length[255]',
            'tanggal_publikasi'     => 'required|valid_date',
            'status'                => 'required|in_list[aktif,non-aktif,draf]',
            'file_pendukung'        => 'max_size[file_pendukung,5120]|ext_in[file_pendukung,pdf,doc,docx,zip,png,jpg,jpeg]', // Max 5MB, format yang diizinkan
        ];

        if (! $this->validate($rules)) {
            // Jika validasi gagal, kembali ke form dengan error
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Upload File (Jika ada)
        $file_path = null;
        $file = $this->request->getFile('file_pendukung');
        
        if ($file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getName(); // Nama file unik
            $file->move(ROOTPATH . 'public/uploads/pengumuman', $newName);
            $file_path = $newName;
        }

        // 3. Simpan Data ke Database
        $this->pengumumanModel->save([
            'title'                 => $this->request->getPost('title'),
            'tanggal_publikasi'     => $this->request->getPost('tanggal_publikasi'),
            'file_path'             => $file_path,
            'status'                => $this->request->getPost('status'),
            'created_at'            => date('Y-m-d H:i:s'),
            'updated_at'            => date('Y-m-d H:i:s'),
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->to(base_url('admin/pengumuman'))->with('success', 'Pengumuman baru berhasil ditambahkan!');
    }
    public function edit($id = null)
    {
        $pengumuman = $this->pengumumanModel->find($id);

        if (!$pengumuman) {
            // Mengembalikan status 404 jika data tidak ditemukan
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Pengumuman tidak ditemukan.']);
        }
        // Mengembalikan data sebagai JSON untuk diolah oleh JavaScript
        return $this->response->setJSON($pengumuman);
    }
    
    // FUNGSI UPDATE: Menyimpan perubahan (Update) - Tidak ada perubahan di sini
        public function update($id)
    {
        // Ambil data pengumuman lama
        $old_data = $this->pengumumanModel->find($id);

        if (!$old_data) {
             return redirect()->to(base_url('admin/pengumuman'))->with('error', 'Pengumuman tidak ditemukan.');
        }

        // 1. Validasi Input (gunakan rules yang sama)
        $rules = [
            'title'                 => 'required|min_length[5]|max_length[255]',
            'tanggal_publikasi'     => 'required|valid_date',
            'status'                => 'required|in_list[aktif,non-aktif,draf]',
            // File upload: optional, hanya divalidasi jika di-upload
            'file_pendukung'        => 'max_size[file_pendukung,5120]|ext_in[file_pendukung,pdf,doc,docx,zip, jpg, png, jpeg]',
        ];

        if (! $this->validate($rules)) {
            // Jika validasi gagal, kembalikan user ke index dengan error flashdata
            return redirect()->to(base_url('admin/pengumuman'))->with('errors', $this->validator->getErrors());
        }

        // 2. Penanganan File Upload
        $file_path = $old_data['file_path']; // Default: pertahankan file lama
        $file = $this->request->getFile('file_pendukung');
        $remove_file = $this->request->getPost('remove_file');

        if ($file->isValid() && ! $file->hasMoved()) {
            // Hapus file lama jika ada file baru di-upload
            if (!empty($old_data['file_path']) && file_exists(ROOTPATH . 'public/uploads/pengumuman/' . $old_data['file_path'])) {
                unlink(ROOTPATH . 'public/uploads/pengumuman/' . $old_data['file_path']);
            }
            // Simpan file baru
            $newName = $file->getName();
            $file->move(ROOTPATH . 'public/uploads/pengumuman', $newName);
            $file_path = $newName;

        } elseif ($remove_file && $old_data['file_path']) {
            // Hapus file jika pengguna mencentang kotak 'remove_file'
            if (file_exists(ROOTPATH . 'public/uploads/pengumuman/' . $old_data['file_path'])) {
                unlink(ROOTPATH . 'public/uploads/pengumuman/' . $old_data['file_path']);
            }
            $file_path = null;
        }

        // 3. Simpan Perubahan ke Database
        $this->pengumumanModel->update($id, [
            'title'                 => $this->request->getPost('title'),
            'tanggal_publikasi'     => $this->request->getPost('tanggal_publikasi'),
            'file_path'             => $file_path,
            'status'                => $this->request->getPost('status'),
            // 'updated_at' otomatis diisi oleh Model
        ]);

        // 4. Redirect dengan pesan sukses
        return redirect()->to(base_url('admin/pengumuman'))->with('success', 'Pengumuman berhasil diperbarui!');
    }
    
    // Fungsi untuk Hapus (DELETE)
    public function delete($id = null)
    {
        // Cari data untuk mendapatkan nama file
        $pengumuman = $this->pengumumanModel->find($id);

        if ($pengumuman) {
            // Hapus file dari server (jika ada)
            if (!empty($pengumuman['file_path']) && file_exists(ROOTPATH . 'public/uploads/pengumuman/' . $pengumuman['file_path'])) {
                unlink(ROOTPATH . 'public/uploads/pengumuman/' . $pengumuman['file_path']);
            }
            
            // Hapus data dari database
            $this->pengumumanModel->delete($id);

            return redirect()->to(base_url('admin/pengumuman'))->with('success', 'Pengumuman berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/pengumuman'))->with('error', 'Pengumuman tidak ditemukan.');
    }
}
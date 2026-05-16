<?php namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KatalogModel;
use CodeIgniter\Files\File;

class Katalog extends BaseController
{
    protected $katalogModel;

    public function __construct()
    {
        // Menginisialisasi model yang diperlukan
        $this->katalogModel = new KatalogModel();
        helper(['form', 'url']); 
    }

    /**
     * Menampilkan daftar katalog (Index View) dengan pencarian dan pagination.
     */
    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $filters = ['keyword' => $keyword];
        
        $query = $this->katalogModel;

        if (!empty($keyword)) {
            $query = $query->like('nama_barang', $keyword);
        }

        // Hanya tampilkan yang approved
        $query = $query->where('status_pengajuan', 'approved');

        // Pengaturan pagination 
        $perPage = 10;
        $katalog_list = $query->paginate($perPage, 'katalog');
        $pager = $query->pager;

        // Base URL untuk menampilkan foto. Sesuaikan dengan folder public Anda.
        $produk_base_url = base_url('uploads/katalog/');

        $data = [
            'title'           => 'Manajemen Katalog',
            'katalog_list'    => $katalog_list,
            'pager'           => $pager,
            'filters'         => $filters,
            'content'       => 'admin/katalog/index',
            'produk_base_url'   => $produk_base_url,
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Menampilkan daftar pengajuan katalog untuk approval.
     */
    public function pengajuan()
    {
        $keyword = $this->request->getGet('keyword');
        $status_pengajuan = $this->request->getGet('status_pengajuan');

        $query = $this->katalogModel;

        if (!empty($keyword)) {
            $query = $query->like('nama_barang', $keyword);
        }

        if (!empty($status_pengajuan)) {
            $query = $query->where('status_pengajuan', $status_pengajuan);
        }

        $perPage = 10;
        $pengajuan_list = $query->paginate($perPage, 'pengajuan');
        $pager = $query->pager;

        $produk_base_url = base_url('uploads/katalog/');

        $data = [
            'title'         => 'Pengajuan Katalog',
            'halaman'       => 'Daftar Pengajuan Katalog',
            'pengajuan_list' => $pengajuan_list,
            'content'       => 'admin/katalog/pengajuan',
            'pager'         => $pager,
            'produk_base_url' => $produk_base_url,
            'filters' => [
                'keyword' => $keyword,
                'status_pengajuan' => $status_pengajuan,
            ],
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Approve pengajuan katalog.
     */
    public function approve($id)
    {
        $katalog = $this->katalogModel->find($id);

        if (!$katalog) {
            return redirect()->to(base_url('admin/katalog/pengajuan'))->with('error', 'Pengajuan tidak ditemukan.');
        }

        $this->katalogModel->update($id, ['status_pengajuan' => 'approved']);

        return redirect()->to(base_url('admin/katalog/pengajuan'))->with('success', 'Pengajuan katalog disetujui.');
    }

    /**
     * Reject pengajuan katalog.
     */
    public function reject($id)
    {
        $katalog = $this->katalogModel->find($id);

        if (!$katalog) {
            return redirect()->to(base_url('admin/katalog/pengajuan'))->with('error', 'Pengajuan tidak ditemukan.');
        }

        $this->katalogModel->update($id, ['status_pengajuan' => 'rejected']);

        return redirect()->to(base_url('admin/katalog/pengajuan'))->with('success', 'Pengajuan katalog ditolak.');
    }

    /**
     * Menyimpan data Katalog baru (POST request dari modal Create).
     */
    public function store()
    {
        // 1. Validasi Input Data Katalog
        if (!$this->validate($this->katalogModel->getValidationRules())) {
            return redirect()->back()
                             ->withInput()
                             ->with('errors', $this->validator->getErrors());
        }
        $filePath = null;
        $fotoProduk = $this->request->getFile('foto_produk'); // Cek nama input field di form create Anda

        if ($fotoProduk && $fotoProduk->isValid() && !$fotoProduk->hasMoved()) {
            $newName = $fotoProduk->getName();
            // Perhatikan, WRITEPATH adalah folder internal. Untuk akses publik, 
            // file harus di-move ke folder 'public/uploads/lomba/'.
            // Di CI4, cara termudah adalah menggunakan move() ke folder FCPATH (public)
            
            // Pindahkan file ke folder publik (FCPATH menunjuk ke folder public)
            $fotoProduk->move(FCPATH . 'uploads/katalog', $newName);
            
            $filePath = $newName;
        }

        $data_katalog = [
            'nama_barang'   => $this->request->getPost('nama_barang'),
            'deskripsi'     => $this->request->getPost('deskripsi'),
            'harga'         => $this->request->getPost('harga'),        
            'link_jual'     => $this->request->getPost('link_jual'),
            'foto_produk'   => $filePath,
            'status_pengajuan' => 'approved',
            'user_id'      => session()->get('user_id'),
        ];

        if ($this->katalogModel->save($data_katalog)) {
            return redirect()->to(base_url('admin/katalog'))->with('success', 'Katalog berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Mengambil data untuk Modal Edit (AJAX/JSON).
     */
    public function edit($id = null)
    {
        $katalog = $this->katalogModel->find($id);

        if (!$katalog) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Katalog tidak ditemukan.']);
        }
        
        return $this->response->setJSON($katalog);
    }

    /**
     * Memperbarui data Katalog (Update).
     */
    public function update($id = null)
    {
        // 1. Ambil data lama
        $old_data = $this->katalogModel->find($id);

        if (!$old_data) {
            return redirect()->to(base_url('admin/katalog'))->with('error', 'Katalog tidak ditemukan.');
        }

        // 2. Validasi Input
        if (!$this->validate($this->katalogModel->getValidationRules())) {
            return redirect()->to(base_url('admin/katalog'))->with('errors', $this->validator->getErrors());
        }

        $filePath = $old_data['foto_produk']; // Pertahankan file lama sebagai default
        $fotoProduk = $this->request->getFile('foto_produk');
        $remove_foto = $this->request->getPost('remove_foto'); // Checkbox hapus foto
        $uploadPath = FCPATH . 'uploads/katalog/';

        // 3. Handle File Upload atau Penghapusan
        if ($fotoProduk && $fotoProduk->isValid() && !$fotoProduk->hasMoved()) {
            // Hapus file lama jika ada file baru
            if ($filePath && file_exists($uploadPath . $filePath)) {
                unlink($uploadPath . $filePath);
            }
            
            $newName = $fotoProduk->getName();
            $fotoProduk->move($uploadPath, $newName);
            $filePath = $newName;

        } elseif ($remove_foto && $old_data['foto_produk']) {
            // Hapus file jika checkbox 'remove_foto' dicentang
            if (file_exists($uploadPath . $old_data['foto_produk'])) {
                unlink($uploadPath . $old_data['foto_produk']);
            }
            $filePath = null;
        }

        // 4. Siapkan Data Update
        $data = [
            'id'          => $id,
            'nama_barang' => $this->request->getPost('nama_barang'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'harga'       => $this->request->getPost('harga'),
            'link_jual'   => $this->request->getPost('link_jual'),
            'foto_produk' => $filePath,
        ];

        if ($this->katalogModel->save($data)) {
            return redirect()->to(base_url('admin/katalog'))->with('success', 'Katalog berhasil diperbarui.');
        } else {
            return redirect()->to(base_url('admin/katalog'))->with('error', 'Terjadi kesalahan saat memperbarui data.');
        }
    }

    /**
     * Menghapus Katalog (GET request - Soft Delete).
     */
    public function delete($id = null)
    {
        if (!$id) {
            return redirect()->to(base_url('admin/katalog'))->with('error', 'ID Katalog tidak valid.');
        }

        if ($this->katalogModel->delete($id)) {
            // Jika diperlukan, Anda juga bisa melakukan soft delete atau unlink file foto terkait di sini.
            
            return redirect()->to(base_url('admin/katalog'))->with('success', 'Katalog berhasil dihapus.');
        } else {
            return redirect()->to(base_url('admin/katalog'))->with('error', 'Gagal menghapus katalog.');
        }
    }
}

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
            // Anda dapat menambahkan data lain seperti daftar kategori jika diperlukan
        ];

        // Memuat view index
        return view('template/wrapper', $data);
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
            // 'user_id'      => auth()->id(), // Contoh jika menggunakan sistem Auth
        ];

        if ($this->katalogModel->save($data_katalog)) {
            return redirect()->to(base_url('admin/katalog'))->with('success', 'Katalog berhasil ditambahkan.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    /**
     * Memperbarui data Katalog (POST request dari modal Edit).
     */
    public function update($id = null)
    {
        if (!$id || !$this->katalogModel->find($id)) {
             return redirect()->to(base_url('admin/katalog'))->with('error', 'Katalog tidak ditemukan.');
        }
        
        // Logika validasi dan update data katalog
        // ... (Mirip seperti store, namun menggunakan $this->katalogModel->update($id, $data)) ...

        return redirect()->to(base_url('admin/katalog'))->with('success', 'Katalog berhasil diperbarui.');
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
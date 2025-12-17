<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class Berita extends BaseController
{
    protected $beritaModel;
    protected $helpers = ['form', 'url', 'filesystem']; // Tambahkan filesystem untuk upload

    public function __construct()
    {
        // Inisialisasi model
        $this->beritaModel = new BeritaModel();
    }

    /**
     * Menampilkan daftar Berita (Read) dan Filter/Search.
     */
    public function index()
    {
        // --- 1. Ambil input dari GET request (pencarian dan filter) ---
        $keyword = $this->request->getGet('keyword');

        // --- 2. Inisialisasi Query Model ---
        $query = $this->beritaModel;

        // Terapkan Filter Keyword (Pencarian)
        if (!empty($keyword)) {
            // Mencari di kolom 'title' atau kolom relevan lainnya
            $query = $query->like('title', $keyword);
        }
        
        // Ambil data yang sudah difilter
        $perPage = 10;
        $berita_list = $query->paginate($perPage, 'berita');
        $pager = $query->pager;
        // $berita_list = $query->findAll();

        $file_base_url = base_url('uploads/berita') . '/';

        // --- 3. Siapkan data untuk View ---
        $data = [
            'title'         => 'Pengelolaan Berita',
            'halaman'       => 'Daftar Berita',
            'file_base_url' => $file_base_url,
            'berita_list'    => $berita_list, // Data untuk tabel
            'content'       => 'admin/berita/index', // View utama
            'pager'         => $pager,
            // Kirim state filter kembali ke view agar form tetap terisi
            'filters' => [
                'keyword' => $keyword,
            ],
        ];
        
        // Memuat view dengan layout admin
        return view('template/wrapper', $data); 
    }
}

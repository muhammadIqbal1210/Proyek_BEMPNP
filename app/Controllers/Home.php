<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengumumanModel; // Menggunakan PengumumanModel

/**
 * Controller untuk mengelola tampilan halaman publik (Frontend)
 * yang menampilkan data Pengumuman yang aktif.
 */
class Home extends BaseController
{
    protected $pengumumanModel;

    /**
     * Konstruktor untuk inisialisasi Model.
     */
    public function __construct()
    {
        // Inisialisasi model Pengumuman
        $this->pengumumanModel = new PengumumanModel();
        helper(['url']); // Memuat helper URL untuk base_url()
    }
    
    /**
     * Method default untuk halaman utama (Homepage).
     * Dapat digunakan untuk menampilkan 3 pengumuman terbaru sebagai cuplikan.
     */
    public function index(): string
    {
        // Ambil 3 pengumuman terbaru yang berstatus 'aktif'
        $latestAnnouncements = $this->pengumumanModel
            ->where('status', 'aktif')
            ->orderBy('tanggal_publikasi', 'DESC')
            ->limit(3)
            ->findAll();

        $data = [
            'title' => 'Home Page',
            'latest_announcements' => $latestAnnouncements,
            'file_base_url' => base_url('uploads/pengumuman/'),
            // Data lain untuk homepage
        ];

        // Asumsi: View untuk homepage berada di 'frontend/homepage'
        return view('welcome_message'); 
    }

    /**
     * Menampilkan daftar semua pengumuman yang aktif dengan pagination.
     * Diasumsikan route-nya mengarah ke /pengumuman
     */
    public function pengumuman(): string
    {
        // 1. Konfigurasi Pagination
        $perPage = 10;
        
        // 2. Bangun Query: Filter hanya 'aktif' dan urutkan berdasarkan tanggal
        $query = $this->pengumumanModel
                      ->where('status', 'aktif')
                      ->orderBy('tanggal_publikasi', 'DESC');

        // 3. Paginate data
        $pengumuman_list = $query->paginate($perPage, 'pengumuman');
        $pager = $query->pager;
        
        // 4. Base URL untuk file yang dapat diunduh
        $file_base_url = base_url('uploads/pengumuman/');

        $data = [
            'title'             => 'Daftar Pengumuman Resmi',
            'pengumuman_list'   => $pengumuman_list,
            'pager'             => $pager,
            'file_base_url'     => $file_base_url,
        ];
        
        // Asumsi: View untuk daftar pengumuman berada di 'frontend/pengumuman/list'
        return view('frontend/pengumuman/list', $data); 
    }

    /**
     * Menampilkan detail dari satu pengumuman berdasarkan ID.
     * Diasumsikan route-nya mengarah ke /pengumuman/detail/{id}
     */
    public function detail($id = null): string
    {
        if (!$id) {
             // Lempar exception jika ID tidak valid
             throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pengumuman tidak ditemukan.');
        }

        // Cari pengumuman berdasarkan ID, dan PASTIKAN statusnya 'aktif'
        $pengumuman = $this->pengumumanModel
                           ->where('status', 'aktif')
                           ->find($id);

        if (!$pengumuman) {
            // Jika tidak ditemukan atau statusnya bukan 'aktif', lempar 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pengumuman yang Anda cari tidak tersedia atau sudah dihapus.');
        }
        
        $file_base_url = base_url('uploads/pengumuman/');

        $data = [
            'title'             => $pengumuman['title'],
            'pengumuman'        => $pengumuman,
            'file_base_url'     => $file_base_url,
        ];

        // Asumsi: View untuk detail pengumuman berada di 'frontend/pengumuman/detail'
        return view('frontend/pengumuman/detail', $data);
    }
}
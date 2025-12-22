<?php namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PengumumanModel; 
use App\Models\LaporanModel;
use App\Models\KatalogModel;
use App\Models\BeasiswaModel;
use App\Models\LombaModel;
use App\Models\EventModel;

/**
 * Controller untuk mengelola tampilan halaman publik (Frontend)
 * yang menampilkan data Pengumuman yang aktif.
 */
class Home extends BaseController
{
    protected $pengumumanModel;
    protected $beasiswaModel;
    protected $lombaModel;
    protected $eventModel;

    /**
     * Konstruktor untuk inisialisasi Model.
     */
    public function __construct()
    {
        helper(['url']); // Memuat helper URL untuk base_url()
        // Inisialisasi model Pengumuman
        $this->pengumumanModel = new PengumumanModel();
        $this->beasiswaModel   = new BeasiswaModel();
        $this->lombaModel   = new LombaModel();
        $this->eventModel   = new EventModel();
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
    public function detailpengumuman($id = null): string
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
    public function layanan()
    {
        $data = [
            'title' => 'Layanan Kami - BEM KM PNP'
        ];
        return view('frontend/layanan', $data);
    }
    public function advokasi()
    {
        return view('frontend/lapor');
    }
    public function kirim_lapor()
{
    // 1. Definisikan validasi untuk multiple files
    $validationRules = [
        'nama' => 'required',
        'isi'  => 'required',
        'lampiran' => [
            'rules' => 'uploaded[lampiran]|max_size[lampiran,2048]|is_image[lampiran]|mime_in[lampiran,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'uploaded' => 'Pilih setidaknya satu file.',
                'max_size' => 'Salah satu ukuran file melebihi 2MB.',
                'is_image' => 'Salah satu file bukan merupakan gambar.',
                'mime_in'  => 'Format file harus JPG, JPEG, atau PNG.'
            ]
        ]
    ];

    if (!$this->validate($validationRules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    // 2. Tangani Upload Banyak File
    $files = $this->request->getFiles();
    $daftarNamaFile = [];

    // Pastikan 'lampiran' ada di dalam array files
    if (isset($files['lampiran'])) {
        foreach ($files['lampiran'] as $fileLampiran) {
            // Cek apakah file valid (ini mencegah error isValid() on null)
            if ($fileLampiran->isValid() && !$fileLampiran->hasMoved()) {
                // Generate nama random agar tidak duplikat
                $namaFileBaru = $fileLampiran->getRandomName();
                // Pindahkan ke folder public/uploads/laporan
                $fileLampiran->move(FCPATH . 'uploads/laporan', $namaFileBaru);
                
                // Tambahkan nama file ke array hasil upload
                $daftarNamaFile[] = $namaFileBaru;
            }
        }
    }

    // 3. Simpan ke Database
    // Kita menggabungkan nama-nama file menjadi satu string yang dipisahkan koma
    // Contoh: "123456.jpg,789012.png" agar bisa masuk ke kolom string/text di DB
    $namaFileUntukDB = implode(',', $daftarNamaFile);

    $model = new LaporanModel();
    $data = [
        'nama'     => $this->request->getPost('nama'),
        'nim'      => $this->request->getPost('nim'),
        'kategori' => $this->request->getPost('kategori'),
        'kontak'   => $this->request->getPost('kontak'),
        'isi'      => $this->request->getPost('isi'),
        'lampiran' => $namaFileUntukDB, 
        'status'   => 'Masuk'
    ];

    if ($model->insert($data)) {
        return redirect()->to('/layanan/advokasi')->with('success', 'Laporan dan semua file berhasil dikirim!');
    }

    return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data.');
    }
    public function katalog()
    {
        $model = new KatalogModel();
        
        // Mengambil keyword dari pencarian jika ada
        $keyword = $this->request->getVar('keyword');
        
        if ($keyword) {
            $katalogObj = $model->like('nama_barang', $keyword)->orLike('deskripsi', $keyword);
        } else {
            $katalogObj = $model;
        }

        $data = [
            'title'            => 'Katalog Produk Kami',
            'katalog_list'     => $katalogObj->paginate(12, 'katalog'),
            'pager'            => $model->pager,
            'keyword'          => $keyword,
            'produk_base_url'  => base_url('uploads/katalog/') // Sesuaikan folder upload Anda
        ];

        return view('frontend/katalog/list', $data);
    }
    public function beasiswa()
    {
        $model = new BeasiswaModel();
        $keyword = $this->request->getVar('keyword');
        
        if ($keyword) {
            $beasiswaObj = $model->like('nama_beasiswa', $keyword)->orLike('deskripsi', $keyword);
        } else {
            $beasiswaObj = $model;
        }

        $data = [
            'title'             => 'Data Beasiswa Mahasiswa',
            'beasiswa_list'      => $beasiswaObj->paginate(12, 'beasiswa'),
            'pager'             => $model->pager,
            'keyword'           => $keyword,
            'beasiswa_base_url' => base_url('uploads/beasiswa/') // Folder khusus gambar beasiswa
        ];

        return view('frontend/beasiswa/list', $data);
    }
    public function detailbeasiswa($id = null): string
    {
        if (!$id) {
             // Lempar exception jika ID tidak valid
             throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pengumuman tidak ditemukan.');
        }

        $beasiswa = $this->beasiswaModel->find($id);

        if (!$beasiswa) {
            // Jika tidak ditemukan atau statusnya bukan 'aktif', lempar 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Beasiswa yang Anda cari tidak tersedia atau sudah dihapus.');
        }
        
        $beasiswa_base_url = base_url('uploads/beasiswa/');

        $data = [
            'title'             => $beasiswa['nama_beasiswa'],
            'beasiswa'          => $beasiswa,
            'beasiswa_base_url' => $beasiswa_base_url,
        ];

        // Asumsi: View untuk detail pengumuman berada di 'frontend/pengumuman/detail'
        return view('frontend/beasiswa/detail', $data);
    }
    public function lomba()
    {
        $model = new LombaModel();
        $keyword = $this->request->getVar('keyword');
        
        if ($keyword) {
            $lombaObj = $model->like('nama_lomba', $keyword)->orLike('deskripsi', $keyword);
        } else {
            $lombaObj = $model;
        }

        $data = [
            'title'             => 'Informasi Lomba',
            'lomba_list'        => $lombaObj->paginate(12, 'lomba'),
            'pager'             => $model->pager,
            'keyword'           => $keyword,
            'poster_base_url'   => base_url('uploads/lomba/') // Folder khusus gambar beasiswa
        ];

        return view('frontend/lomba/list', $data);
    }
    public function detaillomba($id = null): string
    {
        if (!$id) {
             // Lempar exception jika ID tidak valid
             throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Lomba tidak ditemukan.');
        }

        $lomba = $this->lombaModel->find($id);

        if (!$lomba) {
            // Jika tidak ditemukan atau statusnya bukan 'aktif', lempar 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Beasiswa yang Anda cari tidak tersedia atau sudah dihapus.');
        }
        
        $poster_base_url = base_url('uploads/lomba/');

        $data = [
            'title'           => $lomba['nama_lomba'],
            'lomba'           => $lomba,
            'poster_base_url' => $poster_base_url,
        ];

        // Asumsi: View untuk detail pengumuman berada di 'frontend/pengumuman/detail'
        return view('frontend/lomba/detail', $data);
    }
    public function event()
    {
        $model = new eventModel();
        $keyword = $this->request->getVar('keyword');
        
        if ($keyword) {
            $eventObj = $model->like('nama_event', $keyword)->orLike('deskripsi', $keyword);
        } else {
            $eventObj = $model;
        }

        $data = [
            'title'             => 'Informasi Event',
            'event_list'        => $eventObj->paginate(12, 'event'),
            'pager'             => $model->pager,
            'keyword'           => $keyword,
            'file_base_url'   => base_url('uploads/event/') // Folder khusus gambar beasiswa
        ];

        return view('frontend/event/list', $data);
    }
    public function detailevent($id = null): string
    {
        if (!$id) {
             // Lempar exception jika ID tidak valid
             throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Lomba tidak ditemukan.');
        }

        $event = $this->eventModel->find($id);

        if (!$event) {
            // Jika tidak ditemukan atau statusnya bukan 'aktif', lempar 404
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Event yang Anda cari tidak tersedia atau sudah dihapus.');
        }
        
        $file_base_url = base_url('uploads/event/');

        $data = [
            'title'           => $event['nama_event'],
            'event'           => $event,
            'file_base_url'   => $file_base_url,
        ];

        // Asumsi: View untuk detail pengumuman berada di 'frontend/pengumuman/detail'
        return view('frontend/event/detail', $data);
    }

}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class Laporan extends BaseController
    {
    protected $LaporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Mengambil filter dari GET request
        $keyword = $this->request->getGet('keyword');
        $filters = ['keyword' => $keyword];
        
        $query = $this->laporanModel;

        // // Simulasi Data (Ganti dengan $this->advokasiModel sesuai logika beasiswa Anda)
        // $laporan = [
        //     [
        //         'title' => 'Laporan Advokasi',
        //         'id' => 1,
        //         'nama' => 'Budi Santoso',
        //         'nim' => '21010122',
        //         'kategori' => 'Fasilitas',
        //         'isi' => 'AC di ruang kelas 3.2 mati total sejak seminggu lalu.',
        //         'kontak' => '08123456789',
        //         'status' => 'Masuk',
        //         'lampiran' => 'lampiran_1.jpg',
        //         'created_at' => '2023-10-24 08:30:00'
        //     ],
        //     [
        //         'id' => 2,
        //         'nama' => 'Siti Aminah',
        //         'nim' => '21010145',
        //         'kategori' => 'Akademik',
        //         'isi' => 'Nilai mata kuliah Basis Data belum keluar di KHS.',
        //         'kontak' => '08571234567',
        //         'status' => 'Proses',
        //         'lampiran' => '',
        //         'created_at' => '2023-10-23 14:20:00'
        //     ]
        // ];
        $perPage = 10;
        $laporan_list = $query->paginate($perPage, 'laporan');
        $pager = $query->pager;

        // Base URL untuk menampilkan foto. Sesuaikan dengan folder public Anda.
        // $produk_base_url = base_url('uploads/katalog/');

        $data = [
            'title'        => 'Manajemen Advokasi',
            'laporan_list' => $laporan_list,
            'filters'      => $filters,
            'pager'         => $pager,
            'content'       => 'admin/laporan/index',
            'lampiran_url' => base_url('uploads/laporan/') 
        ];

        return view('template/wrapper', $data);
    }

    public function update_status($id)
    {
        $status = $this->request->getPost('status');
        
        // Logika update ke database
        // $this->advokasiModel->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diubah menjadi ' . $status);
    }

    public function delete($id)
    {
        // Logika hapus
        // $this->advokasiModel->delete($id);

        return redirect()->back()->with('success', 'Data pengaduan berhasil dihapus.');
    }
}
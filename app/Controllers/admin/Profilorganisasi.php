<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfilorganisasiModel;

class Profilorganisasi extends BaseController
{
    protected $profilorganisasiModel;

    protected $helpers = ['form', 'url']; // Tambahkan helper form dan url
    // Terapkan filter admin untuk keamanan
    protected $filters = ['admin'];

    public function __construct()
    {
        $this->profilorganisasiModel = new ProfilorganisasiModel();
        
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        
        if (!empty($keyword)) {
            $this->profilorganisasiModel->like('nama_kabinet', $keyword);
        }

        $data = [
            'title'       => 'Pengelolaan Profil Organisasi',
            'halaman'     => 'Daftar Profil Organisasi',
            'profil_list' => $this->profilorganisasiModel->paginate(10, 'default'),
            'pager'       => $this->profilorganisasiModel->pager,
            'content'     => 'admin/profil/index', 
        ];

        return view('template/wrapper', $data);
    }

    // File: App/Controllers/Admin/Profilorganisasi.php

public function store()
    {
        // Ambil data misi dari input
        $misiArray = $this->request->getPost('misi');

        // Bersihkan array (hapus yang kosong)
        $misiFiltered = [];
        if (is_array($misiArray)) {
            $misiFiltered = array_filter($misiArray, function($value) {
                return !empty(trim($value));
            });
        }

        // Data untuk disimpan
        $data = [
            'nama_kabinet' => $this->request->getPost('nama_kabinet'),
            'periode'      => $this->request->getPost('periode'),
            'videoprofil'  => $this->request->getPost('videoprofil'),
            'visi'         => $this->request->getPost('visi'),
            // Simpan sebagai JSON string
            'misi'         => json_encode(array_values($misiFiltered)),
            's_pres'       => $this->request->getPost('s_pres'),
            's_wapres'     => $this->request->getPost('s_wapres'),
        ];

        // Hapus validasi manual ($this->validate), biarkan model->save() yang menangani validasi
        // Cek apakah save berhasil
        if ($this->profilorganisasiModel->save($data) === false) {
            // Jika GAGAL, kembalikan ke form dengan input sebelumnya dan list error
            return redirect()->back()->withInput()->with('errors', $this->profilorganisasiModel->errors());
        }

        // Jika BERHASIL
        return redirect()->to(base_url('admin/profil'))->with('success', 'Data berhasil disimpan');
    }
}
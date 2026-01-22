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

    public function store()
    {
        dd('STORE TERPANGGIL');
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BeritaModel; 

class Berita extends BaseController
{
    protected $beritaModel;

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }

    public function index()
    {
        $query = $this->beritaModel;

        $perPage = 10;
        $berita_list = $query->paginate($perPage, 'berita');
        $pager = $query->pager;

        $data = [
            'title'         => 'Manajemen Berita',
            'berita_list'   => $berita_list,
            'content'       => 'admin/berita/index',
            'filters'       => $this->request->getGet(),
            'pager'         => $pager,
            'berita_base_url' => base_url('uploads/berita/')
        ];
        return view('template/wrapper', $data); 
    }

    public function store()
    {
        // Validasi
        if (!$this->validate([
            'judulberita' => 'required',
            'isiberita'   => 'required',
            'gambarberita' => 'uploaded[gambarberita]|max_size[gambarberita,2048]|is_image[gambarberita]'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileGambar = $this->request->getFile('gambarberita');
        $namaGambar = $fileGambar->getRandomName();
        $fileGambar->move('uploads/berita', $namaGambar);

        $this->beritaModel->save([
            'judulberita'   => $this->request->getPost('judulberita'),
            'slugberita'    => url_title($this->request->getPost('judulberita'), '-', true),
            'isiberita'     => $this->request->getPost('isiberita'), // Data dari CKEditor
            'gambarberita'  => $namaGambar,
            'tanggalberita' => date('Y-m-d'),
            'author'        => session()->get('nama_user') ?? 'Admin'
        ]);

        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diterbitkan.');
    }
}
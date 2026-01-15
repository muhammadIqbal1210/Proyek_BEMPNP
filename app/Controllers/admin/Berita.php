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
    public function edit($id)
    {
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Data berita tidak ditemukan.']);
        }

        // Pastikan mengembalikan variabel $berita
        return $this->response->setJSON($berita);
    }

    public function update($id)
    {
        $beritaLama = $this->beritaModel->find($id);

        if (!$beritaLama) {
            return redirect()->to(base_url('admin/berita'))->with('error', 'Berita tidak ditemukan.');
        }

        $fileGambar = $this->request->getFile('gambarberita');
        
        // Aturan validasi
        $rules = [
            'judulberita' => 'required',
            'isiberita'   => 'required'
        ];

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            $rules['gambarberita'] = 'max_size[gambarberita,2048]|is_image[gambarberita]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        if ($fileGambar && $fileGambar->isValid() && !$fileGambar->hasMoved()) {
            // Hapus lama
            if ($beritaLama['gambarberita'] && file_exists('uploads/berita/' . $beritaLama['gambarberita'])) {
                unlink('uploads/berita/' . $beritaLama['gambarberita']);
            }
            $namaGambar = $fileGambar->getRandomName();
            $fileGambar->move('uploads/berita', $namaGambar);
        } else {
            $namaGambar = $this->request->getPost('gambarLama');
        }

        $this->beritaModel->update($id, [
            'judulberita'   => $this->request->getPost('judulberita'),
            'slugberita'    => url_title($this->request->getPost('judulberita'), '-', true),
            'isiberita'     => $this->request->getPost('isiberita'),
            'gambarberita'  => $namaGambar,
            'tanggalberita' => $this->request->getPost('tanggalberita'),
            'author'        => session()->get('nama_user') ?? $beritaLama['author']
        ]);

        return redirect()->to('/admin/berita')->with('success', 'Berita berhasil diperbarui.');
    }
    public function delete($id)
    {
        $berita = $this->beritaModel->find($id);

        if (!$berita) {
            return redirect()->to(base_url('admin/berita'))->with('error', 'berita tidak ditemukan.');
        }

        // 1. Hapus file panduan jika ada
        $gambarberita = $berita['gambarberita'];
        if ($gambarberita && file_exists(WRITEPATH . 'uploads/berita/' . $gambarberita)) {
            unlink(WRITEPATH . 'uploads/berita/' . $gambarberita);
        }

        // 2. Hapus dari database
        if ($this->beritaModel->delete($id)) {
            return redirect()->to(base_url('admin/berita'))->with('success', 'berita berhasil dihapus.');
        } else {
            return redirect()->to(base_url('admin/berita'))->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
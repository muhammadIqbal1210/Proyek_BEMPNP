<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProfilorganisasiModel;

class Profilorganisasi extends BaseController
{
    protected $profilorganisasiModel;
    protected $helpers = ['form', 'url'];
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
        $misiArray = $this->request->getPost('misi');

        $misiFiltered = [];
        if (is_array($misiArray)) {
            $misiFiltered = array_filter($misiArray, function($value) {
                return !empty(trim($value));
            });
        }

        $data = [
            'nama_kabinet' => $this->request->getPost('nama_kabinet'),
            'periode'      => $this->request->getPost('periode'),
            'videoprofil'  => $this->request->getPost('videoprofil'),
            'visi'         => $this->request->getPost('visi'),
            'misi'         => json_encode(array_values($misiFiltered)),
            's_pres'       => $this->request->getPost('s_pres'),
            's_wapres'     => $this->request->getPost('s_wapres'),
        ];

        if ($this->profilorganisasiModel->save($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->profilorganisasiModel->errors());
        }

        return redirect()->to(base_url('admin/profil'))->with('success', 'Data berhasil disimpan');
    }
    /**
 * Method untuk mengambil data profil guna keperluan edit (AJAX)
 */
    public function edit($id = null)
    {
        // Pastikan request datang dari AJAX (Opsional tapi direkomendasikan)
        if (!$this->request->isAJAX()) {
            return redirect()->to(base_url('admin/profil'));
        }

        $profilModel = new \App\Models\ProfilorganisasiModel();
        
        // Cari data berdasarkan ID
        $data = $profilModel->find($id);

        if ($data) {
            // Mengembalikan data dalam format JSON
            return $this->response->setJSON($data);
        } else {
            // Jika data tidak ditemukan, kirim status 404
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data profil tidak ditemukan.'
            ])->setStatusCode(404);
        }
    }

    /**
     * Fungsi Update Data Profil
     */
    public function update($id)
    {
        // Ambil data misi dari input
        $misiArray = $this->request->getPost('misi');

        // Bersihkan array misi
        $misiFiltered = [];
        if (is_array($misiArray)) {
            $misiFiltered = array_filter($misiArray, function($value) {
                return !empty(trim($value));
            });
        }

        $data = [
            'id'           => $id, // ID penting agar model melakukan UPDATE bukan INSERT
            'nama_kabinet' => $this->request->getPost('nama_kabinet'),
            'periode'      => $this->request->getPost('periode'),
            'videoprofil'  => $this->request->getPost('videoprofil'),
            'visi'         => $this->request->getPost('visi'),
            'misi'         => json_encode(array_values($misiFiltered)),
            's_pres'       => $this->request->getPost('s_pres'),
            's_wapres'     => $this->request->getPost('s_wapres'),
        ];

        if ($this->profilorganisasiModel->save($data) === false) {
            return redirect()->back()->withInput()->with('errors', $this->profilorganisasiModel->errors());
        }

        return redirect()->to(base_url('admin/profil'))->with('success', 'Data berhasil diperbarui');
    }

    /**
     * Fungsi Hapus Data Profil
     */
    public function delete($id)
    {
        // Cek apakah data ada
        $data = $this->profilorganisasiModel->find($id);
        
        if ($data) {
            $this->profilorganisasiModel->delete($id);
            return redirect()->to(base_url('admin/profil'))->with('success', 'Data berhasil dihapus');
        }

        return redirect()->to(base_url('admin/profil'))->with('error', 'Data tidak ditemukan');
    }
}
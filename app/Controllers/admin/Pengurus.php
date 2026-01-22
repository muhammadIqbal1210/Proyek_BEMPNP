<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PengurusModel;

class Pengurus extends BaseController
{
    protected $pengurusModel;
    protected $helpers = ['form', 'url']; // Tambahkan helper form dan url
    // Terapkan filter admin untuk keamanan
    protected $filters = ['admin'];

    public function __construct()
    {
        // Inisialisasi Model
        $this->pengurusModel = new PengurusModel();
    }
    public function index()
    {
        // --- 1. Ambil input dari GET request (pencarian dan filter) ---
        $keyword = $this->request->getGet('keyword');
        $kementerian = $this->request->getGet('kementerian');

        // --- 2. Inisialisasi Query Model ---
        // Gunakan $this->pengurusModel langsung untuk membangun query
        if (!empty($keyword)) {
            $this->pengurusModel->like('nama', $keyword); // Sesuaikan 'nama' atau 'title' dengan database Anda
        }

        if (!empty($kementerian)) {
            $this->pengurusModel->where('kementerian', $kementerian);
        }

        // --- 3. Eksekusi Pagination ---
        // paginate() akan otomatis menangani limit, offset, dan menginisialisasi pager internal model
        $penguruslist = $this->pengurusModel->paginate(10, 'default');

        // --- 4. Siapkan data untuk View ---
        $data = [
            'title'           => 'Pengelolaan Pengurus',
            'halaman'         => 'Daftar Pengurus',
            'pengurus_list'   => $penguruslist,           // Data hasil pagination
            'pager'           => $this->pengurusModel->pager, // Ambil objek pager dari model
            'content'         => 'admin/pengurus/index',  // View utama
            'foto_base_url'   => base_url('uploads/pengurus') . '/',
            'filters'         => [
                'keyword'     => $keyword,
                'kementerian' => $kementerian,
            ],
        ];

        // Memuat view dengan layout admin
        return view('template/wrapper', $data);
    }
    public function store()
    {
        // Validasi input
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama' => 'required|string|max_length[255]',
            'jabatan' => 'required|string',
            'kementerian' => 'required|in_list[kepresidenan,audit_internal,kesekretariatan,keuangan,psdm,adkesma,sosmas,dagri,mitbis,lugri,kastrat,komris,pp]',
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,2048]', // Maks 2MB
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembalikan ke form dengan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Proses upload foto jika ada
        $foto_path = null;
        $foto = $this->request->getFile('foto');

        if ($foto->isValid() && ! $foto->hasMoved()) {
            $newName = $foto->getName(); // Nama file unik
            $foto->move(ROOTPATH . 'public/uploads/pengurus', $newName);
            $foto_path = $newName;
        }

        // Simpan data ke database
        $this->pengurusModel->save([
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'kementerian' => $this->request->getPost('kementerian'),
            'foto' => $foto_path,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->to('/admin/pengurus')->with('success', 'Pengurus berhasil ditambahkan.');
    }
    public function edit($id = null): ResponseInterface
    {
        // Ambil data pengurus berdasarkan ID
        $pengurus = $this->pengurusModel->find($id);

        if (!$pengurus) {
            return $this->response->setStatusCode(404)->setBody('Pengurus tidak ditemukan.');
        }

        // Kembalikan data dalam format JSON
        return $this->response->setJSON($pengurus);
    }
    public function update()
    {
        // Validasi input
        $validation = \Config\Services::validation();

        $validation->setRules([
            'nama' => 'required|string|max_length[255]',
            'jabatan' => 'required|string',
            'kementerian' => 'required|in_list[kepresidenan,audit_internal,kesekretariatan,keuangan,psdm,adkesma,sosmas,dagri,mitbis,lugri,kastrat,komris,pp]',
            'foto' => 'permit_empty|is_image[foto]|max_size[foto,2048]', // Maks 2MB
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembalikan ke form dengan error
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $id = $this->request->getPost('id');
        $pengurus = $this->pengurusModel->find($id);

        if (!$pengurus) {
            return redirect()->back()->with('error', 'Pengurus tidak ditemukan.');
        }

        // Proses upload foto jika ada
        $foto_path = $pengurus['foto'];
        $foto = $this->request->getFile('foto');

        if ($foto && $foto->isValid() && ! $foto->hasMoved()) {
            // Hapus file lama jika ada
            if (!empty($foto_path) && file_exists(ROOTPATH . 'public/uploads/pengurus/' . $foto_path)) {
                unlink(ROOTPATH . 'public/uploads/pengurus/' . $foto_path);
            }

            $newName = $foto->getName(); // Nama file unik
            $foto->move(ROOTPATH . 'public/uploads/pengurus', $newName);
            $foto_path = $newName;
        } elseif ($this->request->getPost('remove_file')) {
            // Hapus file jika checkbox di centang
            if (!empty($foto_path) && file_exists(ROOTPATH . 'public/uploads/pengurus/' . $foto_path)) {
                unlink(ROOTPATH . 'public/uploads/pengurus/' . $foto_path);
            }
            $foto_path = null;
        }

        // Update data di database
        $this->pengurusModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'jabatan' => $this->request->getPost('jabatan'),
            'kementerian' => $this->request->getPost('kementerian'),
            'foto' => $foto_path,
        ]);
        // Redirect dengan pesan sukses
        return redirect()->to('/admin/pengurus')->with('success', 'Pengurus berhasil diperbarui.');
    }
    public function delete($id = null)
    {
        // Cari data untuk mendapatkan nama file
        $pengurus = $this->pengurusModel->find($id);

        if ($pengurus) {
            // Hapus file dari server (jika ada)
            if (!empty($pengurus['foto']) && file_exists(ROOTPATH . 'public/uploads/pengurus/' . $pengurus['foto'])) {
                unlink(ROOTPATH . 'public/uploads/pengurus/' . $pengurus['foto']);
            }
            
            // Hapus data dari database
            $this->pengurusModel->delete($id);

            return redirect()->to(base_url('admin/pengurus'))->with('success', 'Pengurus berhasil dihapus.');
        }

        return redirect()->to(base_url('admin/pengurus'))->with('error', 'Pengurus tidak ditemukan.');
    }
}
<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Models\KatalogModel;

class Katalog extends BaseController
{
    protected $katalogModel;
    protected $helpers = ['form', 'url', 'filesystem'];

    public function __construct()
    {
        $this->katalogModel = new KatalogModel();
    }

    /**
     * Menampilkan daftar pengajuan katalog member.
     */
    public function index()
    {
        $user_id = session()->get('user_id');

        $keyword = $this->request->getGet('keyword');
        $status_pengajuan = $this->request->getGet('status_pengajuan');

        $query = $this->katalogModel->where('user_id', $user_id);

        if (!empty($keyword)) {
            $query = $query->like('nama_barang', $keyword);
        }

        if (!empty($status_pengajuan)) {
            $query = $query->where('status_pengajuan', $status_pengajuan);
        }

        $perPage = 10;
        $pengajuan_list = $query->paginate($perPage, 'pengajuan');
        $pager = $query->pager;

        $foto_base_url = base_url('uploads/katalog') . '/';

        $data = [
            'title'         => 'Pengajuan Katalog',
            'halaman'       => 'Daftar Pengajuan Katalog',
            'foto_base_url' => $foto_base_url,
            'pengajuan_list' => $pengajuan_list,
            'content'       => 'member/katalog/index',
            'pager'         => $pager,
            'filters' => [
                'keyword' => $keyword,
                'status_pengajuan' => $status_pengajuan,
            ],
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Form untuk mengajukan katalog baru.
     */
    public function create()
    {
        $data = [
            'title'   => 'Pengajuan Katalog Baru',
            'halaman' => 'Pengajuan Katalog',
            'content' => 'member/katalog/create',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Menyimpan pengajuan katalog.
     */
    public function store()
    {
        $validationRules = [
            'nama_barang'       => 'required|min_length[3]|max_length[255]',
            'deskripsi'         => 'required',
            'harga'             => 'required|numeric',
            'link_jual'         => 'required|valid_url',
            'foto_produk_file'  => 'uploaded[foto_produk_file]|max_size[foto_produk_file,2048]|is_image[foto_produk_file]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = null;
        $foto = $this->request->getFile('foto_produk_file');

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $newName = $foto->getName();
            $foto->move(FCPATH . 'uploads/katalog', $newName);
            $filePath = $newName;
        }

        $data = [
            'nama_barang'       => $this->request->getPost('nama_barang'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'harga'             => $this->request->getPost('harga'),
            'link_jual'         => $this->request->getPost('link_jual'),
            'foto_produk'       => $filePath,
            'status_pengajuan'  => 'pending',
            'user_id'           => session()->get('user_id'),
        ];

        if ($this->katalogModel->save($data)) {
            return redirect()->to(base_url('member/katalog'))->with('success', 'Pengajuan katalog berhasil dikirim.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pengajuan.');
        }
    }

    /**
     * Edit pengajuan (hanya jika pending).
     */
    public function edit($id)
    {
        $user_id = session()->get('user_id');
        $katalog = $this->katalogModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$katalog) {
            return redirect()->to(base_url('member/katalog'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $data = [
            'title'     => 'Edit Pengajuan Katalog',
            'halaman'   => 'Edit Pengajuan',
            'katalog'   => $katalog,
            'content'   => 'member/katalog/edit',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Update pengajuan.
     */
    public function update($id)
    {
        $user_id = session()->get('user_id');
        $katalog = $this->katalogModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$katalog) {
            return redirect()->to(base_url('member/katalog'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $validationRules = [
            'nama_barang'       => 'required|min_length[3]|max_length[255]',
            'deskripsi'         => 'required',
            'harga'             => 'required|numeric',
            'link_jual'         => 'required|valid_url',
            'foto_produk_file'  => 'max_size[foto_produk_file,2048]|is_image[foto_produk_file]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = $katalog['foto_produk'];
        $foto = $this->request->getFile('foto_produk_file');
        $uploadPath = FCPATH . 'uploads/katalog/';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            if ($filePath && file_exists($uploadPath . $filePath)) {
                unlink($uploadPath . $filePath);
            }
            $newName = $foto->getName();
            $foto->move($uploadPath, $newName);
            $filePath = $newName;
        }

        $data = [
            'id'                => $id,
            'nama_barang'       => $this->request->getPost('nama_barang'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'harga'             => $this->request->getPost('harga'),
            'link_jual'         => $this->request->getPost('link_jual'),
            'foto_produk'       => $filePath,
        ];

        if ($this->katalogModel->save($data)) {
            return redirect()->to(base_url('member/katalog'))->with('success', 'Pengajuan katalog berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui pengajuan.');
        }
    }

    /**
     * Delete pengajuan (hanya jika pending atau rejected).
     */
    public function delete($id)
    {
        $user_id = session()->get('user_id');
        $katalog = $this->katalogModel->find($id);

        if (!$katalog || $katalog['user_id'] != $user_id) {
            return redirect()->to(base_url('member/katalog'))->with('error', 'Pengajuan tidak ditemukan.');
        }

        if ($katalog['status_pengajuan'] === 'pending') {
            if ($katalog['foto_produk'] && file_exists(FCPATH . 'uploads/katalog/' . $katalog['foto_produk'])) {
                unlink(FCPATH . 'uploads/katalog/' . $katalog['foto_produk']);
            }

            $this->katalogModel->delete($id);
            return redirect()->to(base_url('member/katalog'))->with('success', 'Pengajuan berhasil dihapus.');
        }

        return redirect()->to(base_url('member/katalog'))->with('error', 'Pengajuan tidak dapat dihapus.');
    }
}

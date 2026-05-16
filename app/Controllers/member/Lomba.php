<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Models\LombaModel;

class Lomba extends BaseController
{
    protected $lombaModel;
    protected $helpers = ['form', 'url', 'filesystem'];

    public function __construct()
    {
        $this->lombaModel = new LombaModel();
    }

    /**
     * Menampilkan daftar pengajuan lomba member.
     */
    public function index()
    {
        $user_id = session()->get('user_id');

        $keyword = $this->request->getGet('keyword');
        $status_pengajuan = $this->request->getGet('status_pengajuan');

        $query = $this->lombaModel->where('user_id', $user_id);

        if (!empty($keyword)) {
            $query = $query->like('nama_lomba', $keyword);
        }

        if (!empty($status_pengajuan)) {
            $query = $query->where('status_pengajuan', $status_pengajuan);
        }

        $perPage = 10;
        $pengajuan_list = $query->paginate($perPage, 'pengajuan');
        $pager = $query->pager;

        $poster_base_url = base_url('uploads/lomba') . '/';

        $data = [
            'title'         => 'Pengajuan Lomba',
            'halaman'       => 'Daftar Pengajuan Lomba',
            'poster_base_url' => $poster_base_url,
            'pengajuan_list' => $pengajuan_list,
            'content'       => 'member/lomba/index',
            'pager'         => $pager,
            'filters' => [
                'keyword' => $keyword,
                'status_pengajuan' => $status_pengajuan,
            ],
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Form untuk mengajukan lomba baru.
     */
    public function create()
    {
        $data = [
            'title'   => 'Pengajuan Lomba Baru',
            'halaman' => 'Pengajuan Lomba',
            'content' => 'member/lomba/create',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Menyimpan pengajuan lomba.
     */
    public function store()
    {
        $validationRules = [
            'nama_lomba'        => 'required|max_length[255]',
            'kategori'          => 'required|max_length[255]',
            'deskripsi'         => 'required',
            'link_informasi'    => 'required|valid_url',
            'poster_file'       => 'uploaded[poster_file]|max_size[poster_file,2048]|is_image[poster_file]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = null;
        $poster = $this->request->getFile('poster_file');

        if ($poster && $poster->isValid() && !$poster->hasMoved()) {
            $newName = $poster->getName();
            $poster->move(FCPATH . 'uploads/lomba', $newName);
            $filePath = $newName;
        }

        $data = [
            'nama_lomba'        => $this->request->getPost('nama_lomba'),
            'kategori'          => $this->request->getPost('kategori'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'link_informasi'    => $this->request->getPost('link_informasi'),
            'poster'            => $filePath,
            'status_lomba'      => 'Segera', // Default
            'status_pengajuan'  => 'pending',
            'user_id'           => session()->get('user_id'),
        ];

        if ($this->lombaModel->save($data)) {
            return redirect()->to(base_url('member/lomba'))->with('success', 'Pengajuan lomba berhasil dikirim.');
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
        $lomba = $this->lombaModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$lomba) {
            return redirect()->to(base_url('member/lomba'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $data = [
            'title'     => 'Edit Pengajuan Lomba',
            'halaman'   => 'Edit Pengajuan',
            'lomba'     => $lomba,
            'content'   => 'member/lomba/edit',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Update pengajuan.
     */
    public function update($id)
    {
        $user_id = session()->get('user_id');
        $lomba = $this->lombaModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$lomba) {
            return redirect()->to(base_url('member/lomba'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $validationRules = [
            'nama_lomba'        => 'required|max_length[255]',
            'kategori'          => 'required|max_length[255]',
            'deskripsi'         => 'required',
            'link_informasi'    => 'required|valid_url',
            'poster_file'       => 'max_size[poster_file,2048]|is_image[poster_file]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = $lomba['poster'];
        $poster = $this->request->getFile('poster_file');
        $uploadPath = FCPATH . 'uploads/lomba/';

        if ($poster && $poster->isValid() && !$poster->hasMoved()) {
            if ($filePath && file_exists($uploadPath . $filePath)) {
                unlink($uploadPath . $filePath);
            }
            $newName = $poster->getName();
            $poster->move($uploadPath, $newName);
            $filePath = $newName;
        }

        $data = [
            'id'                => $id,
            'nama_lomba'        => $this->request->getPost('nama_lomba'),
            'kategori'          => $this->request->getPost('kategori'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'link_informasi'    => $this->request->getPost('link_informasi'),
            'poster'            => $filePath,
        ];

        if ($this->lombaModel->save($data)) {
            return redirect()->to(base_url('member/lomba'))->with('success', 'Pengajuan lomba berhasil diperbarui.');
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
        $lomba = $this->lombaModel->find($id);

        if (!$lomba || $lomba['user_id'] != $user_id) {
            return redirect()->to(base_url('member/lomba'))->with('error', 'Pengajuan tidak ditemukan.');
        }

        if ($lomba['status_pengajuan'] === 'pending') {
            if ($lomba['poster'] && file_exists(FCPATH . 'uploads/lomba/' . $lomba['poster'])) {
                unlink(FCPATH . 'uploads/lomba/' . $lomba['poster']);
            }

            $this->lombaModel->delete($id);
            return redirect()->to(base_url('member/lomba'))->with('success', 'Pengajuan berhasil dihapus.');
        }

        return redirect()->to(base_url('member/lomba'))->with('error', 'Pengajuan tidak dapat dihapus.');
    }
}

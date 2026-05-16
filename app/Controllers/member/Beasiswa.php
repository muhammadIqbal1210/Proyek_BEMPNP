<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Models\BeasiswaModel;

class Beasiswa extends BaseController
{
    protected $beasiswaModel;
    protected $helpers = ['form', 'url', 'filesystem'];

    public function __construct()
    {
        $this->beasiswaModel = new BeasiswaModel();
    }

    /**
     * Menampilkan daftar pengajuan beasiswa member.
     */
    public function index()
    {
        $user_id = session()->get('user_id');

        $keyword = $this->request->getGet('keyword');
        $status_pengajuan = $this->request->getGet('status_pengajuan');

        $query = $this->beasiswaModel->where('user_id', $user_id);

        if (!empty($keyword)) {
            $query = $query->like('nama_beasiswa', $keyword);
        }

        if (!empty($status_pengajuan)) {
            $query = $query->where('status_pengajuan', $status_pengajuan);
        }

        $perPage = 10;
        $pengajuan_list = $query->paginate($perPage, 'pengajuan');
        $pager = $query->pager;

        $poster_base_url = base_url('uploads/beasiswa') . '/';

        $data = [
            'title'         => 'Pengajuan Beasiswa',
            'halaman'       => 'Daftar Pengajuan Beasiswa',
            'poster_base_url' => $poster_base_url,
            'pengajuan_list' => $pengajuan_list,
            'content'       => 'member/beasiswa/index',
            'pager'         => $pager,
            'filters' => [
                'keyword' => $keyword,
                'status_pengajuan' => $status_pengajuan,
            ],
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Form untuk mengajukan beasiswa baru.
     */
    public function create()
    {
        $data = [
            'title'   => 'Pengajuan Beasiswa Baru',
            'halaman' => 'Pengajuan Beasiswa',
            'content' => 'member/beasiswa/create',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Menyimpan pengajuan beasiswa.
     */
    public function store()
    {
        $validationRules = [
            'nama_beasiswa'     => 'required|max_length[255]',
            'deskripsi'         => 'required',
            'tanggal_buka'      => 'required|valid_date',
            'tanggal_tutup'     => 'required|valid_date',
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
            $poster->move(FCPATH . 'uploads/beasiswa', $newName);
            $filePath = $newName;
        }

        $data = [
            'nama_beasiswa'     => $this->request->getPost('nama_beasiswa'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'tanggal_buka'      => $this->request->getPost('tanggal_buka'),
            'tanggal_tutup'     => $this->request->getPost('tanggal_tutup'),
            'link_informasi'    => $this->request->getPost('link_informasi'),
            'poster'            => $filePath,
            'status_beasiswa'   => 'buka', // Default
            'status_pengajuan'  => 'pending',
            'user_id'           => session()->get('user_id'),
        ];

        if ($this->beasiswaModel->save($data)) {
            return redirect()->to(base_url('member/beasiswa'))->with('success', 'Pengajuan beasiswa berhasil dikirim.');
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
        $beasiswa = $this->beasiswaModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$beasiswa) {
            return redirect()->to(base_url('member/beasiswa'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $data = [
            'title'     => 'Edit Pengajuan Beasiswa',
            'halaman'   => 'Edit Pengajuan',
            'beasiswa'  => $beasiswa,
            'content'   => 'member/beasiswa/edit',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Update pengajuan.
     */
    public function update($id)
    {
        $user_id = session()->get('user_id');
        $beasiswa = $this->beasiswaModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$beasiswa) {
            return redirect()->to(base_url('member/beasiswa'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $validationRules = [
            'nama_beasiswa'     => 'required|max_length[255]',
            'deskripsi'         => 'required',
            'tanggal_buka'      => 'required|valid_date',
            'tanggal_tutup'     => 'required|valid_date',
            'link_informasi'    => 'required|valid_url',
            'poster_file'       => 'max_size[poster_file,2048]|is_image[poster_file]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = $beasiswa['poster'];
        $poster = $this->request->getFile('poster_file');
        $remove_poster = $this->request->getPost('remove_poster');
        $uploadPath = FCPATH . 'uploads/beasiswa/';

        if ($poster && $poster->isValid() && !$poster->hasMoved()) {
            if ($filePath && file_exists($uploadPath . $filePath)) {
                unlink($uploadPath . $filePath);
            }
            $newName = $poster->getName();
            $poster->move($uploadPath, $newName);
            $filePath = $newName;
        } elseif ($remove_poster && $beasiswa['poster']) {
            if (file_exists($uploadPath . $beasiswa['poster'])) {
                unlink($uploadPath . $beasiswa['poster']);
            }
            $filePath = null;
        }

        $data = [
            'id'                => $id,
            'nama_beasiswa'     => $this->request->getPost('nama_beasiswa'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'tanggal_buka'      => $this->request->getPost('tanggal_buka'),
            'tanggal_tutup'     => $this->request->getPost('tanggal_tutup'),
            'link_informasi'    => $this->request->getPost('link_informasi'),
            'poster'            => $filePath,
        ];

        if ($this->beasiswaModel->save($data)) {
            return redirect()->to(base_url('member/beasiswa'))->with('success', 'Pengajuan beasiswa berhasil diperbarui.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui pengajuan.');
        }
    }

    /**
     * Hapus pengajuan (hanya jika pending).
     */
    public function delete($id)
    {
        $user_id = session()->get('user_id');
        $beasiswa = $this->beasiswaModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$beasiswa) {
            return redirect()->to(base_url('member/beasiswa'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat dihapus.');
        }

        $poster = $beasiswa['poster'];
        if ($poster && file_exists(FCPATH . 'uploads/beasiswa/' . $poster)) {
            unlink(FCPATH . 'uploads/beasiswa/' . $poster);
        }

        if ($this->beasiswaModel->delete($id)) {
            return redirect()->to(base_url('member/beasiswa'))->with('success', 'Pengajuan beasiswa berhasil dihapus.');
        } else {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menghapus pengajuan.');
        }
    }
}

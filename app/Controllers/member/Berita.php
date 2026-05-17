<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Models\BeritaModel;

class Berita extends BaseController
{
    protected $beritaModel;
    protected $helpers = ['form', 'url', 'filesystem', 'text'];

    public function __construct()
    {
        $this->beritaModel = new BeritaModel();
    }

    /**
     * Menampilkan daftar pengajuan berita member.
     */
    public function index()
    {
        $user_id = session()->get('user_id');

        $keyword = $this->request->getGet('keyword');
        $status_pengajuan = $this->request->getGet('status_pengajuan');

        $query = $this->beritaModel->where('user_id', $user_id);

        if (!empty($keyword)) {
            $query = $query->like('judulberita', $keyword);
        }

        if (!empty($status_pengajuan)) {
            $query = $query->where('status_pengajuan', $status_pengajuan);
        }

        $perPage = 10;
        $pengajuan_list = $query->paginate($perPage, 'pengajuan');
        $pager = $query->pager;

        $gambar_base_url = base_url('uploads/berita') . '/';

        $data = [
            'title'         => 'Pengajuan Berita',
            'halaman'       => 'Daftar Pengajuan Berita',
            'gambar_base_url' => $gambar_base_url,
            'pengajuan_list' => $pengajuan_list,
            'content'       => 'member/berita/index',
            'pager'         => $pager,
            'filters' => [
                'keyword' => $keyword,
                'status_pengajuan' => $status_pengajuan,
            ],
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Form untuk mengajukan berita baru.
     */
    public function create()
    {
        $data = [
            'title'   => 'Pengajuan Berita Baru',
            'halaman' => 'Pengajuan Berita',
            'content' => 'member/berita/create',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Menyimpan pengajuan berita.
     */
    public function store()
    {
        // Log incoming request
        log_message('info', 'Member Berita Store - POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Member Berita Store - FILES: ' . json_encode($this->request->getFiles()));

        $validationRules = [
            'judulberita'       => 'required|min_length[5]|max_length[255]',
            'isiberita'         => 'required',
            'tanggalberita'     => 'required|valid_date',
            'gambarberita_file' => 'uploaded[gambarberita_file]|max_size[gambarberita_file,2048]|is_image[gambarberita_file]',
        ];

        if (!$this->validate($validationRules)) {
            log_message('error', 'Member Berita Validation failed: ' . json_encode($this->validator->getErrors()));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = null;
        $gambar = $this->request->getFile('gambarberita_file');

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            // Ensure upload directory exists and use random file name to avoid collisions
            $uploadDir = FCPATH . 'uploads/berita/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
                log_message('info', 'Created upload directory: ' . $uploadDir);
            }
            $newName = $gambar->getRandomName();
            log_message('info', 'Uploading file: ' . $gambar->getName() . ' as ' . $newName);
            if ($gambar->move($uploadDir, $newName)) {
                $filePath = $newName;
                log_message('info', 'File uploaded successfully: ' . $filePath);
            } else {
                log_message('error', 'File upload failed for: ' . $gambar->getName());
                return redirect()->back()->withInput()->with('error', 'Gagal meng-upload gambar.');
            }
        }

        // Generate slug dari judul
        $slug = url_title($this->request->getPost('judulberita'), '-', true);

        $data = [
            'judulberita'       => $this->request->getPost('judulberita'),
            'slugberita'        => $slug,
            'isiberita'         => $this->request->getPost('isiberita'),
            'gambarberita'      => $filePath,
            'tanggalberita'     => $this->request->getPost('tanggalberita'),
            'author'            => session()->get('username') ?? session()->get('user_id'),
            'status_pengajuan'  => 'pending',
            'user_id'           => session()->get('user_id'),
        ];

        log_message('info', 'Saving berita data: ' . json_encode($data));

        if ($this->beritaModel->save($data)) {
            log_message('info', 'Berita saved successfully');
            return redirect()->to(base_url('member/berita'))->with('success', 'Pengajuan berita berhasil dikirim.');
        } else {
            log_message('error', 'Failed to save berita: ' . json_encode($this->beritaModel->errors()));
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengirim pengajuan.');
        }
    }

    /**
     * Edit pengajuan (hanya jika pending).
     */
    public function edit($id)
    {
        $user_id = session()->get('user_id');
        $berita = $this->beritaModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$berita) {
            return redirect()->to(base_url('member/berita'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $data = [
            'title'     => 'Edit Pengajuan Berita',
            'halaman'   => 'Edit Pengajuan',
            'berita'    => $berita,
            'content'   => 'member/berita/edit',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Update pengajuan.
     */
    public function update($id)
    {
        $user_id = session()->get('user_id');
        $berita = $this->beritaModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$berita) {
            return redirect()->to(base_url('member/berita'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $validationRules = [
            'judulberita'       => 'required|min_length[5]|max_length[255]',
            'isiberita'         => 'required',
            'tanggalberita'     => 'required|valid_date',
            'gambarberita_file' => 'max_size[gambarberita_file,2048]|is_image[gambarberita_file]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = $berita['gambarberita'];
        $gambar = $this->request->getFile('gambarberita_file');
        $uploadPath = FCPATH . 'uploads/berita/';

        if ($gambar && $gambar->isValid() && !$gambar->hasMoved()) {
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            if ($filePath && file_exists($uploadPath . $filePath)) {
                unlink($uploadPath . $filePath);
            }
            $newName = $gambar->getRandomName();
            if ($gambar->move($uploadPath, $newName)) {
                $filePath = $newName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal meng-upload gambar.');
            }
        }

        // Generate slug dari judul
        $slug = url_title($this->request->getPost('judulberita'), '-', true);

        $data = [
            'id'                => $id,
            'judulberita'       => $this->request->getPost('judulberita'),
            'slugberita'        => $slug,
            'isiberita'         => $this->request->getPost('isiberita'),
            'gambarberita'      => $filePath,
            'tanggalberita'     => $this->request->getPost('tanggalberita'),
        ];

        if ($this->beritaModel->save($data)) {
            return redirect()->to(base_url('member/berita'))->with('success', 'Pengajuan berita berhasil diperbarui.');
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
        $berita = $this->beritaModel->find($id);

        if (!$berita || $berita['user_id'] != $user_id) {
            return redirect()->to(base_url('member/berita'))->with('error', 'Pengajuan tidak ditemukan.');
        }

        if ($berita['status_pengajuan'] === 'pending') {
            if ($berita['gambarberita'] && file_exists(FCPATH . 'uploads/berita/' . $berita['gambarberita'])) {
                unlink(FCPATH . 'uploads/berita/' . $berita['gambarberita']);
            }

            $this->beritaModel->delete($id);
            return redirect()->to(base_url('member/berita'))->with('success', 'Pengajuan berhasil dihapus.');
        }

        return redirect()->to(base_url('member/berita'))->with('error', 'Pengajuan tidak dapat dihapus.');
    }
}

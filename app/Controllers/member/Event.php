<?php

namespace App\Controllers\Member;

use App\Controllers\BaseController;
use App\Models\EventModel;

class Event extends BaseController
{
    protected $eventModel;
    protected $helpers = ['form', 'url', 'filesystem'];

    public function __construct()
    {
        $this->eventModel = new EventModel();
    }

    /**
     * Menampilkan daftar pengajuan event member.
     */
    public function index()
    {
        $user_id = session()->get('user_id');

        $keyword = $this->request->getGet('keyword');
        $status_pengajuan = $this->request->getGet('status_pengajuan');

        $query = $this->eventModel->where('user_id', $user_id);

        if (!empty($keyword)) {
            $query = $query->like('nama_event', $keyword);
        }

        if (!empty($status_pengajuan)) {
            $query = $query->where('status_pengajuan', $status_pengajuan);
        }

        $perPage = 10;
        $pengajuan_list = $query->paginate($perPage, 'pengajuan');
        $pager = $query->pager;

        $file_base_url = base_url('uploads/event') . '/';

        $data = [
            'title'         => 'Pengajuan Event',
            'halaman'       => 'Daftar Pengajuan Event',
            'file_base_url' => $file_base_url,
            'pengajuan_list' => $pengajuan_list,
            'content'       => 'member/event/index',
            'pager'         => $pager,
            'filters' => [
                'keyword' => $keyword,
                'status_pengajuan' => $status_pengajuan,
            ],
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Form untuk mengajukan event baru.
     */
    public function create()
    {
        $data = [
            'title'   => 'Pengajuan Event Baru',
            'halaman' => 'Pengajuan Event',
            'content' => 'member/event/create',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Menyimpan pengajuan event.
     */
    public function store()
    {
        $validationRules = [
            'nama_event'        => 'required|max_length[255]',
            'deskripsi'         => 'required',
            'link_informasi'    => 'required|valid_url',
            'waktu'             => 'required|valid_date',
            'file_upload'       => 'max_size[file_upload,5120]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = null;
        $file = $this->request->getFile('file_upload');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getName();
            $file->move(FCPATH . 'uploads/event', $newName);
            $filePath = $newName;
        }

        $data = [
            'nama_event'        => $this->request->getPost('nama_event'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'link_informasi'    => $this->request->getPost('link_informasi'),
            'waktu'             => $this->request->getPost('waktu'),
            'biaya'             => $this->request->getPost('biaya') ?? 'gratis',
            'file'              => $filePath,
            'status_pengajuan'  => 'pending',
            'user_id'           => session()->get('user_id'),
        ];

        if ($this->eventModel->save($data)) {
            return redirect()->to(base_url('member/event'))->with('success', 'Pengajuan event berhasil dikirim.');
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
        $event = $this->eventModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$event) {
            return redirect()->to(base_url('member/event'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $data = [
            'title'     => 'Edit Pengajuan Event',
            'halaman'   => 'Edit Pengajuan',
            'event'     => $event,
            'content'   => 'member/event/edit',
        ];

        return view('template/wrapper', $data);
    }

    /**
     * Update pengajuan.
     */
    public function update($id)
    {
        $user_id = session()->get('user_id');
        $event = $this->eventModel->where('id', $id)->where('user_id', $user_id)->where('status_pengajuan', 'pending')->first();

        if (!$event) {
            return redirect()->to(base_url('member/event'))->with('error', 'Pengajuan tidak ditemukan atau tidak dapat diedit.');
        }

        $validationRules = [
            'nama_event'        => 'required|max_length[255]',
            'deskripsi'         => 'required',
            'link_informasi'    => 'required|valid_url',
            'waktu'             => 'required|valid_date',
            'file_upload'       => 'max_size[file_upload,5120]',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $filePath = $event['file'];
        $file = $this->request->getFile('file_upload');
        $uploadPath = FCPATH . 'uploads/event/';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            if ($filePath && file_exists($uploadPath . $filePath)) {
                unlink($uploadPath . $filePath);
            }
            $newName = $file->getName();
            $file->move($uploadPath, $newName);
            $filePath = $newName;
        }

        $data = [
            'id'                => $id,
            'nama_event'        => $this->request->getPost('nama_event'),
            'deskripsi'         => $this->request->getPost('deskripsi'),
            'link_informasi'    => $this->request->getPost('link_informasi'),
            'waktu'             => $this->request->getPost('waktu'),
            'biaya'             => $this->request->getPost('biaya') ?? 'gratis',
            'file'              => $filePath,
        ];

        if ($this->eventModel->save($data)) {
            return redirect()->to(base_url('member/event'))->with('success', 'Pengajuan event berhasil diperbarui.');
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
        $event = $this->eventModel->find($id);

        if (!$event || $event['user_id'] != $user_id) {
            return redirect()->to(base_url('member/event'))->with('error', 'Pengajuan tidak ditemukan.');
        }

        if ($event['status_pengajuan'] === 'pending') {
            if ($event['file'] && file_exists(FCPATH . 'uploads/event/' . $event['file'])) {
                unlink(FCPATH . 'uploads/event/' . $event['file']);
            }

            $this->eventModel->delete($id);
            return redirect()->to(base_url('member/event'))->with('success', 'Pengajuan berhasil dihapus.');
        }

        return redirect()->to(base_url('member/event'))->with('error', 'Pengajuan tidak dapat dihapus.');
    }
}

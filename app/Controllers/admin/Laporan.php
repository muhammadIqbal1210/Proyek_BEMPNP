<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class Laporan extends BaseController
    {
    protected $laporanModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        // Mengambil filter dari GET request
        $keyword = $this->request->getGet('keyword');
        $status = $this->request->getGet('status');
        $filters = ['keyword' => $keyword, 'status' => $status];
        
        $query = $this->laporanModel;

        if (!empty($keyword)) {
            $query = $query->groupStart()
                           ->like('nama', $keyword)
                           ->orLike('nim', $keyword)
                           ->orLike('isi', $keyword)
                           ->groupEnd();
        }

        if (!empty($status)) {
            $query = $query->where('status', $status);
        }

        $perPage = 10;
        $laporan_list = $query->orderBy('created_at', 'DESC')->paginate($perPage, 'laporan');
        $pager = $query->pager;

        $data = [
            'title'        => 'Manajemen Advokasi',
            'laporan_list' => $laporan_list,
            'filters'      => $filters,
            'pager'        => $pager,
            'content'      => 'admin/laporan/index',
            'lampiran_url' => base_url('uploads/laporan/') 
        ];

        return view('template/wrapper', $data);
    }

    public function update_status($id)
    {
        $status = $this->request->getPost('status');

        if (empty($status)) {
            return redirect()->back()->with('error', 'Status tidak boleh kosong.');
        }

        $this->laporanModel->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status pengaduan berhasil diubah menjadi ' . $status);
    }

    public function delete($id)
    {
        // Logika hapus
        $this->laporanModel->delete($id);

        return redirect()->back()->with('success', 'Data pengaduan berhasil dihapus.');
    }
}
<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KontakModel;

class Kontak extends BaseController
{
    protected $kontakModel;
    protected $helpers = ['form', 'url'];

    public function __construct()
    {
        $this->kontakModel = new KontakModel();
    }

    public function index()
    {
        $data = [
            'title'       => 'Kelola Kontak',
            'kontak_list' => $this->kontakModel->findAll(),
            'content'     => 'admin/kontak/index',
        ];
        return view('template/wrapper', $data);
    }

    public function store()
    {
        $rules = [
            'nama' => 'required|min_length[3]',
            'deskripsi' => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->kontakModel->save([
            'nama'           => $this->request->getPost('nama'),
            'kategori'       => $this->request->getPost('kategori'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'whatsApp'       => $this->request->getPost('whatsApp'),
            'subjek_wa'      => $this->request->getPost('subjek_wa'),
            'instagram'      => $this->request->getPost('instagram'),
            'subjek_ig'      => $this->request->getPost('subjek_ig'),
            'email'          => $this->request->getPost('email'),
            'subjek_email'   => $this->request->getPost('subjek_email'),
            'website'        => $this->request->getPost('website'),
            'subjek_website' => $this->request->getPost('subjek_website'),
        ]);

        return redirect()->to('admin/kontak')->with('success', 'Data kontak berhasil ditambahkan');
    }

    public function update($id)
    {
        $this->kontakModel->update($id, [
            'nama'           => $this->request->getPost('nama'),
            'kategori'       => $this->request->getPost('kategori'),
            'deskripsi'      => $this->request->getPost('deskripsi'),
            'whatsApp'       => $this->request->getPost('whatsApp'),
            'subjek_wa'      => $this->request->getPost('subjek_wa'),
            'instagram'      => $this->request->getPost('instagram'),
            'subjek_ig'      => $this->request->getPost('subjek_ig'),
            'email'          => $this->request->getPost('email'),
            'subjek_email'   => $this->request->getPost('subjek_email'),
            'website'        => $this->request->getPost('website'),
            'subjek_website' => $this->request->getPost('subjek_website'),
        ]);

        return redirect()->to('admin/kontak')->with('success', 'Data kontak berhasil diperbarui');
    }

    public function delete($id)
    {
        $this->kontakModel->delete($id);
        return redirect()->to('admin/kontak')->with('success', 'Data kontak berhasil dihapus');
    }
}
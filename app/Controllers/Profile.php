<?php namespace App\Controllers;

use App\Models\ProfileModel;
use CodeIgniter\Controller;
use App\Controllers\BaseController;

class Profile extends BaseController
{
    protected $profileModel;

    public function __construct()
    {
        $this->profileModel = new ProfileModel();
    }
    // Tampilkan form edit profil
    public function edit()
    {
        $userId = session()->get('user_id');
        $profile = $this->profileModel->where('user_id', $userId)->first();

        // FIX: Jika data profil belum ada di DB, buat objek array kosong agar form tidak error
        if (!$profile) {
            $profile = [
                'nama_lengkap' => '',
                'kementerian'  => '',
                'jabatan'      => '',
                'alamat'       => '',
                'no_telepon'   => ''
            ];
        }
        $role = session()->get('role');
        $data['content']    = 'profile/edit';
        $data['title']      = 'Edit Profil'; 
        $data['halaman']    = 'Edit Profil';
        $data['profile'] = $profile;
        $data['role'] = $role;
        $data['validation'] = \Config\Services::validation();

        return view('template/wrapper', $data);
    }

    // Proses update profil
    public function update()
    {
        $userId = session()->get('user_id');
        $profile = $this->profileModel->where('user_id', $userId)->first();

        helper(['form']);

        $rules = [
            'nama_lengkap' => 'required|min_length[3]|max_length[255]',
            'kementerian'  => 'required|min_length[2]|max_length[100]',
            'jabatan'      => 'required|min_length[2]|max_length[100]',
            'alamat'       => 'permit_empty|max_length[500]',
            'no_telepon'   => 'permit_empty|numeric|min_length[6]|max_length[30]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // FIX: Siapkan data. Jika profil lama ada, sertakan ID-nya untuk UPDATE. 
        // Jika belum ada, CodeIgniter otomatis akan melakukan INSERT data baru.
        $updateData = [
            'user_id'      => $userId,
            'nama_lengkap' => $this->request->getVar('nama_lengkap'),
            'kementerian'  => $this->request->getVar('kementerian'),
            'jabatan'      => $this->request->getVar('jabatan'),
            'alamat'       => $this->request->getVar('alamat'),
            'no_telepon'   => $this->request->getVar('no_telepon'),
        ];

        if ($profile) {
            $updateData['id'] = $profile['id'];
        }

        if ($this->profileModel->save($updateData)) {
            // Ambil data terbaru setelah disimpan
            $updatedProfile = $this->profileModel->where('user_id', $userId)->first();
            
            // Update session dengan data profile baru
            session()->set([
                'nama_lengkap' => $updatedProfile['nama_lengkap'],
                'kementerian'  => $updatedProfile['kementerian'],
                'jabatan'      => $updatedProfile['jabatan'],
                'alamat'       => $updatedProfile['alamat'],
                'no_telepon'   => $updatedProfile['no_telepon'],
            ]);

            // Redirect berdasarkan role
            $role = session()->get('role');
            $redirectUrl = ($role === 'admin' || $role === 'superadmin') ? '/admin/dashboard' : '/member/dashboard';
            return redirect()->to($redirectUrl)->with('success', 'Profil berhasil diperbarui!');
        } else {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui profil.');
        }
    }
}

<?php

namespace App\Models;

use CodeIgniter\Model;

class BeasiswaModel extends Model
{
    // Nama tabel di database
    protected $table      = 'beasiswas';
    
    // Kunci utama tabel
    protected $primaryKey = 'id';

    // Model akan secara otomatis menangani timestamps (created_at dan updated_at)
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Bidang yang diizinkan untuk diisi (fillable fields)
    protected $allowedFields = [
        'nama_beasiswa', 
        'deskripsi', 
        'tanggal_buka',
        'tanggal_tutup', 
        'status_beasiswa', 
        'link_informasi', 
        'poster'
    ];
    protected $validationRules = [
        'nama_beasiswa'     => 'required|max_length[255]',
        'deskripsi'         => 'required',
    ];


    protected $validationMessages = [
        'nama_beasiswa' => [
            'required' => 'Nama beasiswa harus diisi.',
            'max_length' => 'Nama beasiswa terlalu panjang.'
        ],
        'deskripsi' => [
            'required' => 'Deskripsi beasiswa harus diisi.'
        ],
        'link_informasi' => [
            'required' => 'Link Informasi harus diisi.'
        ],
    ];
}
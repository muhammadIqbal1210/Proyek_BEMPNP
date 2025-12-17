<?php

namespace App\Models;

use CodeIgniter\Model;

class LombaModel extends Model
{
    // Nama tabel di database
    protected $table      = 'lombas';
    
    // Kunci utama tabel
    protected $primaryKey = 'id';

    // Model akan secara otomatis menangani timestamps (created_at dan updated_at)
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Bidang yang diizinkan untuk diisi (fillable fields)
    protected $allowedFields = [
        'nama_lomba', 
        'kategori',
        'deskripsi',  
        'status_lomba', 
        'link_informasi', 
        'poster'
    ];
    // --- Aturan Validasi ---
    protected $validationRules = [
        'nama_lomba'     => 'required|max_length[255]',
        'deskripsi'      => 'required',
        'link_informasi' => 'required',
    ];


    protected $validationMessages = [
        'nama_lomba' => [
            'required' => 'Nama lomba harus diisi.',
            'max_length' => 'Nama beasiswa terlalu panjang.'
        ],
        'deskripsi' => [
            'required' => 'Deskripsi lomba harus diisi.'
        ],
        'link_informasi' => [
            'required' => 'Link Informasi harus diisi.'
        ],
    ];
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table            = 'events';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama_event',
        'deskripsi',
        'link_informasi',
        'waktu',
        'file'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'nama_event'    => 'required|max_length[255]',
        'deskripsi'     => 'required',
        'link_informasi'=> 'required|valid_url',
    ];
    protected $validationMessages   = [
        'nama_event' => [
            'required'    => 'Nama Event harus diisi.',
            'max_length'  => 'Nama Event tidak boleh melebihi 255 karakter.'
        ],
        'deskripsi' => [
            'required'    => 'Deskripsi Event wajib diisi.'
        ],
        'link_informasi' => [
            'required'    => 'Link Informasi wajib diisi.',
            'valid_url'   => 'Format Link Informasi tidak valid. Mohon masukkan URL yang benar.'
        ],
        'file_save' => [
            'uploaded'    => 'File  wajib diunggah.',
            'is_image'    => 'File yang diunggah harus berupa gambar (jpg, jpeg, png, atau gif).',
            'max_size'    => 'Ukuran file  terlalu besar. Maksimal 2MB.'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}

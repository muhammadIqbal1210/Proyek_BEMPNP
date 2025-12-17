<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'beritas';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'judul',
        'slug',
        'penulis',
        'isi',
        'gambar',
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
    protected $validationRules      = [
        'judul'   => 'required|min_length[5]|max_length[255]',
        'isi'     => 'required|min_length[50]',
        'gambar'    => 'required',
    ];
    protected $validationMessages   = [
        'judul' => [
            'required' => 'Judul berita wajib diisi.',
            'min_length' => 'Judul minimal 5 karakter.',
        ],
        'isi' => [
            'required' => 'Isi berita wajib diisi.',
            'min_length' => 'Isi berita minimal 50 karakter.',
        ], 
        'gambar_save' => [
            'uploaded'    => 'File  wajib diunggah.',
            'is_image'    => 'File yang diunggah harus berupa gambar (jpg, jpeg, png, atau gif).',
            'max_size'    => 'Ukuran file  terlalu besar. Maksimal 5MB.'
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

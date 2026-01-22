<?php

namespace App\Models;

use CodeIgniter\Model;

class PengurusModel extends Model
{
    protected $table            = 'pengurus';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'nama',  
        'jabatan', 
        'kementerian',
        'foto',
        'created_at',
        'updated_at'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'nama' => 'required|string|max_length[255]',
        'jabatan' => 'required|string',
        'kementerian' => 'required|in_list[kepresidenan,audit_internal,kesekretariatan,keuangan,psdm,adkesma,sosmas,dagri,mitbis,lugri,kastrat,komris,pp]',
        'foto' => 'permit_empty|string|max_length[255]',
    ];
    protected $validationMessages   = [
        'nama' => [
            'required' => 'Nama pengurus wajib diisi.',
            'string'   => 'Nama pengurus harus berupa teks.',
            'max_length' => 'Nama pengurus tidak boleh lebih dari 255 karakter.',
        ],
        'jabatan' => [
            'required' => 'Jabatan pengurus wajib diisi.',
            'string'   => 'Jabatan pengurus harus berupa teks.',
        ],
        'kementerian' => [
            'required' => 'Kementerian wajib dipilih.',
            'in_list'  => 'Kementerian yang dipilih tidak valid.',
        ],
        'foto' => [
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

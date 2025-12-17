<?php namespace App\Models;

use CodeIgniter\Model;

class PengumumanModel extends Model
{
    protected $table            = 'pengumuman';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    
    // Field yang diizinkan untuk diisi (Whitelist)
    protected $allowedFields = [
        'title',  
        'tanggal_publikasi', 
        'file_path', 
        'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';
    
    // Validation (Opsional, tapi direkomendasikan)
    protected $validationRules = [
        'title'             => 'required|min_length[5]|max_length[255]',
        'tanggal_publikasi' => 'required|valid_date',
        'status'            => 'required|in_list[aktif,non-aktif,draf]',
    ];
    
    protected $skipValidation = false;
}
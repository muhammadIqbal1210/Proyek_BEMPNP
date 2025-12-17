<?php namespace App\Models;

use CodeIgniter\Model;

class KatalogModel extends Model
{
    protected $table = 'katalog';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false; 

    protected $allowedFields = [
        'nama_barang', 
        'deskripsi', 
        'harga',  
        'user_id',
        'foto_produk',
        'link_jual', 
    ];

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at'; 

    protected $validationRules = [
        'nama_barang' => 'required|min_length[3]|max_length[255]',
        'deskripsi'    => 'required',
        'harga'        => 'required|numeric',
       
    ];
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class KontakModel extends Model
{
    protected $table            = 'kontak';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama', 'deskripsi', 
        'whatsApp', 'subjek_wa', 
        'instagram', 'subjek_ig', 
        'email', 'subjek_email', 
        'website', 'subjek_website', 
        'created_at','updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at'; 
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false; // Set true jika ingin menggunakan fitur hapus sementara
    
    // Field yang diizinkan untuk diisi (Mass Assignment)
    protected $allowedFields    = [
        'judulberita', 
        'slugberita', 
        'isiberita', 
        'gambarberita', 
        'tanggalberita', 
        'author'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'judulberita'   => 'required|min_length[5]|max_length[255]',
        'isiberita'     => 'required',
        'author'        => 'required',
    ];

    protected $validationMessages   = [
        'judulberita' => [
            'required' => 'Judul berita harus diisi.',
            'min_length' => 'Judul berita minimal 5 karakter.'
        ],
        'isiberita' => [
            'required' => 'Isi berita tidak boleh kosong.'
        ]
    ];

    /**
     * Fungsi untuk mencari berita berdasarkan keyword (untuk fitur pencarian di View)
     */
    public function search($keyword)
    {
        return $this->table($this->table)
                    ->like('judulberita', $keyword)
                    ->orLike('isiberita', $keyword)
                    ->orLike('author', $keyword);
    }
}
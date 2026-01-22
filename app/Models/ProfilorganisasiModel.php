<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfilorganisasiModel extends Model
{
    protected $table            = 'profilorganisasi';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nama_kabinet',
        'periode',
        'videoprofil',
        'visi',
        'misi',
        's_pres',
        's_wapres'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules      = [
        'nama_kabinet' => 'required|string|max_length[255]',
        'periode'      => 'required|string|max_length[126]',
        'videoprofil'  => 'permit_empty|valid_url',
        'visi'         => 'required|string',
        'misi'         => 'required|string',
        's_pres'       => 'permit_empty|string',
        's_wapres'     => 'permit_empty|string',
    ];
    protected $validationMessages   = [
        'nama_kabinet' => [
            'required' => 'Nama kabinet wajib diisi.',
            'string'   => 'Nama kabinet harus berupa teks.',
            'max_length' => 'Nama kabinet tidak boleh lebih dari 255 karakter.',
        ],
        'periode' => [
            'required' => 'Periode wajib diisi.',
            'string'   => 'Periode harus berupa teks.',
            'max_length' => 'Periode tidak boleh lebih dari 126 karakter.',
        ],
        'videoprofil' => [
            'valid_url' => 'Link video profil harus berupa URL yang valid.',
        ],
        'visi' => [
            'required' => 'Visi wajib diisi.',
            'string'   => 'Visi harus berupa teks.',
        ],
        'misi' => [
            'required' => 'Misi wajib diisi.',
            'string'   => 'Misi harus berupa teks.',
        ],
        's_pres' => [
            'string'   => 'Sambutan presiden harus berupa teks.',
        ],
        's_wapres' => [
            'string'   => 'Sambutan wapres harus berupa teks.',
        ],
    ];
    protected function encodeMisi(array $data)
    {
        if (isset($data['data']['misi'])) {
            // Pastikan kita hanya meng-encode jika bentuknya masih array
            if (is_array($data['data']['misi'])) {
                $data['data']['misi'] = json_encode($data['data']['misi']);
            }
        }
        return $data;
    }

    /**
     * Helper untuk mengambil data dengan misi yang sudah di-decode
     */
    public function getProfil($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }

        $data = $this->find($id);
        if ($data && isset($data['misi'])) {
            // Ubah JSON string kembali ke array untuk dipakai di form edit/view
            $data['misi'] = json_decode($data['misi'], true) ?? [];
        }
        return $data;
    }
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
}
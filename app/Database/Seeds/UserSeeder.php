<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Ambil password dari .env atau gunakan password default untuk development
        $superadminPass = env('INITIAL_SUPERADMIN_PASS', 'superadmin123');
        $adminPass      = env('INITIAL_ADMIN_PASS', 'admin123');
        $memberPass     = env('INITIAL_MEMBER_PASS', 'member123');

        // Ambil Email dari .env (Cadangan jika kosong: text di sebelah kanan)
        $superadminEmail = env('INITIAL_SUPERADMIN_EMAIL', 'superadmin@bem.ac.id');
        $adminEmail      = env('INITIAL_ADMIN_EMAIL', 'admin@bem.ac.id');
        $memberEmail     = env('INITIAL_MEMBER_EMAIL', 'member@bem.ac.id');

        // 2. Validasi keamanan ketat khusus di server Production/Hosting
        if (env('CI_ENVIRONMENT') === 'production') {
            if ($superadminPass === 'superadmin123' || $adminPass === 'admin123') {
                // Hentikan proses jika di server asli tapi masih pakai password bawaan 
                die("🚨 ERROR: Di server production, Anda WAJIB mengubah password default di file .env terlebih dahulu demi keamanan!");
            }
        }

        // 3. Susun data user dengan password yang sudah aman
        $users = [
            [
                'username'   => 'superadmin',
                'email'      => $superadminEmail,
                'password'   => password_hash($superadminPass, PASSWORD_DEFAULT),
                'role'       => 'superadmin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'admin',
                'email'      => $adminEmail,
                'password'   => password_hash($adminPass, PASSWORD_DEFAULT),
                'role'       => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'username'   => 'member1',
                'email'      => $memberEmail,
                'password'   => password_hash($memberPass, PASSWORD_DEFAULT),
                'role'       => 'member',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // 4. Masukkan data ke tabel users
        $this->db->table('users')->insertBatch($users);
    }
}

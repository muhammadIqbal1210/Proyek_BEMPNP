<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
    
class User extends Migration
{
    public function up() {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'unique'     => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'role' => [
                'type'       => 'ENUM',
                'constraint' => ['guest', 'member', 'admin'],
                'default'    => 'member',
            ],
            'created_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            'updated_at' => [
                'type'       => 'DATETIME',
                'null'       => true,
            ],
            // ----------------------------------
            // Tambahkan kolom ini jika Anda menggunakannya:
            // 'deleted_at' => [ 
            //     'type' => 'DATETIME', 
            //     'null' => true 
            // ],
        ]);
        $this->forge->addKey('id', true);
        
        // PENTING: Gunakan nama jamak (users) sebagai konvensi di CI4 dan Laravel
        $this->forge->createTable('users',true);
    }

    public function down() {
        // Ganti nama tabel ke 'users' jika Anda menggunakan konvensi jamak
        $this->forge->dropTable('users');
    }
}
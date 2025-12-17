<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Lomba extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_lomba' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kategori' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
            ],
            'status_lomba' => [
                'type' => 'ENUM',
                'constraint' => ['Buka','Tutup','Segera'], // Disesuaikan dengan pilihan di Modal
                'default' => 'Segera',
            ],
            'link_informasi' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'poster' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('lombas');
    }

    public function down()
    {
        $this->forge->dropTable('lombas');
    }
}
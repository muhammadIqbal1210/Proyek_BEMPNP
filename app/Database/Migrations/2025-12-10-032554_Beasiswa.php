<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Beasiswa extends Migration
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
            'nama_beasiswa' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'comment'    => 'Nama program beasiswa',
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'comment'    => 'Deskripsi Lengkap',
            ],
            'tanggal_buka' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'tanggal_tutup' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'status_beasiswa' => [
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
                'comment'    => 'Nama file poster Beasiswa',
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
        $this->forge->createTable('beasiswas');
    }

    public function down()
    {
        $this->forge->dropTable('beasiswas');
    }
}
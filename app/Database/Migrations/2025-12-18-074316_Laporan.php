<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Laporan extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'nim' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'kategori' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'kontak' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
            ],
            'isi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'lampiran' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['Masuk', 'Proses', 'Selesai'],
                'default'    => 'Masuk',
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
        $this->forge->createTable('laporans');
    }

    public function down()
    {
        $this->forge->dropTable('laporans');
    }
}
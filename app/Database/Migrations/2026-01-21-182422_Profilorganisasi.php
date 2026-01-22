<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Profilorganisasi extends Migration
{
    public function up(){
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_kabinet' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'periode' => [
                'type' => 'VARCHAR',
                'constraint' => 126,
            ],
            'videoprofil' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'visi' => [
                'type' => 'TEXT',
            ],
            'misi' => [
                'type' => 'TEXT',
            ],
            's_pres' => [
                'type' => 'TeXT',
            ],
            's_wapres' => [
                'type' => 'TeXT',
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
        $this->forge->createTable('profilorganisasi');
    }

    public function down()
    {
        $this->forge->dropTable('profilorganisasi');
    }
}

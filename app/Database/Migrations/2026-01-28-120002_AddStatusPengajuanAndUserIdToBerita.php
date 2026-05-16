<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusPengajuanAndUserIdToBerita extends Migration
{
    public function up()
    {
        $this->forge->addColumn('berita', [
            'status_pengajuan' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
                'after' => 'author',
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'after' => 'status_pengajuan',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('berita', ['status_pengajuan', 'user_id']);
    }
}

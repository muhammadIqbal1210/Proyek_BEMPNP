<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusPengajuanAndUserIdToLombas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('lombas', [
            'status_pengajuan' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
                'after' => 'poster',
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
        $this->forge->dropColumn('lombas', ['status_pengajuan', 'user_id']);
    }
}

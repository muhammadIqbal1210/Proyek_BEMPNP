<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusPengajuanAndUserIdToBeasiswas extends Migration
{
    public function up()
    {
        $this->forge->addColumn('beasiswas', [
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
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('beasiswas', ['status_pengajuan', 'user_id']);
    }
}

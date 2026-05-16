<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusPengajuanAndUserIdToEvents extends Migration
{
    public function up()
    {
        $this->forge->addColumn('events', [
            'status_pengajuan' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
                'after' => 'file',
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
        $this->forge->dropColumn('events', ['status_pengajuan', 'user_id']);
    }
}

<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatusPengajuanAndUserIdToKatalog extends Migration
{
    public function up()
    {
        $this->forge->addColumn('katalog', [
            'status_pengajuan' => [
                'type' => 'ENUM',
                'constraint' => ['pending', 'approved', 'rejected'],
                'default' => 'pending',
                'after' => 'foto_produk',
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
        $this->forge->dropColumn('katalog', ['status_pengajuan', 'user_id']);
    }
}

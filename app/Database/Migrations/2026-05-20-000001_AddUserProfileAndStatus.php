<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserProfileAndStatus extends Migration
{
    public function up()
    {
        $fields = [
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['is_active']);
    }
}

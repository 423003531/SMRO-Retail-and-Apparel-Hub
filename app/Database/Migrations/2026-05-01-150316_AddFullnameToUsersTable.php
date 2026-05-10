<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddFullnameToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'fullname' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
                'null'       => true,
                'after'      => 'username', // Places it neatly after the username column
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'fullname');
    }
}
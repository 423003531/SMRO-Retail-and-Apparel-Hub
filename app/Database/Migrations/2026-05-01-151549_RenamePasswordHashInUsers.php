<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenamePasswordHashInUsers extends Migration
{
    public function up()
    {
        $fields = [
            'password_hash' => [
                'name'       => 'password',
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ];
        $this->forge->modifyColumn('users', $fields);
    }

    public function down()
    {
        $fields = [
            'password' => [
                'name'       => 'password_hash',
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
        ];
        $this->forge->modifyColumn('users', $fields);
    }
}
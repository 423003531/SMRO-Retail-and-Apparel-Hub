<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserSubmenuTable extends Migration
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
            'menu_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'url' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'icon' => [
                'type'       => 'VARCHAR',
                'constraint' => '128',
            ],
            'is_active' => [
                'type'       => 'INT',
                'constraint' => 1,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->createTable('user_submenu');
    }

    public function down()
    {
        $this->forge->dropTable('user_submenu');
    }
}
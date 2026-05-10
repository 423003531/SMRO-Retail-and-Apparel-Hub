<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMenuCategoryIdToUserAccess extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user_access', [
            'menu_category_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'after'      => 'role_id',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('user_access', 'menu_category_id');
    }
}
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateStockLogsTable extends Migration
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
            'product_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'variant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'movement_type' => [
                'type'       => 'ENUM',
                'constraint' => ['in', 'out'],
                'default'    => 'in',
            ],
            'quantity' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'remarks' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        
        // Indexing these speeds up database queries later
        $this->forge->addKey('product_id');
        $this->forge->addKey('variant_id');

        $this->forge->createTable('stock_logs');
    }

    public function down()
    {
        $this->forge->dropTable('stock_logs');
    }
}
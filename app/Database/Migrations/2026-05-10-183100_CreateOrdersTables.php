<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOrdersTables extends Migration
{
    public function up()
    {
        // --- 1. Main Orders Table (The Receipt) ---
        $this->forge->addField([
            'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'order_number' => ['type' => 'VARCHAR', 'constraint' => '50', 'unique' => true],
            'total_amount' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('orders');

        // --- 2. Order Items Table (The Line Items) ---
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'order_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'product_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'variant_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'quantity'   => ['type' => 'INT', 'constraint' => 11],
            'price'      => ['type' => 'DECIMAL', 'constraint' => '10,2'], // Snapshot of price at time of sale
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        
        // Link these items directly to the orders, products, and variants!
        $this->forge->addForeignKey('order_id', 'orders', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('product_id', 'products', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('variant_id', 'product_variants', 'id', 'CASCADE', 'CASCADE');
        
        $this->forge->createTable('order_items');
    }

    public function down()
    {
        $this->forge->dropTable('order_items');
        $this->forge->dropTable('orders');
    }
}
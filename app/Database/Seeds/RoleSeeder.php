<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['role' => 'Superadmin'],
            ['role' => 'Manager'],
            ['role' => 'Staff'],
            ['role' => 'User']
        ];

        // Using insertBatch to insert multiple rows at once safely
        $this->db->table('user_role')->insertBatch($data);
    }
}
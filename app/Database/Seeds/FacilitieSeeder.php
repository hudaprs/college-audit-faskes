<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FacilitieSeeder extends Seeder
{
    public function run()
    {
        $facilitie = [
            [
                'id' => 1,
                'name' => 'John Wall',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'Christ Paul',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'name' => 'Antony Davis',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert To Database
        $this->db->table('facilitie')->insertBatch($facilitie);
    }
}
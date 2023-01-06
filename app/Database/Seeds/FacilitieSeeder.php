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
                'name' => 'Rawat Jalan',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'Unit Gawat Darurat',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'name' => 'Rawat Inap',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updateded_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 4,
                'name' => 'ICU',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updateded_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 5,
                'name' => 'Kamar Operasi',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updateded_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 6,
                'name' => 'Medical Check Up',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updateded_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 7,
                'name' => 'Farmasi',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updateded_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 8,
                'name' => 'Ambulance',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert To Database
        $this->db->table('facilitie')->insertBatch($facilitie);
    }
}
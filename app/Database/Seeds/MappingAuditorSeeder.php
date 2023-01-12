<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MappingAuditorSeeder extends Seeder
{
    public function run()
    {
        $mappingAuditors = [
            [
                'id' => 1,
                'health_facility_id' => 1,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'health_facility_id' => 2,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'health_facility_id' => 3,
                'user_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert To Database
        $this->db->table('mapping_auditor')->insertBatch($mappingAuditors);
    }
}

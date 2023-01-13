<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MappingFacilitySeeder extends Seeder
{
    public function run()
    {
        $mappingFacility = [
            [
                'id' => 1,
                'health_facility_id' => 1,
                'facility_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'health_facility_id' => 1,
                'facility_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
        ];

        // Insert To Database
        $this->db->table('health_facility_facilities')->insertBatch($mappingFacility);
    
    }
}

<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Helpers\HealthFacilityTypeHelper;

class HealthFacilitySeeder extends Seeder
{
    public function run()
    {
        $healthFacilities = [
            [
                'id' => 1,
                'name' => 'Puskesmas Cibeureum',
                'type' => HealthFacilityTypeHelper::PUSKESMAS,
                'code' => 'HF'.date('ymd').rand(0, 9).substr(strtotime(date('Y-m-d H:i:s')), -4),
                'address' => 'Jl. Jend. H. Amir Machmud No.126, Cibeureum, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40535',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'name' => 'Rumah Sakit Umum Daerah Cibabat',
                'type' => HealthFacilityTypeHelper::RUMAH_SAKIT,
                'code' => 'HF'.date('ymd').rand(0, 9).substr(strtotime(date('Y-m-d H:i:s')), -4),
                'address' => 'Jl. Jend. H. Amir Machmud No.140, Cibabat, Kec. Cimahi Utara, Kota Cimahi, Jawa Barat 40513',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'name' => 'Apotek K-24 Kebon Kopi',
                'type' => HealthFacilityTypeHelper::APOTEK,
                'code' => 'HF'.date('ymd').rand(0, 9).substr(strtotime(date('Y-m-d H:i:s')), -4),
                'address' => 'Jl. Kebon Kopi No.56, Cibeureum, Kec. Cimahi Sel., Kota Cimahi, Jawa Barat 40535',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert To Database
        $this->db->table('health_facilities')->insertBatch($healthFacilities);
    }
}

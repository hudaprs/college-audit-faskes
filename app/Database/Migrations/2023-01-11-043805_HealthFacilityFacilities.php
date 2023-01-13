<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HealthFacilityFacilities extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'health_facility_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'facility_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('health_facility_id', 'health_facilities', 'id');
        $this->forge->addForeignKey('facility_id', 'facilitie', 'id');
        $this->forge->createTable('health_facility_facilities', true);
    }

    public function down()
    {
        $this->forge->dropTable('health_facility_facilities');
    }
}

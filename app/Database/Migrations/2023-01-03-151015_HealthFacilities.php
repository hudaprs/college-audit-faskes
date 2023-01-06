<?php

namespace App\Database\Migrations;

use App\Helpers\HealthFacilityTypeHelper;
use CodeIgniter\Database\Migration;

class HealthFacilities extends Migration
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
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 128
            ],
            'type' => [
                'type' => 'ENUM',
                'constraint' => HealthFacilityTypeHelper::HEALTH_FACILITY_TYPE_LIST
            ],
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 64
            ],
            'address' => [
                'type' => 'text'
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('created_by', 'users', 'id');
        $this->forge->createTable('health_facilities', true);
    }

    public function down()
    {
        $this->forge->dropTable('health_facilities');
    }
}

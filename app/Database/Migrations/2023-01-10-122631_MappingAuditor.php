<?php

namespace App\Database\Migrations;
use CodeIgniter\Database\Migration;

class MappingAuditor extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'health_facility_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id');
        $this->forge->addForeignKey('health_facility_id', 'health_facilities', 'id');
        $this->forge->createTable('mapping_auditor', true);
    }

    public function down()
    {
        $this->forge->dropTable('mapping_auditor');
    }
}

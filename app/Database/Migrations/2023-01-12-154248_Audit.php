<?php

namespace App\Database\Migrations;

use App\Helpers\AuditHelper;
use CodeIgniter\Database\Migration;

class Audit extends Migration
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
            'code' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => AuditHelper::STATUS_LIST,
                'default' => AuditHelper::PENDING
            ],
            'health_facility_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'created_by' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('health_facility_id', 'health_facilities', 'id');
        $this->forge->addForeignKey('created_by', 'users', 'id');
        $this->forge->createTable('audits', true);
    }

    public function down()
    {
        $this->forge->dropTable('audits');
    }
}
<?php

namespace App\Database\Migrations;

use App\Helpers\AuditHelper;
use CodeIgniter\Database\Migration;

class AuditItems extends Migration
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
            'audit_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'facility_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'audit_criteria_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('audit_id', 'audits', 'id');
        $this->forge->addForeignKey('facility_id', 'facilitie', 'id');
        $this->forge->addForeignKey('audit_criteria_id', 'audit_criterias', 'id');
        $this->forge->createTable('audit_items', true);
    }

    public function down()
    {
        $this->forge->dropTable('audit_items');
    }
}
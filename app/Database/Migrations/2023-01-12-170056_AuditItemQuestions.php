<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuditItemQuestions extends Migration
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
            'audit_item_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true
            ],
            'audit_criteria_id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
            ],
            'question' => ['type' => 'TEXT'],
            'observation' => ['type' => 'TEXT'],
            'browse_document' => ['type' => 'TEXT'],
            'field_fact' => ['type' => 'TEXT'],
            'findings' => ['type' => 'TEXT'],
            'recommendation' => ['type' => 'TEXT'],
            'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
            'updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('audit_criteria_id', 'audit_criterias', 'id');
        $this->forge->addForeignKey('audit_item_id', 'audit_items', 'id');
        $this->forge->createTable('audit_item_questions', true);
    }

    public function down()
    {
        $this->forge->dropTable('audit_item_questions');
    }
}
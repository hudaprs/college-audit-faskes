<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditQuestionItem extends Model
{
    protected $table = 'audit_question_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'question', 'audit_criteria_id', 'created_at', 'updated_at'
    ];
    protected $returnType = 'object';
}

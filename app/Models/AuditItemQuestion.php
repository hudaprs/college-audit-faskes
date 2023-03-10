<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditItemQuestion extends Model
{
    protected $table = 'audit_item_questions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'audit_item_id',
        'audit_criteria_id',
        'question',
        'observation',
        'browse_document',
        'field_fact',
        'findings',
        'recommendation',
    ];
    protected $returnType = "object";
}
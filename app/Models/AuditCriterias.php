<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditCriterias extends Model
{
    protected $table = 'audit_criterias';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'criteria',
        'description',
        'created_by'
    ];
    protected $returnType = "object";
}
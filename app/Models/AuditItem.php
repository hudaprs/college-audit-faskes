<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditItem extends Model
{
    protected $table = 'audit_items';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'audit_id',
        'facility_id',
        'audit_criteria_id',
    ];
    protected $returnType = "object";
}
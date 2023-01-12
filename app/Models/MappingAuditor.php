<?php

namespace App\Models;

use CodeIgniter\Model;

class MappingAuditor extends Model
{
    protected $table = 'mapping_auditor';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'user_id', 'health_facility_id', 'created_at', 'updated_at'
    ];
    protected $returnType = 'object';
}

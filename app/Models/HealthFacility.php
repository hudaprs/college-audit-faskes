<?php

namespace App\Models;

use CodeIgniter\Model;

class HealthFacility extends Model
{
    protected $table = 'health_facilities';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'name', 'type', 'code', 'address', 'created_by', 'created_at'
    ];
    protected $returnType = 'object';
}

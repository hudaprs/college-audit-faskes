<?php

namespace App\Models;

use CodeIgniter\Model;

class MappingFacility extends Model
{
    protected $table = 'health_facility_facilities';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'health_facility_id', 'facility_id', 'created_by', 'created_at'
    ];
    protected $returnType = 'object';
}

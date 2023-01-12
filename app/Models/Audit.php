<?php

namespace App\Models;

use CodeIgniter\Model;

class Audit extends Model
{
    protected $table = 'audits';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'health_facility_id',
        'created_by',
        'code',
        'status'
    ];
    protected $returnType = "object";
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class Facilitie extends Model
{
    protected $table = 'facilitie';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'name'
    ];
    protected $returnType = "object";
}
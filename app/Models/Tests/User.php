<?php

namespace App\Models\Tests;

use App\Models\User as RealUser;
use CodeIgniter\Test\Interfaces\FabricatorModel;
use Faker\Generator;

class User extends RealUser implements FabricatorModel
{
    public function fake(Generator &$faker)
    {
        return [
            'name' => $faker->firstName,
            'email' => $faker->email,
            'password' => password_hash('password', PASSWORD_BCRYPT),
            'role' => 'ROLE_TEST'
        ];
    }
}
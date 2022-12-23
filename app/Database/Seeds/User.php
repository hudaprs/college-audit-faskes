<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class User extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => 'ROLE_1'
            ],
            [
                'name' => 'Auditor',
                'email' => 'auditor@gmail.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => 'ROLE_2'
            ]
        ];

        $this->db->table('users')->insertBatch($users);
    }
}
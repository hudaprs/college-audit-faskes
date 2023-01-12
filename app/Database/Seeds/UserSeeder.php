<?php

namespace App\Database\Seeds;

use App\Helpers\RoleHelper;
use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => RoleHelper::ADMIN
            ],
            [
                'name' => 'Auditor',
                'email' => 'auditor@gmail.com',
                'password' => password_hash('password', PASSWORD_BCRYPT),
                'role' => RoleHelper::AUDITOR
            ]
        ];

        // Generate fake users
        $userFaker = new Fabricator(User::class);
        $userFaker->setOverrides([
            'role' => RoleHelper::DEFAULT ,
            'password' => password_hash('password', PASSWORD_BCRYPT)
        ]);
        $auditorUserFaker = new Fabricator(User::class);
        $auditorUserFaker->setOverrides([
            'role' => RoleHelper::AUDITOR,
            'password' => password_hash('password', PASSWORD_BCRYPT)
        ]);
        $fakeUsers = $userFaker->make(20);
        $auditors = $auditorUserFaker->make(10);

        // Insert To Database
        $this->db->table('users')->insertBatch($users);
        $this->db->table('users')->insertBatch($fakeUsers);
        $this->db->table('users')->insertBatch($auditors);
    }
}
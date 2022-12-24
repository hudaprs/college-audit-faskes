<?php

namespace App\Controllers\Tests;

use App\Controllers\BaseController;
use App\Models\Tests\User as UserTest;
use App\Models\User as RealUser;
use CodeIgniter\Test\Fabricator;

class UserController extends BaseController
{
    public function index()
    {
        // Generate fake users
        $userFaker = new Fabricator(UserTest::class);
        $fakeUsers = $userFaker->make(20);

        // Insert fake users
        $user = new RealUser;
        $user->insertBatch($fakeUsers);

        return redirect()->to(base_url());
    }
}
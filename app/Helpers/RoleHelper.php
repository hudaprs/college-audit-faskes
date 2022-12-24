<?php

namespace App\Helpers;

class RoleHelper
{
    const DEFAULT = 'Default';
    const ADMIN = 'Admin';
    const AUDITOR = 'Auditor';

    const ROLE_LIST = [self::DEFAULT , self::ADMIN, self::AUDITOR];

    public static function isAdmin()
    {
        return session()->get('role') === self::ADMIN;
    }
}
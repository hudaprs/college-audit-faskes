<?php

namespace App\Helpers;

class AuditHelper
{
    const PENDING = 'Pending';
    const ON_PROGRESS = 'On Progress';
    const DONE = 'Done';

    const STATUS_LIST = [self::PENDING, self::ON_PROGRESS, self::DONE];
}
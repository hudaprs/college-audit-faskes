<?php

namespace App\Helpers;

class HealthFacilityTypeHelper
{
    const UKM = 'Unit Kesehatan Masyarakat';
    const UKP = 'Unit Kesehatan Perorangan';
    const RS = 'Rumah Sakit';
    const KLINIK = 'Klinik';

    const HEALTH_FACILITY_TYPE_LIST = [self::UKM, self::UKP, self::RS, self::KLINIK];
}
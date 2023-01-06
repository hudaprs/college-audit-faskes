<?php

namespace App\Helpers;

class HealthFacilityTypeHelper
{
    const PUSKESMAS = 'Puskesmas';
    const RUMAH_SAKIT = 'Rumah Sakit';
    const KLINIK = 'Klinik';
    const APOTEK = 'Apotek';
    const LABORATORIUM = 'Laboratorium Kesehatan';
    const OPTIKAL = 'Optikal';

    const HEALTH_FACILITY_TYPE_LIST = [
        self::PUSKESMAS,
        self::RUMAH_SAKIT,
        self::KLINIK,
        self::APOTEK,
        self::LABORATORIUM,
        self::OPTIKAL
    ];
}
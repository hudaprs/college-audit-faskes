<?php

namespace App\Controllers;

class TestController extends BaseController
{
    public function mappingFacility()
    {
        return view('tests/mapping_facility');
    }

    public function mappingHealthFacilityAuditor()
    {
        return view('tests/mapping_health_facility_auditor');
    }

    public function question()
    {
        return view('tests/question');
    }

    public function mappingQuestion()
    {
        return view('tests/mapping_question');
    }
}
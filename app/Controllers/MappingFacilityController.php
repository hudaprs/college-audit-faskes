<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MappingFacility;
use App\Models\Facilitie;

class MappingFacilityController extends BaseController
{
    private function _params(array $params=[])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'isDetail' => $params['isDetail'] ?? false,
            'mappingFacility' => $params['mappingFacility'] ?? null,
            'facilities' => $params['facilities'] ?? null
        ];
    }

    private function _validation($isEdit=false, $id=null)
    {
        $validation = [
            'name' => 'required',
            'type' => 'required',
            'address' => 'required'
        ];

        return $this->validate($validation);
    }

    private function _getMappingFacility($id)
    {
        $mappingFacilities = new MappingFacility();
        $mappingFacility = $mappingFacilities->select([
                'health_facility_facilities.id',
                'health_facilities.name AS health_facility_id',
                'facilitie.name AS facility_id',
                'health_facility_facilities.created_at'
            ])
            ->join('health_facilities', 'health_facilities.id = health_facility_facilities.health_facility_id', 'LEFT')
            ->join('facilitie', 'facilitie.id = health_facility_facilities.facility_id', 'LEFT')
            ->where('health_facility_facilities.id', $id)->first();

        return $mappingFacility;
    }

    private function _getFacility()
    {
        $facilitie = new Facilitie();
        $facilities = $facilitie->findAll();

        return $facilities;
    }

    public function index()
    {
        $mappingFacility = new MappingFacility();
        $mappingFacilities = $mappingFacility->select([
                'health_facility_facilities.id',
                'health_facilities.name AS health_facility_id',
                'facilitie.name AS facility_id',
                'health_facility_facilities.created_at'
            ])
            ->join('health_facilities', 'health_facilities.id = health_facility_facilities.health_facility_id', 'LEFT')
            ->join('facilitie', 'facilitie.id = health_facility_facilities.facility_id', 'LEFT')
            ->orderBy('health_facility_facilities.created_at', 'DESC')
            ->paginate(10);

        $pagination = $mappingFacility->pager;

        return view('facility-management/mapping-facility/index', [
            'mappingFacilities' => $mappingFacilities,
            'pagination' => $pagination
        ]);
    }

    public function show($id)
    {
        $mappingFacility = $this->_getMappingFacility($id);
        return view('facility-management/mapping-facility/create_edit', $this->_params([
            'isDetail' => true,
            'mappingFacility' => $mappingFacility
        ]));
    }

    public function edit($id)
    {
        $mappingFacility = $this->_getMappingFacility($id);
        $facilities = $this->_getFacility();
        
        return view('facility-management/mapping-facility/create_edit', $this->_params([
            'isEdit' => true,
            'mappingFacility' => $mappingFacility,
            'facilities' => $facilities
        ]));
    }

    public function update($id)
    {
        $db = db_connect();
        $db->transBegin();

        $validation = $this->_validation(true, $id);
        if (!$validation) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $mappingFacility = new MappingFacility;
        $mappingFacility->update($id, [
            'facility_id' => $this->request->getVar('facilities'),
        ]);

        

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update facilitie');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Facilitie updated successfully');
        return redirect()->to(base_url('facility-management/mapping-facility'));
    }


}

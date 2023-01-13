<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MappingFacility;
use App\Models\HealthFacility;
use App\Models\Facilitie;

class MappingFacilityController extends BaseController
{
    private function _params(array $params = [])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'mappingFacility' => $params['mappingFacility'] ?? null,
            'healthFacility' => $params['healthFacility'] ?? null,
            'facilities' => $params['facilities'] ?? null
        ];
    }

    private function _validation($isEdit = false, $id = null)
    {
        $validation = [
            'facility_id' => 'required',
            'health_facility_id' => 'required'
        ];

        return $this->validate($validation);
    }

    private function _getMappingFacility($id)
    {
        $mappingFacility = new MappingFacility();
        $vA = $mappingFacility->where('health_facility_id', $id)->findAll();
        $facilityList = [];
        foreach ($vA as $b) {
            $facilityList[] = $b->facility_id;
        }
        return $facilityList;
    }

    private function _getHealthFacility($id)
    {
        $healthFacility = new HealthFacility();
        return $healthFacility->where('id', $id)->first();
    }


    private function _getFacility($id)
    {
        $facilitie = new Facilitie();
        $facilities = $facilitie->findAll();
        return $facilities;
    }

    public function index()
    {
        $healthFacility = new HealthFacility();
        $healthFacilities = $healthFacility->select([
            'health_facilities.id',
            'health_facilities.name',
            'health_facilities.code',
            'health_facilities.type',
            'health_facilities.address',
            'users.name AS created_by',
            'health_facilities.created_at'
        ])
            ->join('users', 'users.id = health_facilities.created_by', 'LEFT')
            ->orderBy('health_facilities.created_at', 'DESC')
            ->paginate(10);

        $pagination = $healthFacility->pager;

        return view('facility-management/mapping-facility/index', [
            'mappingFacilities' => $healthFacilities,
            'pagination' => $pagination
        ]);
    }

    public function edit($id)
    {
        $mappingFacility = $this->_getMappingFacility($id);
        $healthFacility = $this->_getHealthFacility($id);
        $facilities = $this->_getFacility($id);

        return view('facility-management/mapping-facility/create_edit', $this->_params([
            'isEdit' => true,
            'mappingFacility' => $mappingFacility,
            'healthFacility' => $healthFacility,
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

        $id = $this->request->getVar('health_facility_id');
        $facilities = $this->request->getVar('facility_id[]');
        $mappingFacilityId = $this->request->getVar('mapping_facility_id[]');

        $addMappingFacilities = [];
        $editMappingFacilities = [];
        foreach ($facilities as $idx => $facility) {
            if (empty($mappingFacilityId[$idx]) || !isset($mappingFacilityId[$idx])) {
                if (!empty($facility)) {
                    $addMappingFacilities[] = [
                        'health_facility_id' => $id,
                        'facility_id' => $facility,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            } else {
                $editMappingFacilities[] = [
                    'id' => $mappingFacilityId[$idx],
                    'facility_id' => $facility,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        $mappingFacility = new MappingFacility;

        $mappingFacility->where('health_facility_id', $id)
            ->delete();

        $mappingFacilitiesExistsId = [];
        if (!empty($editMappingFacilities)) {
            foreach ($editMappingFacilities as $editMappingFacility) {
                $mappingFacilitiesExistsId[] = $editMappingFacility['id'];
                $mappingFacility->update($editMappingFacility['id'], [
                    'facility_id' => $editMappingFacility['facility_id'],
                    'updated_at' => $editMappingFacility['updated_at']
                ]);
            }
        }

        if (!empty($addMappingFacilities)) {
            $mappingFacility->insertBatch($addMappingFacilities);
        }

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
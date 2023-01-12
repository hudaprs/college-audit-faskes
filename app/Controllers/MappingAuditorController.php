<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MappingAuditor;
use App\Models\HealthFacility;
use App\Models\User;

class MappingAuditorController extends BaseController
{
    private function _params(array $params=[])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'isDetail' => $params['isDetail'] ?? false,
            'mappingAuditor' => $params['mappingAuditor'] ?? null,
            'healthFacility' => $params['healthFacility'] ?? null,
            'user' => $params['user'] ?? null
        ];
    }

    private function _validation($isEdit=false, $id=null)
    {
        $validation = [
            'user_id' => 'required',
            'health_facility_id' => 'required'
        ];

        return $this->validate($validation);
    }

    private function _getMappingAuditor($id)
    {
        $mappingAuditor = new MappingAuditor();

        
        $vA = $mappingAuditor->where('health_facility_id', $id)->findAll();
        $userList = [];
        foreach ($vA as $b) {
            $userList[] = $b->user_id; 
        }
        return $userList;
    }

    private function _getHealthFacility($id)
    {
        $healthFacility = new HealthFacility();
        return $healthFacility->where('id', $id)->first();
    }

    private function _getUser($id)
    {
        $user = new User();
        return $user->where('role', 'Auditor')->findAll();
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

        return view('facility-management/mapping-auditor/index', [
            'health_facilities' => $healthFacilities,
            'pagination' => $pagination
        ]);
    }

    public function edit($id)
    {
        $mappingAuditor = $this->_getMappingAuditor($id);
        $healthFacility = $this->_getHealthFacility($id);
        $user = $this->_getUser($id);

        // var_dump($mappingAuditor);
        // die();

        return view('facility-management/mapping-auditor/create-edit', $this->_params([
            'isEdit' => true,
            'mappingAuditor' => $mappingAuditor,
            'healthFacility' => $healthFacility,
            'user' => $user
        ]));
    }

    public function update($id)
    {
        // var_dump($this->request->getvar('user_id[]'));
        // die();

        $db = db_connect();
        $db->transBegin();

        $validation = $this->_validation(true, $id);
        if (!$validation) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $id = $this->request->getVar('health_facility_id');
        $auditors = $this->request->getVar('user_id[]');
        $mappingAuditorId = $this->request->getVar('mapping_auditor_id[]');

        $addMappingAuditors = [];
        $editMappingAuditors = [];
        foreach($auditors as $idx => $auditor) {
            if (empty($mappingAuditorId[$idx]) || !isset($mappingAuditorId[$idx])) {
                if (!empty($auditor)) {
                    $addMappingAuditors[] = [
                        'health_facility_id' => $id,
                        'user_id' => $auditor,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            } else {
                $editMappingAuditors[] = [
                    'id' => $mappingAuditorId[$idx],
                    'user_id' => $auditor,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        $mappingAuditor = new MappingAuditor();

        $mappingAuditor->where('health_facility_id', $id)
            ->delete();

        $mappingAuditorsExistsId = [];
        if (!empty($editMappingAuditors)) {
            foreach($editMappingAuditors as $editMappingAuditor) {
                $mappingAuditorsExistsId[] = $editMappingAuditor['id'];
                $mappingAuditor->update($editMappingAuditor['id'], [
                    'user_id' => $editMappingAuditor['user_id'],
                    'updated_at' => $editMappingAuditor['updated_at']
                ]);
            }
        }

        

        if (!empty($addMappingAuditors)) {
            $mappingAuditor->insertBatch($addMappingAuditors);
        }

        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update Mapping Auditor');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Mapping Auditor updated successfully');
        return redirect()->to(base_url('facility-management/mapping-auditor'));
    }
}
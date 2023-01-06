<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Helpers\HealthFacilityTypeHelper;
use App\Models\HealthFacility;

class HealthFacilityController extends BaseController
{
    private function _params(array $params=[])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'isDetail' => $params['isDetail'] ?? false,
            'healthFacilityTypeList' => $params['healthFacilityTypeList'] ?? HealthFacilityTypeHelper::HEALTH_FACILITY_TYPE_LIST,
            'healthFacility' => $params['healthFacility'] ?? null
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

    private function _getHealthFacility($id)
    {
        $healthFacility = new HealthFacility();
        return $healthFacility->where('id', $id)->first();
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

        return view('facility-management/health-facility/index', [
            'health_facilities' => $healthFacilities,
            'pagination' => $pagination
        ]);
    }

    public function create()
    {
        return view('facility-management/health-facility/create-edit', $this->_params());
    }

    public function store()
    {
        $db = db_connect();
        $db->transBegin();

        $validation = $this->_validation();
        if (!$validation) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $healthFacility = new HealthFacility();

        $isCodeExists = $healthFacility->where('code', $this->request->getVar('code'))->first();
        if ($isCodeExists) {
            session()->setFlashdata('error', 'Code already exists');
            return redirect()->back()->withInput();
        }

        $healthFacility->insert([
            'name' => $this->request->getVar('name'),
            'type' => $this->request->getVar('type'),
            'code' => 'HF'.date('ymd').rand(0, 9).substr(strtotime(date('Y-m-d H:i:s')), -4),
            'address' => $this->request->getVar('address'),
            'created_by' => session()->get('id'),
            'created_at' => date('Y-m-d H:i:s')
        ]);

        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to create Health Facility');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Health Facility created successfully');
        return redirect()->to(base_url('facility-management/health-facility'));
    }

    public function show($id)
    {
        $healthFacility = $this->_getHealthFacility($id);
        return view('facility-management/health-facility/create-edit', $this->_params([
            'isDetail' => true,
            'healthFacility' => $healthFacility
        ]));
    }

    public function edit($id)
    {
        $healthFacility = $this->_getHealthFacility($id);
        return view('facility-management/health-facility/create-edit', $this->_params([
            'isEdit' => true,
            'healthFacility' => $healthFacility
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

        $healthFacility = new HealthFacility();
        $healthFacility->update($id, [
            'name' => $this->request->getVar('name'),
            'type' => $this->request->getVar('type'),
            'code' => $this->request->getVar('code'),
            'address' => $this->request->getVar('address')
        ]);

        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update Health Facility');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Health Facility updated successfully');
        return redirect()->to(base_url('facility-management/health-facility'));
    }

    public function delete($id)
    {
        $db = db_connect();
        $db->transBegin();

        $healthFacility = new HealthFacility();
        $healthFacility->where('id', $id)->delete();

        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to delete Health Facility');
            return redirect()->back();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Health Facility deleted successfully');
        return redirect()->to(base_url('facility-management/health-facility'));
    }
}

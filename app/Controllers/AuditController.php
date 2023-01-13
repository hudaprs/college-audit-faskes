<?php

namespace App\Controllers;

use App\Helpers\AuditHelper;
use App\Models\Audit;
use App\Models\HealthFacility;
use App\Models\User;
use App\Models\AuditItem;
use App\Models\AuditItemQuestion;

class AuditController extends BaseController
{
    private function _params(array $params = [])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'isDetail' => $params['isDetail'] ?? false,
            'statusList' => AuditHelper::STATUS_LIST,
            'audit' => $params['audit'] ?? null,
            'healthFacilityList' => $params['healthFacilityList'] ?? [],
        ];
    }

    private function _validation($isEdit = false, $id = null)
    {
        $validation = [
            'health_facility' => 'required',
        ];

        return $this->validate($validation);
    }

    private function _getAudit($id)
    {
        $audit = new Audit();
        return $audit->where('id', $id)->first();
    }

    public function index()
    {
        $audit = new Audit();
        $audits = $audit
            ->select([
                'audits.id',
                'audits.code',
                'audits.status',
                'health_facilities.name',
                'users.name as created_by',
                'audits.created_at',
                'audits.updated_at',
            ])
            ->join('health_facilities', 'audits.health_facility_id = health_facilities.id', 'inner')
            ->join('users', 'audits.created_by = users.id')
            ->orderBy('audits.created_at', 'desc')
            ->paginate(10);
        $pagination = $audit->pager;

        return view('audit/index', [
            'audits' => $audits,
            'pagination' => $pagination
        ]);
    }

    public function create()
    {
        $healthFacility = new HealthFacility();
        $healthFacilityList = $healthFacility->select(['id', 'name', 'code'])->findAll();
        return view('audit/create_edit', $this->_params([
            'healthFacilityList' => $healthFacilityList
        ]));
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


        $audit = new Audit();

        // Get last audit data
        $lastAudit = $audit->orderBy('created_at', 'desc')->limit(1)->findAll();

        // Insert to audit table
        $audit->insert([
            'health_facility_id' => $this->request->getVar('health_facility'),
            'created_by' => session()->get('id'),
            'status' => AuditHelper::PENDING,
            'code' => count($lastAudit) > 0 ? $lastAudit[0]->id + 1 : 1 . "/AUDIT/" . date('dmy'),
        ]);

        // Insert to Audit Items

        // Insert to Audit Item Question


        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to create user');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Audit created successfully');
        return redirect()->to(base_url('audits/index'));
    }

    public function show($id)
    {
        $user = $this->_getUser($id);
        return view('master/users/create_edit', $this->_params([
            'isDetail' => true,
            'user' => $user
        ]));
    }

    public function edit($id)
    {
        $user = $this->_getUser($id);
        return view('master/users/create_edit', $this->_params([
            'isEdit' => true,
            'user' => $user
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

        $user = new User;
        $user->update($id, [
            'name' => $this->request->getVar('name'),
            'email' => $this->_inputtedEmail(),
            'role' => $this->request->getVar('role'),
        ]);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update user');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'User updated successfully');
        return redirect()->to(base_url('master/users'));
    }

    public function delete($id)
    {
        $db = db_connect();
        $db->transBegin();

        $user = new User();
        $user->where('id', $id)->delete();

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to delete user');
            return redirect()->back();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'User deleted successfully');
        return redirect()->to(base_url('master/users'));
    }
}
<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\AuditCriterias;

class AuditCriteriasController extends BaseController
{
    private function _params(array $params = [])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'isDetail' => $params['isDetail'] ?? false,
            // 'roleList' => $params['roleList'] ?? RoleHelper::ROLE_LIST,
            'auditCriteria' => $params['auditCriteria'] ?? null
        ];
    }

    private function _validation($isEdit = false, $id = null)
    {
        $validation = [
            'criteria' => 'required'
        ];

        return $this->validate($validation);
    }

    private function _getAuditCriteria($id)
    {
        $auditCriteria = new AuditCriterias();
        return $auditCriteria->where('id', $id)->first();
    }

    public function index()
    {
        $auditCriteria = new AuditCriterias();
        $auditCriterias = $auditCriteria->select([
                'audit_criterias.id',
                'audit_criterias.criteria',
                'audit_criterias.description',
                'users.name AS created_by',
                'audit_criterias.created_at'
            ])
            ->join('users', 'users.id = audit_criterias.created_by', 'LEFT')
            ->orderBy('audit_criterias.created_at', 'desc')
            ->paginate(10);

        // $pagination = $auditCriterias->pager;

        return view('question-management/audit-criterias/index', [
            'audit_criteria' => $auditCriterias,
            // 'pagination' => $pagination
        ]);
    }

    public function create()
    {
        return view('question-management/audit-criterias/create-edit', $this->_params());
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


        $auditCriteria = new AuditCriterias();

        $auditCriteria->insert([
            'criteria' => $this->request->getVar('criteria'),
            'description' => $this->request->getVar('description'),
            'created_by' => session()->get('id'),
        ]);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to create audit criteria');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Audit criteria created successfully');
        return redirect()->to(base_url('question-management/audit-criterias'));
    }

    public function show($id)
    {
        $auditCriteria = $this->_getAuditCriteria($id);
        return view('question-management/audit-criterias/create-edit', $this->_params([
            'isDetail' => true,
            'auditCriteria' => $auditCriteria
        ]));
    }

    public function edit($id)
    {
        $auditCriteria = $this->_getAuditCriteria($id);
        return view('question-management/audit-criterias/create-edit', $this->_params([
            'isEdit' => true,
            'auditCriteria' => $auditCriteria
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

        $auditCriteria = new auditCriterias();
        $auditCriteria->update($id, [
            'criteria' => $this->request->getVar('criteria'),
            'description' => $this->request->getVar('description'),
        ]);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update audit criteria');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Audit criteria updated successfully');
        return redirect()->to(base_url('question-management/audit-criterias'));
    }

    public function delete($id)
    {
        $db = db_connect();
        $db->transBegin();

        $auditCriteria = new AuditCriterias();
        $auditCriteria->where('id', $id)->delete();

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to delete audit criteria');
            return redirect()->back();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Audit criteria deleted successfully');
        return redirect()->to(base_url('question-management/audit-criterias'));
    }

}

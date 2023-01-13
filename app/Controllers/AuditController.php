<?php

namespace App\Controllers;

use App\Database\Migrations\AuditCriteria;
use App\Helpers\AuditHelper;
use App\Models\Audit;
use App\Models\AuditQuestionItem;
use App\Models\Facilitie;
use App\Models\HealthFacility;
use App\Models\MappingFacility;
use App\Models\User;
use App\Models\AuditCriterias;
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
            'auditCriteriaList' => $params['auditCriteriaList'] ?? [],
            'facilityDetail' => $params['facilityDetail'] ?? null,
            'questionDetail' => $params['questionDetail'] ?? [],
            'questions' => $params['questions'] ?? [],
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
        $mappingFacility = new MappingFacility();
        $auditCriteria = new AuditCriterias();

        $healthFacilityList = $healthFacility
            ->select([
                'health_facilities.id',
                'health_facilities.name',
                'health_facilities.code'
            ])
            ->join('health_facility_facilities', 'health_facilities.id = health_facility_facilities.health_facility_id')
            ->groupBy('health_facilities.id')
            ->findAll();
        $auditCriteriaList = $auditCriteria->findAll();


        // Check if request is ajax
        if ($this->request->isAJAX()) {
            $mappingFacilityList = $mappingFacility->select([
                'health_facility_facilities.id',
                'health_facility_facilities.facility_id',
                'health_facility_facilities.health_facility_id',
                'facilitie.name as facility_name',
                'health_facilities.name as health_facility_name'
            ])
                ->join('facilitie', 'facilitie.id = health_facility_facilities.facility_id')
                ->join('health_facilities', 'health_facilities.id = health_facility_facilities.health_facility_id')
                ->where('health_facility_id', $this->request->getGet('health_facility_id'))
                ->findAll();

            return $this->response->setJSON([
                'facilityList' => $mappingFacilityList,
            ]);
        }

        return view('audit/create_edit', $this->_params([
            'healthFacilityList' => $healthFacilityList,
            'auditCriteriaList' => $auditCriteriaList,
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
        $auditItem = new AuditItem();
        $auditQuestionItem = new AuditQuestionItem();
        $auditItemQuestion = new AuditItemQuestion();

        // Get last audit data
        $lastAudit = $audit->orderBy('created_at', 'desc')->limit(1)->findAll();

        // Insert to audit table
        $audit->insert([
            'health_facility_id' => $this->request->getVar('health_facility'),
            'created_by' => session()->get('id'),
            'status' => AuditHelper::PENDING,
            'code' => (count($lastAudit) > 0 ? $lastAudit[0]->id + 1 : 1) . "/AUDIT/" . date('dmy'),
        ]);

        // Insert to Audit Items
        $_facilityList = [];
        $_criteriaList = [];

        foreach ($this->request->getVar('facility[]') as $facility) {
            if ($facility !== '') {
                $_facilityList[] = $facility;
            }
        }

        foreach ($this->request->getVar('criteria[]') as $criteria) {
            if ($criteria !== '') {
                $_criteriaList[] = $criteria;
            }
        }

        $mapAuditItems = array_map(function ($item) use ($audit) {
            return [
                'audit_id' => $audit->getInsertID(),
                'facility_id' => explode("-", $item)[0],
                'audit_criteria_id' => explode("-", $item)[1],
            ];
        }, $_criteriaList);

        $insertedAuditItems = [];
        foreach ($mapAuditItems as $mapAuditItem) {
            $auditItem->insert($mapAuditItem);

            $insertedAuditItems[] = [
                'audit_item_id' => $auditItem->getInsertID(),
                'audit_criteria_id' => $mapAuditItem['audit_criteria_id']
            ];
        }

        $auditItemQuestionsReal = [];
        foreach ($insertedAuditItems as $auditItem) {
            $auditQuestionList = $auditQuestionItem->where('audit_criteria_id', $auditItem['audit_criteria_id'])->findAll();

            foreach ($auditQuestionList as $question) {
                $auditItemQuestionsReal[] = [
                    'audit_item_id' => $auditItem['audit_item_id'],
                    'audit_criteria_id' => $question->audit_criteria_id,
                    'question' => $question->question,
                    'observation' => '',
                    'browse_document' => '',
                    'field_fact' => '',
                    'findings' => '',
                    'recommendation' => '',
                ];
            }
        }

        $auditItemQuestion->insertBatch($auditItemQuestionsReal);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to create user');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Audit created successfully');
        return redirect()->to(base_url('audits'));
    }

    public function edit($id)
    {
        $audit = $this->_getAudit($id);
        $healthFacility = new HealthFacility();
        $healthFacilityList = $healthFacility
            ->select([
                'health_facilities.id',
                'health_facilities.name',
                'health_facilities.code'
            ])
            ->join('health_facility_facilities', 'health_facilities.id = health_facility_facilities.health_facility_id')
            ->groupBy('health_facilities.id')
            ->findAll();
        $facility = new Facilitie;
        $facilityDetail = $facility
            ->select([
                'facilitie.id',
                'facilitie.name',
            ])
            ->join('audit_items', 'facilitie.id = audit_items.facility_id')
            ->where('audit_items.audit_id', $id)
            ->groupBy('facilitie.id')
            ->findAll();
        $auditCriteria = new AuditCriterias();
        $auditCriteriaList = $auditCriteria
            ->join('audit_items', 'audit_items.audit_criteria_id = audit_criterias.id')
            ->where('audit_items.audit_id', $id)
            ->findAll();
        $question = new AuditItemQuestion();
        $questionDetail = $question->select([
            'audit_item_questions.id',
            'audit_item_questions.audit_item_id',
            'audit_item_questions.question',
            'audit_item_questions.observation',
            'audit_item_questions.browse_document',
            'audit_item_questions.field_fact',
            'audit_item_questions.findings',
            'audit_item_questions.recommendation',
        ])
            ->join('audit_items', 'audit_item_questions.audit_item_id = audit_items.id', 'right')
            ->where('audit_items.audit_id', $id)
            ->findAll();
        return view('audit/create_edit', $this->_params([
            'isEdit' => true,
            'audit' => $audit,
            'healthFacilityList' => $healthFacilityList,
            'facilityDetail' => $facilityDetail,
            'auditCriteriaList' => $auditCriteriaList,
            'questionDetail' => $questionDetail,
        ]));
    }

    public function update($id)
    {
        $db = db_connect();
        $db->transBegin();

        $singleAudit = $this->_getAudit($id);
        $audit = new Audit;
        $status = $singleAudit->status === AuditHelper::PENDING
            ? AuditHelper::ON_PROGRESS
            : (
                $singleAudit->status === AuditHelper::ON_PROGRESS
                ? AuditHelper::DONE
                : AuditHelper::PENDING
            );
        $audit->where('id', $id);
        $audit->set('status', $status);
        $audit->update();

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update user');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Audit updated successfully');
        return redirect()->back();
    }

    public function updateAuditFields($id)
    {
        $db = db_connect();
        $db->transBegin();

        $auditItemQuestion = new AuditItemQuestion;
        $auditItemQuestion->where('id', $id);


        // Check for observation
        if ($this->request->getVar('observation')) {
            $auditItemQuestion->set('observation', $this->request->getVar('observation'));
            $auditItemQuestion->update();

        }

        // Check for browse document
        if ($this->request->getVar('browse_document')) {
            $auditItemQuestion->set('browse_document', $this->request->getVar('browse_document'));
            $auditItemQuestion->update();

        }

        // Check for field fact
        if ($this->request->getVar('field_fact')) {
            $auditItemQuestion->set('field_fact', $this->request->getVar('field_fact'));
            $auditItemQuestion->update();

        }

        // Check for findings
        if ($this->request->getVar('findings')) {
            $auditItemQuestion->set('findings', $this->request->getVar('findings'));
            $auditItemQuestion->update();

        }


        // Check for recommendation
        if ($this->request->getVar('recommendation')) {
            $auditItemQuestion->set('recommendation', $this->request->getVar('recommendation'));
            $auditItemQuestion->update();
        }


        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            return $this->response->setJSON(['message' => 'Something went wrong when start to update user']);
        }


        $db->transCommit();

        return $this->response->setJSON(['message' => 'Audit fields updated', 'token' => csrf_hash()]);
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
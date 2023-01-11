<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AuditQuestionItem;

class MappingQuestionController extends BaseController
{
    private function _params(array $params=[])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'isDetail' => $params['isDetail'] ?? false,
            'auditCriteria' => $params['auditCriteria'] ?? null,
            'auditQuestionItems' => $params['auditQuestionItems'] ?? []
        ];
    }

    private function _validation($isEdit=false, $auditCriteriaId=null)
    {
        $validation = [
            'questions' => 'required',
            'audit_criteria_id' => 'required'
        ];

        return $this->validate($validation);
    }

    private function _getAuditQuestionItems($auditCriteriaId)
    {
        $auditQuestionItems = new AuditQuestionItem();
        return $auditQuestionItems->where('audit_criteria_id', $auditCriteriaId)->findAll();
    }

    public function index()
    {
        return view('question-management/mapping-question/index');
    }

    public function edit($auditCriteriaId)
    {
        $auditQuestionItems = $this->_getAuditQuestionItems($auditCriteriaId);
        return view('question-management/mapping-question/create-edit', $this->_params([
            'isEdit' => true,
            'auditQuestionItems' => $auditQuestionItems
        ]));
    }

    public function update($auditCriteriaId)
    {
        $db = db_connect();
        $db->transBegin();

        $validation = $this->_validation(true, $auditCriteriaId);
        if (!$validation) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back()->withInput();
        }

        $auditCriteriaId = $this->request->getVar('audit_criteria_id');
        $questions = $this->request->getVar('questions[]');
        $auditQuestionItemsId = $this->request->getVar('audit_question_item_id[]');
        
        $addQuestions = [];
        $editQuestions = [];
        foreach($questions as $idx => $question) {
            if (empty($auditQuestionItemsId[$idx]) || !isset($auditQuestionItemsId[$idx])) {
                if (!empty($question)) {
                    $addQuestions[] = [
                        'question' => $question,
                        'audit_criteria_id' => $auditCriteriaId,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ];
                }
            } else {
                $editQuestions[] = [
                    'id' => $auditQuestionItemsId[$idx],
                    'question' => $question,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
            }
        }

        $auditQuestionItem = new AuditQuestionItem();

        $auditQuestionItemsExistsId = [];
        if (!empty($editQuestions)) {
            foreach($editQuestions as $editQuestion) {
                $auditQuestionItemsExistsId[] = $editQuestion['id'];
                $auditQuestionItem->update($editQuestion['id'], [
                    'question' => $editQuestion['question'],
                    'updated_at' => $editQuestion['updated_at']
                ]);
            }
        }

        $auditQuestionItem->where('audit_criteria_id', $auditCriteriaId)
            ->whereNotIn('id', $auditQuestionItemsExistsId)
            ->delete();

        if (!empty($addQuestions)) {
            $auditQuestionItem->insertBatch($addQuestions);
        }

        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update Mapping Question');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Mapping Question updated successfully');
        return redirect()->to(base_url('question-management/mapping-question'));
    }
}

<?php namespace App\Controllers;

use \App\Models\Facilitie;
use CodeIgniter\Exceptions\PageNotFoundException;

class FacilitieController extends BaseController
{
    private function _params(array $params = [])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'isDetail' => $params['isDetail'] ?? false,
            // 'roleList' => $params['roleList'] ?? RoleHelper::ROLE_LIST,
            'facilitie' => $params['facilitie'] ?? null
        ];
    }

    private function _validation($isEdit = false, $id = null)
    {
        $validation = [
            'name' => 'required'
        ];

        return $this->validate($validation);
    }

    private function _getFacilitie($id)
    {
        $facilitie = new Facilitie();
        return $facilitie->where('id', $id)->first();
    }

    public function index()
    {
        $facilitie = new Facilitie();
        $facilities = $facilitie->orderBy('created_at', 'desc')->where('id !=', session()->get('id'))->paginate(10);
        $pagination = $facilitie->pager;

        return view('master/facilitie/index', [
            'facilitie' => $facilities,
            'pagination' => $pagination
        ]);
    }

    public function create()
    {
        return view('master/facilitie/create_edit', $this->_params());
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


        $facilitie = new Facilitie;

        $facilitie->insert([
            'name' => $this->request->getVar('name'),
        ]);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to create facilitie');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Facilitie created successfully');
        return redirect()->to(base_url('master/facilitie'));
    }

    public function show($id)
    {
        $facilitie = $this->_getFacilitie($id);
        return view('master/facilitie/create_edit', $this->_params([
            'isDetail' => true,
            'facilitie' => $facilitie
        ]));
    }

    public function edit($id)
    {
        $facilitie = $this->_getFacilitie($id);
        return view('master/facilitie/create_edit', $this->_params([
            'isEdit' => true,
            'facilitie' => $facilitie
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

        $facilitie = new Facilitie;
        $facilitie->update($id, [
            'name' => $this->request->getVar('name'),
        ]);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update facilitie');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Facilitie updated successfully');
        return redirect()->to(base_url('master/facilitie'));
    }

    public function delete($id)
    {
        $db = db_connect();
        $db->transBegin();

        $facilitie = new Facilitie();
        $facilitie->where('id', $id)->delete();

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to delete facilitie');
            return redirect()->back();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'Facilitie deleted successfully');
        return redirect()->to(base_url('master/facilitie'));
    }

}
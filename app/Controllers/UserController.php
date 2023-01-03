<?php

namespace App\Controllers;

use App\Helpers\RoleHelper;
use App\Models\User;

class UserController extends BaseController
{
    private function _params(array $params = [])
    {
        return [
            'isEdit' => $params['isEdit'] ?? false,
            'isDetail' => $params['isDetail'] ?? false,
            'roleList' => $params['roleList'] ?? RoleHelper::ROLE_LIST,
            'user' => $params['user'] ?? null
        ];
    }

    private function _validation($isEdit = false, $id = null)
    {
        $validation = [
            'name' => 'required',
            'password' => 'required',
            'email' => $isEdit ? "required|valid_email|is_unique[users.email,id,$id]" : "required|valid_email|is_unique[users.email]",
            'role' => 'required'
        ];

        if ($isEdit)
            unset($validation['password']);


        return $this->validate($validation);
    }

    private function _inputtedEmail()
    {
        return preg_replace('/\s+/', '', strtolower($this->request->getVar('email')));
    }

    private function _getUser($id)
    {
        $user = new User();
        return $user->where('id', $id)->first();
    }

    public function index()
    {
        $user = new User();
        $users = $user->orderBy('created_at', 'desc')->where('id !=', session()->get('id'))->paginate(10);
        $pagination = $user->pager;

        return view('master/users/index', [
            'users' => $users,
            'pagination' => $pagination
        ]);
    }

    public function create()
    {
        return view('master/users/create_edit', $this->_params());
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


        $user = new User;

        // Check if email exists
        $isEmailExists = $user->where('email', $this->_inputtedEmail())->first();
        if ($isEmailExists) {
            session()->setFlashdata('error', "Email already exists");
            return redirect()->back()->withInput();
        }

        $user->insert([
            'name' => $this->request->getVar('name'),
            'email' => $this->_inputtedEmail(),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getVar('role'),
        ]);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to create user');
            return redirect()->back()->withInput();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'User created successfully');
        return redirect()->to(base_url('master/users'));
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
<?php

namespace App\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    private function _validation($isEdit = false)
    {
        return $this->validate([
            'name' => 'required',
            'password' => !$isEdit ? 'required' : '',
            'role' => 'required'
        ]);
    }

    public function index()
    {
        $user = new User();
        $users = $user->orderBy('created_at', 'desc')->paginate(10);
        $pagination = $user->pager;

        return view('master/users/index', [
            'users' => $users,
            'pagination' => $pagination
        ]);
    }

    public function create()
    {
        return view('master/users/create_edit', [
            'isEdit' => false
        ]);
    }

    public function store()
    {
        $db = db_connect();
        $db->transBegin();

        $validation = $this->_validation();
        if ($validation) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back();
        }

        $user = new User;
        $user->insert([
            'name' => $this->request->getVar('name'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
            'role' => $this->request->getVar('role'),
        ]);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to create user');
            return redirect()->back();
        }

        $db->transCommit();
        session()->setFlashdata('success', 'User created successfully');
        return redirect()->to(base_url('master/users'));
    }

    public function show()
    {
        return view('master/users/create_edit', [
            'isDetail' => true
        ]);
    }

    public function edit()
    {
        return view('master/users/create_edit', [
            'isEdit' => true
        ]);
    }

    public function update($id)
    {
        $db = db_connect();
        $db->transBegin();

        $validation = $this->_validation(true);
        if ($validation) {
            session()->setFlashdata('error', $this->validator->listErrors());
            return redirect()->back();
        }

        $user = new User;
        $user->update($id, [
            'name' => $this->request->getVar('name'),
            'role' => $this->request->getVar('role'),
        ]);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to update user');
            return redirect()->back();
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
        $user->delete($id);

        // Check for error in transaction
        if (!$db->transStatus()) {
            $db->transRollback();
            session()->setFlashdata('error', 'Something went wrong when start to delete user');
        }

        $db->transCommit();
        session()->setFlashdata('success', 'User deleted successfully');
        return redirect()->to(base_url('master/users'));
    }
}
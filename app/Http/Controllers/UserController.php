<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Common\BaseController;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    protected $_model;

    public function __construct()
    {
        $this->_model = new User;
    }

    public function index()
    {
        return view('user.index')->with('AJAX_PATH', 'get-users');
    }

    public function getUser()
    {
        return $this->_model->getUserList();
    }

    public function create()
    {
        $getGender = $this->_model->getGender();
        $getSuffix = $this->_model->getSuffix();
        return view('user.create')->with(compact('getGender','getSuffix'));
    }

    public function store(Request $request)
    {
        return $this->_model->createUserRecord($request);
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $user = $this->_model->loadModel($id);
        $getGender = $this->_model->getGender();
        $getSuffix = $this->_model->getSuffix();
        return view('user.create')->with(compact('user','getSuffix','getGender'));
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id' => $id]);
        return $this->_model->createUserRecord($request);
    }

    public function destroy($id)
    {
        return $this->_model->removed($id);
    }

    public function userChangeStatus($id)
    {
        $user = $this->_model->loadModel($id);
        if (!empty($user->status) && $user->status == 1) {
            $user->update(['status' => '0']);
            return $this->webResponse('User has been in-active successfully.');
        } else {
            $user->update(['status' => '1']);
            return $this->webResponse('User has been active successfully.');
        }
    }

    public function providerApprovalStatusUpdate($id)
    {
        $user = $this->_model->loadModel($id);
        if (!empty($user->is_approve) && $user->is_approve == 1) {
            $user->update(['is_approve' => '0']);
            return $this->webResponse('Provider has been reject successfully.');
        } else {
            $user->update(['is_approve' => '1']);
            return $this->webResponse('Provider has been approve successfully.');
        }
    }
}

<?php
namespace App\Http\Controllers\System;

use Illuminate\Http\Request;
use App\Http\Controllers\KcBaseController;


class AdminUserController extends KcBaseController
{

    public function index()
    {
        return view('adminUser.index');
    }

    public function add()
    {
        $role_list = $this->_roleService->roleList();
        return view('adminUser.add', compact('role_list'));
    }

    public function edit($id)
    {
        $id = (int)$id;

        $adminUser = $this->_adminUserService->adminData($id);
        if(empty($adminUser)){
            return $this->tool->response(['status'=>0, 'msg'=>trans('user.admin_user_not_exists')], 'adminuser');
        }
        //角色列表
        $role_list = $this->_roleService->roleList();
        //role_ids
        $admin_role_ids = array_column($this->_adminUserService->adminRoles($adminUser)->toArray(), 'id');

        return view('adminUser.edit',compact('id','role_list', 'adminUser', 'admin_role_ids'));
    }

    public function show($id){
        $id = (int)$id;

        $adminUser = $this->_adminUserService->adminData($id);
        if(empty($adminUser)){
            return $this->tool->response(['status'=>0, 'msg'=>trans('user.admin_user_not_exists')], 'adminuser');
        }
        //角色列表
        $role_list = $this->_roleService->roleList();
        //role_ids
        $admin_role_ids = array_column($this->_adminUserService->adminRoles($adminUser)->toArray(), 'id');

        return view('adminUser.show',compact('id','role_list', 'adminUser', 'admin_role_ids'));
    }
}
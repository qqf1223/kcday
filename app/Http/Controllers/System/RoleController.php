<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\KcBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class RoleController extends KcBaseController
{

    public function index(Request $request)
    {
        return view('role.index');
    }

    public function add()
    {
        return view('role.add');
    }

    public function edit($id)
    {
        $id = (int)$id;

        $role = $this->_roleService->roleData($id);
        if(empty($role)){
            return $this->tool->response(['status'=>0, 'msg'=>trans('role_not_exists')], 'role');
        }
        return view('role.edit', compact('role'));
    }

    public function show($id)
    {
        $id = (int)$id;

        $role = $this->_roleService->roleData($id);
        if(empty($role)){
            return $this->tool->response(['status'=>0, 'msg'=>trans('role_not_exists')], 'role');
        }

        return view('role.show', compact('role'));
    }

    public function auth($role_id)
    {
        $role_id = (int)$role_id;
        $role = $this->_roleService->roleData($role_id);

        if(empty($role)){
            return $this->tool->response(['status'=>0, 'msg'=>trans('role_not_exists')], 'role');
        }
        //角色对应的权限
        $role_perms = $this->_roleService->rolePermissions($role)->toArray();
        $permission_list = $this->_roleService->treePermissions();

        //所属模块
        $module_list = $this->_permissionService->getModuleList();

        $role_perms_ids = !empty($role_perms) ? array_column($role_perms, 'id') : [];
        return view('role.auth', compact('role', 'role_perms', 'permission_list', 'role_perms_ids', 'module_list'));
    }
}
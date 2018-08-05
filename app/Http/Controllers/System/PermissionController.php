<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\KcBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PermissionController extends KcBaseController
{
    /**
     * 权限列表
     * @param int $pid
     * @return View
     */
    public function index($pid = 0)
    {
        $pid = (int)$pid;

        $parent_permission = null;
        if(isset($pid)) $parent_permission = $this->_permissionService->permissionData($pid);

        return view('permission.index', compact('pid', 'parent_permission'));
    }

    /**
     * 权限添加
     * @param int $pid
     * @return View
     */
    public function add($pid = 0)
    {
        $pid = (int)$pid;

        $parent_permission = null;
        if($pid) $parent_permission = $this->_permissionService->permissionData($pid);

        //所属模块
        $module_list = $this->_permissionService->getModuleList();

        return view('permission.add', compact('pid', 'parent_permission', 'module_list'));
    }

    /**
     * 权限编辑
     * @param int $id
     * @return View
     */
    public function edit($id = 0)
    {
        $id = (int)$id;
        $permission = $this->_permissionService->permissionData($id);
        if(empty($permission)){
            return $this->tool->response(['status' => 0, 'msg' => trans('system.permission_not_exist')], '/permission/index');
        }

        $pid = $permission->pid;
        $parent_permission = null;
        if($permission->pid) $parent_permission = $this->_permissionService->permissionData($pid);
        //所属模块
        $module_list = $this->_permissionService->getModuleList();

        return view('permission.edit', compact('permission', 'pid', 'parent_permission', 'module_list'));
    }



}
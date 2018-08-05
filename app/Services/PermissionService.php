<?php

namespace App\Services;

use App\Services\KcService;
use App\Models\PermissionModel;
use DB;

class PermissionService extends KcService
{
    use DataTableService;

    protected $permissionModel;

    public function __construct(PermissionModel $permissionModel)
    {
        $this->permissionModel = $permissionModel;
    }

    public function permissionData($id)
    {
        DB::enableQueryLog();
        $res = $this->permissionModel->find($id);
        $query = DB::getQueryLog();
        return $res;
    }

    public function createPermission($form_data)
    {
        $form_data['ctime'] = time();
        foreach($form_data as $k=>$v){
            $this->permissionModel->$k = $v;
        }
        $res = $this->permissionModel->save();

        if(!$res){
            return $this->handleError(trans('common.op_failure'));
        }
        return $this->handleSuccess(trans('common.op_success'));
    }


    public function updatePermission($id, $form_data)
    {
        $permission = $this->permissionData($id);
        if(empty($permission)){
            return $this->handleError(trans('system.permission_not_exist'));
        }

        $form_data['is_menu'] = !isset($form_data['is_menu']) ? 0 : (int)$form_data['is_menu'];
        $form_data['pid'] = (int)$form_data['pid'];
        $res = $this->permissionModel->where('id', $id)->update($form_data);

//        if(!$res) return $this->handleError(trans('common.op_save_failure'));

        return $this->handleSuccess(trans('common.op_save_success'));

    }

    public function deletePermission($id)
    {
        $permission = $this->permissionData($id);
        if(empty($permission)) return $this->handleError(trans('system.permission_not_exist'));

        //验证是否有子权限
        $sub = $this->permissionModel->where('pid', $id)->first();
        if(!empty($sub)){
            return $this->handleError(trans('system.first_del_sub_permission'));
        }

        $res = $permission->delete();
        if(!$res) return $this->handleError(trans('common.op_delete_failure'));

        //记录事件 todo
        return $this->handleSuccess(trans('common.op_delete_success'));
    }

    public function getModuleList(){
        $res = config('kc_admin.module_menu');
        $res = array_column($res, null, 'id');
        return $res;
    }
}
<?php

namespace App\Services;

use App\Services\KcService;
use App\Models\RoleModel;
use App\Models\PermissionModel;
use DB;

class RoleService extends KcService
{
    use DataTableService;

    protected $roleModel;

    public function __construct(RoleModel $roleModel)
    {
        $this->roleModel = $roleModel;
    }

    public function roleData($id)
    {
        return $this->roleModel->find($id);
    }

    public function createRole($form_data)
    {
        $form_data['ctime'] = time();
        foreach($form_data as $k => $v){
            $this->roleModel->$k = $v;
        }
        $res = $this->roleModel->save();

        if(!$res){
            return $this->handleError(trans('common.op_save_failure'));
        }
        return $this->handleSuccess(trans('common.op_save_success'));
    }


    public function updateRole($id, $form_data)
    {
        $roleData = $this->roleData($id);
        if(empty($roleData)) return $this->handleError(trans('role.role_not_exists'));

        $res = $this->roleModel->where('id', $id)->update($form_data);

        return $this->handleSuccess(trans('common.op_update_success'));
    }

    public function deleteRole($id)
    {
        $id = (int)$id;
        $roleData = $this->roleData($id);
        if(empty($roleData)) return $this->handleError(trans('role.role_not_exists'));

        $res = $roleData->delete();
        if(!$res) return $this->handleError(trans('common.op_delete_failure'));

        //删除授权数据 //todo
        foreach($roleData->permissions as $v){
            $roleData->permissions()->detach($v);
        }
        return $this->handleSuccess(trans('common.op_delete_success'));
    }

    public function rolePermissions($role)
    {
        return $role->permissions()->get();
    }

    public function treePermissions()
    {
        $return_data = [];
        $fields = ['*'];
        $list = PermissionModel::select($fields)->orderBy('sort', 'ASC')->get();
        if(!empty($list)){
            $list = $list->toArray();
            $result = getTreeData($list, 'id', 'pid', 'name');
            if(!empty($result)){
                foreach($result as $val){
                    $return_data[$val['module']][] = $val;
                }
            }
        }

        return $return_data;
    }

    public function auth($role_id, $perm_ids)
    {
        $role = $this->roleData($role_id);
        if(empty($role)){
            return $this->handleError(trans('role.role_not_exists'));
        }
        $role->authorizePermissions($perm_ids);
        //todo 记录事件
        return $this->handleSuccess(trans('role.authorization_success'));
    }

    public function roleList()
    {
        return $this->roleModel->select(['id', 'name'])->get();
    }
}
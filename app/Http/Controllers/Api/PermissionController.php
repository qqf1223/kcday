<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\KcApiController;
use App\Http\Requests\PermissionRequest;
use App\Http\Requests\PermissionEditRequest;
use App\Services\UserServices;
use Illuminate\Http\Request;

class PermissionController extends KcApiController
{

    public function index(Request $request, $pid = 0)
    {
        $pid = (int)$pid;
        $params = $request->all();

        $fields = ['id', 'name', 'rule', 'remark', 'sort', 'pid', 'icon', 'is_menu', 'mtime', 'status'];
        $res = $this->_permissionService->dataTable(\App\Models\PermissionModel::class, $fields, $params, [
            'condition' => [
                [
                    'where',
                    ['where', 'pid = ' . $pid]
                ],
                [
                    'where',
                    ['where', 'name like %?%'],
                    ['orWhere', 'rule like %?%']
                ]
            ]
        ]);
        return $this->tool->response($res, true, 'json');
    }

    public function save(PermissionRequest $request)
    {
        $form_data = $request->except(['_token', '_method']);

        $result = $this->_permissionService->createPermission($form_data);

        $pid = isset($form_data['pid']) ? (int)$form_data['pid'] : 0;


        return $this->tool->response($result, null, 'json');
    }


    public function update($id, PermissionEditRequest $request)
    {
        $id = (int)$id;
        $form_data = $request->except(['_token', '_method']);

        $result = $this->_permissionService->updatePermission($id, $form_data);

        return $this->tool->response($result, null, 'json');
    }


    public function delete($id = 0)
    {
        $id = (int)$id;

        $result = $this->_permissionService->deletePermission($id);

        return $this->tool->response($result, null, 'json');
    }
}
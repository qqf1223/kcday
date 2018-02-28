<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\KcApiController;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\RoleEditRequest;
use App\Services\UserServices;
use Illuminate\Http\Request;

class RoleController extends KcApiController
{

    public function index(Request $request)
    {
        $params = $request->all();

        $fields = ['id', 'name', 'description', 'mtime', 'status'];
        $result = $this->_roleService->dataTable(\App\Models\RoleModel::class, $fields, $params, [
            'condition' => [
                [
                    'where',
                    ['where', 'name like %?%']
                ]
            ]
        ]);
        return $this->tool->response($result, true, 'json');
    }

    public function save(RoleRequest $request)
    {
        $form_data = $request->except(['_token', '_method']);

        $result = $this->_roleService->createRole($form_data);

        return $this->tool->response($result, null, 'json');
    }


    public function update($id, RoleEditRequest $request)
    {
        $id = (int)$id;

        $form_data = $request->except(['_token', 'method']);

        $result = $result = $this->_roleService->updateRole($id,$form_data);

        return $this->tool->response($result, null, 'json');
    }

    public function delete($id = 0)
    {
        $id = (int)$id;

        $result = $this->_roleService->deleteRole($id);

        return $this->tool->response($result, null, 'json');
    }

    public function auth($id, Request $request)
    {
        $id = (int)$id;
        $perm_ids = $request->input('perm_ids');

        $result = $this->_roleService->auth($id, $perm_ids);

        return $this->tool->response($result, 'role/');
    }
}
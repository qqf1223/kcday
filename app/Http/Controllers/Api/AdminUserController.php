<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\KcApiController;
use App\Services\AdminUserService;
use App\Services\ImageService;
use App\Http\Requests\AdminUserCreateRequest;
use App\Http\Requests\AdminUserEditRequest;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class AdminUserController extends KcApiController
{

    public function index(Request $request)
    {
        $params = $request->all();

        $fields = ['id', 'emp_name', 'dept_id', 'gender', 'mobile', 'email', 'mtime'];
        $result = $this->_roleService->dataTable(\App\Models\AdminUsersModel::class, $fields, $params, [
            'condition' => [
                [
                    'where',
                    ['where', 'emp_name like %?%']
                ]
            ]
        ]);
        return $this->tool->response($result, true, 'json');
    }

    /**
     * 创建管理员
     * @param AdminUserCreateRequest $request
     * @return mixed
     */
    public function createAdmin(AdminUserCreateRequest $request)
    {
        $form_data = $request->except(['_token', '_method']);

        $result = $this->_adminUserService->createAdmin($form_data);

        return $this->tool->response($result, null, 'json');
    }

    /**
     * 编辑管理员
     * @param AdminUserCreateRequest $request
     * @return mixed
     */
    public function editAdmin($id, AdminUserEditRequest $request)
    {
        $id = (int)$id;
        $form_data = $request->except(['_token', '_method']);

        $result = $this->_adminUserService->editAdmin($id,$form_data);

        return $this->tool->response($result, null, 'json');
    }

    /**
     * 头像处理
     * @param Request $request
     * @param ImageService $imageService
     * @return mixed
     */
    public function avatar(Request $request, ImageService $imageService)
    {
        $form_data = $request->except(['_token', '_method']);
        $avatar_data = !empty($form_data['avatar_data']) ? json_decode($form_data['avatar_data']) : null;

        $file = $form_data['avatar_file'];
        $result = $imageService->uploadAvatar($file, $avatar_data);

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

        $result = $this->_adminUserService->delUser($id);

        return $this->tool->response($result, null, 'json');
    }

}
<?php

namespace App\Services;

use App\Services\KcService;
use App\Models\AdminUsersModel;
use Auth;
use DB;
use Illuminate\Support\Facades\Event;

class AdminUserService extends KcService
{
    private $adminUsers;

    public function __construct(AdminUsersModel $users)
    {
        $this->adminUsers = $users;
    }

    /**
     * 登录
     * @param $request
     * @return array
     */
    public function login($request)
    {
        $form_data = $request->except('_token', 'captcha');
        $user = $form_data['username'];
        unset($form_data['username']);
        unset($form_data['remember']);
        if(isEmail($user)){
            $form_data['email'] = $user;
            $res = Auth::guard('admin')->attempt($form_data, $request->has('remember'));
        }else{
            $form_data['mobile'] = $user;
            $res = Auth::guard('admin')->attempt($form_data, $request->has('remember'));
        }

        if(!$res){
            return $this->handleError('用户名或密码不正确!', 'password');
        }
        //session 重新生成Session ID
        $request->session()->regenerate();

        return $this->handleSuccess('登录成功, 欢迎 ' . $this->loggedUser()->emp_name . '!');
    }

    /**
     * 登出
     * @return array
     */
    public function logout()
    {
        Auth::guard('admin')->logout();

        request()->session()->flush();

        request()->session()->regenerate();

        return $this->handleSuccess('退出成功');
    }

    public function loggedUser()
    {
        return Auth::guard('admin')->user();
    }

    /**
     * 获取管理员信息
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function adminData($id)
    {
        return $this->adminUsers->find($id);
    }

    /**
     * 用户角色
     * @param $adminUser
     * @return mixed
     */
    public function adminRoles($adminUser)
    {
        return $adminUser->roles()->get();
    }

    /**
     * 创建管理员
     * @param $form_data
     * @return array
     */
    public function createAdmin($form_data)
    {
        //绑定角色
        $role_ids = [];
        if(!empty($form_data['role_ids'])){
            $role_ids = $form_data['role_ids'];
            unset($form_data['role_ids']);
        }
        if(empty($form_data['telephone'])){
            $form_data['telephone'] = '';
        }
        //头像
        if(empty($form_data['avatar'])){
            $form_data['avatar'] = $form_data['telephone'] = '';
        }

        //加密密码
        if($form_data['password'] !== $form_data['confirmPass']){
            return $this->handleError('请确认两次填写密码一致');
        }
        unset($form_data['confirmPass']);
        $form_data['password'] = bcrypt($form_data['password']);
        $form_data['ctime'] = time();

        //创建账号
        foreach($form_data as $k => $v){
            $this->adminUsers->$k = $v;
        }
        $res = $this->adminUsers->save();

        if(!$res) return $this->handleError(trans('common.op_failure'));

        //授权角色
        $this->adminUsers->authorizeRoles((array)$role_ids);

        //触发事件

        //创建结果
        return $this->handleSuccess(trans('common.op_success'));

    }

    /**
     * 编辑管理员
     * @param $id
     * @param $form_data
     * @return array
     */
    public function editAdmin($id, $form_data)
    {
        //绑定角色
        $role_ids = [];
        if(!empty($form_data['role_ids'])){
            $role_ids = $form_data['role_ids'];
            unset($form_data['role_ids']);
        }

        if(empty($form_data['telephone'])){
            $form_data['telephone'] = '';
        }
        //头像
        if(empty($form_data['avatar'])){
            $form_data['avatar'] = '';
        }

        if(empty($form_data['password'])){
            unset($form_data['confirmPass'], $form_data['password']);
        }else{
            //加密密码
            if($form_data['password'] !== $form_data['confirmPass']){
                return $this->handleError('请确认两次填写密码一致');
            }
            unset($form_data['confirmPass']);
            $form_data['password'] = bcrypt($form_data['password']);
        }

        //更新数据
        $form_data['mtime'] = date('Y-m-d H:i:s', time());
        $res = $this->adminUsers->where('id', $id)->update($form_data);
        if(!$res) return $this->handleError(trans('common.op_failure'));


        //授权角色
        $this->adminUsers->authorizeRoles((array)$role_ids);

        //触发事件
//        Event::fire();
        //创建结果
        return $this->handleSuccess(trans('common.op_success'));

    }

    /**
     * 删除管理员
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function delUser($id)
    {
        $admin = $this->adminData($id);
        //验证
        if(empty($admin)){
            return $this->handleError(trans('permission.permission_not_exist'));
        } else if($admin->id == 1){
            return $this->handleError('超级管理员不能删除!');
        }

        $res = $admin->delete();
        if(!$res) return $this->handleError(trans('common.op_delete_failure'));

        //记录事件 todo
        return $this->handleSuccess(trans('common.op_delete_success'));
    }
}
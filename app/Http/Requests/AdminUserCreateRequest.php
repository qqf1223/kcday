<?php
/**
 * Created by PhpStorm.
 * User: qinqinfeng
 * Date: 17/8/18
 * Time: 上午11:27
 */

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AdminUserCreateRequest extends FormRequest
{
    use KcAdminRequest;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = (int)substr($this->getPathInfo(), strrpos($this->getPathInfo(), '/')+1);
        return [
//            'username' => 'required|max:50|unique:admin_users',
//            'emp_no' => 'required|max:50|unique:admin_users',
            'emp_name' => 'required|max:50|unique:users',
            'mobile' => 'required|mobile|max:11|unique:admin_users',
            'email' => 'required|email|max:30|unique:admin_users',

//            'dept_id' => 'required|integer',
            'password' => 'required|max:20',
            'confirmPass' => 'required|max:20',
        ];
    }


    public function messages()
    {
        return [
//            'username.required' => '请填写用户名',
//            'emp_no' => '请填写工号',
            'username.max' => '用户名过长',
            'username.unique' => '用户名已存在',
            'emp_name.required' => '请填写真实姓名',
            'emp_name.max' => '真实姓名过长',
            'emp_name.unique' => '真实姓名过长',
            'email.required' => '请填写邮箱',
            'email.email' => '邮箱格式不正确',
            'email.max' => '邮箱过长',
            'email.unique' => '邮箱已存在',
            'mobile.required' => '请填写手机号',
            'mobile.mobile' => '手机号格式不正确',
            'mobile.max' => '手机号过长',
            'mobile.unique' => '手机号已存在',
//            'dept_id.required' => '请选择部门',
//            'dept_id.int' => '部门选择错误',
            'password.required' => '请填写密码',
            'password.max' => '密码过长',
            'confirmPass.required' => '请填写确认密码',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleEditRequest extends FormRequest
{
    use KcAdminRequest;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = substr($this->getPathInfo(), strrpos($this->getPathInfo(), '/') + 1);
        return [
            'name' => 'required|unique:roles,name,'.$id.'|max:255|not_in:超级管理员',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请填写角色名称',
            'name.unique' => '该角色已存在',
            'name.max' => '角色名称过长',
            'name.not_in' => '角色名不能是超级管理员',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionEditRequest extends FormRequest
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
            'name' => 'required|max:255',
            'rule' => 'required|unique:permission,rule,'.$id.'|max:255',
            'sort' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请填写权限名称',
            'name.max' => '权限名称过长',
            'rule.required' => '请填写规则',
            'rule.unique' => '规则已存在',
            'rule.max' => '规则过长',
            'sort.int' => '排序需为整数',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    use KcAdminRequest;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'rule' => 'required|unique:permission|max:255',
            'pid' => 'required|int',
            'sort' => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '请填写权限名称',
            'name.max' => '规则名称过长',
            'rule.required' => '请填写规则',
            'rule.unique' => '规则已存在',
            'rule.max' => '规则过长',
            'pid.required' => '请选择所属权限',
            'pid.int' => '所属权限有误',
            'sort.int' => '排序需为整数',
        ];
    }
}
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use KcAdminRequest;

    protected $dontFlash = ['password'];

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username' => 'required',
            'password' => 'required',
            //'captcha' => 'required|regex:/^('.strtolower($this->session()->get('admin_login_captcha')).')$/'
        ];
    }

    public function messages()
    {
        return [
            'username.required' => '请填写用户名或邮箱',
            'password.required' => '请填写密码',
            //'captcha.required' => '请填写验证码',
            //'captcha.regex' => '验证码不正确',
        ];
    }
}
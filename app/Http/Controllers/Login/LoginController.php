<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\KcBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LoginController extends KcBaseController
{
    //初始化
    protected function _init()
    {
        //设置中间件
        $this->middleware('guest:admin', ['except' => 'logout']);
    }

    public function index(Request $request)
    {
        return view('auth.login');
    }

    public function logout()
    {
        $result = $this->_adminUserService->logout();

        return $this->tool->response($result, '/login');
    }
}
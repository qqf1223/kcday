<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\KcApiController;
use App\Http\Requests\LoginRequest;

class LoginController extends KcApiController
{
    //初始化
    protected function _init()
    {
        $this->middleware('guest:admin',['except' => 'logout']);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->_adminUserService->login($request);

        return $this->tool->setType('json')->response($result);
    }
}
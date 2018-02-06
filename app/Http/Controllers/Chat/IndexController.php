<?php

namespace App\Http\Controllers\Chat;

use App\Http\Controllers\KcBaseController;

class IndexController extends KcBaseController
{
    public function test()
    {
        echo $_SERVER['SERVER_ADDR'];
        return view('dchat.index');
    }
}
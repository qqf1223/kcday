<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\KcBaseController;

class IndexController extends KcBaseController
{
    public function index()
    {
        return view('home.index');
    }
}
<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SysController extends Controller
{
    public $viewData = [];

    public function __construct(Request $request)
    {

    }

    public function index()
    {
        return view('setting.index', array('viewData' => $this->viewData));
    }


    public function save(Request $request){
        var_dump(11);die;
        return view('setting.index', array('viewData' => $this->viewData));
    }
}
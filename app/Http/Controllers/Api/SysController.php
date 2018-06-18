<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\KcApiController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SysController extends KcApiController
{
    public $viewData = [];

    public function __construct(Request $request)
    {

    }

    public function index(){

    }

    public function save(Request $request){
        dd(11);die;
        return view('setting.index', array('viewData' => $this->viewData));
    }
}
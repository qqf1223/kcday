<?php
/**
 * Created by PhpStorm.
 * User: qinqinfeng
 * Date: 2018/7/7
 * Time: 下午3:17
 */

namespace App\Http\Controllers\System;


use App\Http\Controllers\KcBaseController;

class DepartmentController extends KcBaseController
{
    public function index()
    {
        return view('department.index');
    }

    public function add()
    {
        return view('department.add');
    }

    public function edit($id)
    {

        return view('department.edit', compact('department'));
    }
}
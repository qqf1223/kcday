@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <div class="box-body no-padding">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-4 col-md-4 control-label" for="emp_name"><span
                                        class="text-danger">*</span>
                                真实姓名：</label>
                            <div class="col-sm-4 col-md-4">
                                <input  type="text" class="form-control" value="{{ $adminUser->emp_name }}" disabled/>
                            </div>
                        </div>


                        <div class="form-group">
                            <label for="mobile" class="col-sm-4 col-md-4 control-label"><span
                                        class="text-danger">*</span>
                                手机号：</label>
                            <div class="col-sm-4 col-md-4">
                                <input type="text" class="form-control" value="{{ $adminUser->mobile }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telephone" class="col-sm-4 col-md-4 control-label">电话：</label>
                            <div class="col-sm-4 col-md-4">
                                <input type="text" class="form-control" value="{{ $adminUser->telephone  }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 col-md-4 control-label" for="gender"> 性别：</label>
                            <div class="col-sm-4 col-md-4">
                                <label class="radio-inline">
                                    <input type="radio"  value="1" @if($adminUser->gender == 1) checked="checked" @endif disabled>男
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" value="2" @if($adminUser->gender == 2) checked="checked" @endif disabled>女
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-sm-4 col-md-4 control-label"><span
                                        class="text-danger">*</span>
                                Email：</label>
                            <div class="col-sm-4 col-md-4">
                                <input id="email" type="text" class="form-control" name="email"
                                       value="{{ $adminUser->email }}" disabled/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 col-md-4 control-label" for="dept_id"><span
                                        class="text-danger">*</span>
                                部门：</label>
                            <div class="col-sm-4 col-md-4">
                                <select class="form-control" name="dept_id" id="dept_id" disabled>
                                    <option value="0">请选择所属部门</option>
                                </select>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-md-4 control-label" for="role_id">角色：</label>
                            <div class="col-sm-4 col-md-4">
                                @foreach($role_list as $val)
                                    <input type="checkbox" name="role_ids[]" value="{{ $val['id'] }}"
                                           @if(in_array($val['id'], $admin_role_ids)) checked="checked" @endif disabled/> {{ $val['name'] }}
                                @endforeach
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="avatar" class="col-sm-4 col-md-4 control-label">头像:</label>
                            <div class="col-sm-4 col-md-4" id="crop-avatar">
                                <img width="30" height="30"
                                     src="@if(!empty($adminUser->avatar)) {{ asset('/avatar/' . $adminUser->avatar) }} @else {{ '/images/avatar.png' }} @endif"/>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 col-md-4 control-label" for="is_del">状态：</label>
                            <div class="col-sm-4 col-md-4">
                                <label class="radio-inline">
                                    <input type="radio" name="is_del" value="0" checked="checked"
                                           @if(($adminUser->is_del == 0) || (old('is_del') == 0)) checked="checked" @endif disabled>
                                    正常
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" name="is_del" value="1"
                                           @if(($adminUser->is_del == 1) || (old('is_del') == 1)) checked="checked" @endif disabled>
                                    禁用
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('adminUser.avatar')
@stop
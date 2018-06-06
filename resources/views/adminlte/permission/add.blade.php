@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h5 class="pull-left">{{ trans('permission.add_permission') }}</h5>
                </div>
                <div class="box-body no-padding">
                    <form class="form-horizontal" id="permissionForm" action="add">
                        <div class="form-group">
                            <label for="name" class="col-sm-4 col-md-4 control-label">所属权限：</label>
                            <div class="col-sm-4 col-md-4">
                                <p class="form-control-static">{{ $pid ? (isset($parent_permission->name) ?  $parent_permission->name : '') : '顶级权限' }}</p>
                            </div>
                        </div>
                        @include('permission._form', ['formType' => 'add'])

                        <div class="form-group">
                            <div class="col-sm-2 col-md-3"></div>
                            <div class="col-sm-5 col-md-5 text-center">
                                <button class="btn btn-primary" type="button" id="permissionSubmit"
                                        data-url="{{ url('api/permission/save') . '/' . $pid }}">保存
                                </button>
                                {{--<button class="btn btn-primary" type="button" id="permissionSubmitNext" data-url="/add">保存并新建</button>--}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

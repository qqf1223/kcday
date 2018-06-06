@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h5 class="pull-left">{{ trans('permission.edit_permission') }}</h5>
                </div>
                <div class="box-body no-padding">
                    <form class="form-horizontal" id="roleForm" action="##">

                        @include('role._form', ['formType' => 'edit'])

                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-5 text-center">
                                <button class="btn btn-primary" type="button" id="roleSubmit" data-url="{{ url('api/role/update') . '/' . $role->id }}">
                                    {{ trans('common.save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
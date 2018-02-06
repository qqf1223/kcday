@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <div class="box-body no-padding">
                    <form class="form-horizontal" id="adminUserForm" action="add">
                        @include('adminUser._form', ['formType' => 'add'])
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-5 text-center">
                                <button class="btn btn-primary" type="button" id="adminUserSubmit" data-url="{{ url('api/adminUser/add') }}">{{ trans('common.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('adminUser.avatar')
@stop
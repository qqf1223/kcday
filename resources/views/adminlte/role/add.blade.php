@extends('layouts.main')
@section('content')
<div class="row formcontainer">
    <form class="form-horizontal" id="roleForm">
        @include('role._form', ['formType' => 'add'])

        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-5 text-center">
                <button class="btn btn-primary" type="button" id="roleSubmit" data-url="{{ url('api/role/save') }}">{{ trans('common.save') }}</button>
            </div>
        </div>
    </form>
</div>
@stop
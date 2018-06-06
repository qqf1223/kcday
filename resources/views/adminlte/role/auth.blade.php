@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <div class="box-title">
                        {{ trans('role.auth') }} ：{{$role->name}}
                    </div>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-primary" onclick="location.href='{{ url('role') }}'">
                            <span class="fa fa-reply"></span> {{ trans('common.go_back') }}
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <form class="form-horizontal"  method="POST" id="authform">
                        <input type="hidden" name="_method" value="PUT">
                        {{csrf_field()}}
                        <table class="table table-striped">
                            <tr>
                                <th class="col-md-2" rows="2">模块</th>
                                <th class="col-md-7">权限</th>
                            </tr>

                            @foreach($permission_list as $k => $val)
                                <tr>
                                    <td>{{ isset($module_list[$k]['name']) ? $module_list[$k]['name'] : ''  }}</td>
                                    <td>
                                        @foreach($val as $v)
                                            <span class="col-md-3"><input type="checkbox" value="{{ $v['id'] }}" name="perm_ids[]" @if(in_array($v['id'], $role_perms_ids)) checked="checked" @endif />{{ $v['name'] }}</span>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="form-group">
                            <div class="col-sm-2"></div>
                            <div class="col-sm-5 text-center">
                                <button class="btn btn-primary" type="button" data-url="{{ url('api/role/auth') . '/' . $role->id }}" id="save">{{ trans('common.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script type="text/javascript" src="{{ asset('/js/default/role.js') }}"></script>
@stop
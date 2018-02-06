{{ csrf_field() }}
<input type="hidden" value="{{ $pid }}" name="pid" />
<div class="form-group">
    <label for="name" class="col-sm-4 col-md-4 control-label">权限名称：</label>
    <div class="col-sm-4 col-md-4">
        <input id="name" type="text" class="form-control" name="name" value="{{ $formType == 'edit' && !old('name') ? $permission->name : old('name') }}" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 col-md-4 control-label" for="module">所属模块：</label>
    <div class="col-sm-4 col-md-4">
        <select class="form-control" name="module" id="module">
        <option value="0">请选择</option>
        @foreach($module_list as $k => $val)
        <option value="{{ $val['id'] }}" {{ $formType == 'edit' && !empty($permission->module) && $permission->module == $val['id'] ? 'selected="selected"' : '' }}>{{ $val['name'] }}</option>
        @endforeach
        </select>
    </div>
</div>
<div class="form-group">
    <label for="rule" class="col-sm-4 col-md-4 control-label">权限规则：</label>
    <div class="col-sm-4 col-md-4">
        <input id="rule" type="text" class="form-control" name="rule" value="{{ $formType == 'edit' && !old('rule') ? $permission->rule : old('rule') }}" />
    </div>
</div>

<div class="form-group">
    <label class="col-sm-4 col-md-4 control-label" for="remark">描述：</label>
    <div class="col-sm-4 col-md-4">
        <textarea class="form-control"  rows="4" cols="16" name="remark" id="remark">{{ $formType == 'edit' && !old('remark') ? $permission->remark : old('remark') }}</textarea>
    </div>
</div>
<div class="form-group">
    <label for="tag" class="col-sm-4 col-md-4 control-label">ICON图</label>
    <div class="col-sm-4 col-md-4">
        <button id="tag" class="btn btn-default" name="icon" data-iconset="fontawesome" data-icon="{{ $formType == 'edit' && !old('icon') ?  $permission->icon : old('icon') }}" role="iconpicker"></button>
    </div>
</div>
<div class="form-group">
    <label for="sort" class="col-sm-4 col-md-4 control-label">排序：</label>
    <div class="col-sm-4 col-md-4">
        <input id="sort" type="text" class="form-control" name="sort" value="{{ $formType == 'edit' && !old('sort') ? $permission->sort : (!old('sort') ? 0 : old('sort') ) }}" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 col-md-4 control-label" for="is_menu">是否菜单：</label>
    <div class="col-sm-4 col-md-4">
        <label class="checkbox-inline">
            <input type="checkbox" name="is_menu" value="1" @if(($formType == 'edit' && $permission->is_menu == 1) || (is_numeric(old('is_menu')) && old('is_menu') == 1)) checked="checked" @endif >
        </label>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-4 col-md-4 control-label" for="status">状态：</label>
    <div class="col-sm-4">
        <label class="radio-inline">
            <input type="radio" name="status" value="0"  @if(($formType == 'edit' && $permission->status == 0) || (old('status') == 0)) checked="checked" @endif> 正常
        </label>
        <label class="radio-inline">
            <input type="radio" name="status" value="1" @if(($formType == 'edit' && $permission->status == 1) || (is_numeric(old('status')) && old('status') == 1)) checked="checked" @endif> 禁用
        </label>
    </div>
</div>
@section('css')
    <link href="{{ '/bower_components/bootstrap-iconpicker/icon-fonts/font-awesome-4.2.0/css/font-awesome.min.css' }}" rel="stylesheet" />
    <link href="{{ '/bower_components/bootstrap-iconpicker/bootstrap-iconpicker/css/bootstrap-iconpicker.min.css' }}" rel="stylesheet" />
@stop
@section('js')
    <script type="text/javascript" src="{{ asset('/bower_components/bootstrap-iconpicker/bootstrap-iconpicker/js/iconset/iconset-fontawesome-4.3.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/bower_components/bootstrap-iconpicker/bootstrap-iconpicker/js/bootstrap-iconpicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/default/permission.js') }}"></script>
@stop
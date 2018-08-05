
@section('js')
    <script type="text/javascript" src="{{ asset('/js/default/role.js') }}"></script>
@stop
{{ csrf_field() }}
<div class="form-group">
    <label for="name" class="col-sm-2 col-md-2 control-label">{{ trans('role.role_name') }}：</label>
    <div class="col-sm-7 col-md-6">
        <input id="name" type="text" class="form-control" name="name" value="{{ $formType == 'edit' && !old('name') ? $role->name : old('name') }}" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="description">{{ trans('common.description') }}：</label>
    <div class="col-sm-7 col-md-6">
        <textarea class="form-control"  name="description" id="description">{{ $formType == 'edit' && !old('description') ? $role->description : old('description') }}</textarea>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label" for="status">{{ trans('common.status') }}：</label>
    <div class="col-sm-7">
        <label class="radio-inline">
            <input type="radio" name="status" value="0" @if(($formType == 'edit' && $role->status == 0) || (old('status') == 0)) checked="checked" @endif> {{ trans('common.normal') }}
        </label>
        <label class="radio-inline">
            <input type="radio" name="status" value="1" @if(($formType == 'edit' && $role->status == 1) || (is_numeric(old('status')) && old('status') == 1)) checked="checked" @endif> {{ trans('common.ban') }}
        </label>
    </div>
</div>

<script type="text/javascript">

</script>
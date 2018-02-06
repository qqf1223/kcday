@section('js')
    <script type="text/javascript" src="{{ asset('/js/default/adminUser.js') }}"></script>
    <script type="text/javascript" src="{{ '/bower_components/cropper/cropper.min.js' }}"></script>
    <script type="text/javascript" src="{{ '/bower_components/cropper/avatar.js' }}"></script>
@stop
{{ csrf_field() }}
    {{--<div class="form-group">--}}
        {{--<label class="col-sm-4 col-md-4 control-label" for="username"><span class="text-danger">*</span> 用户名：</label>--}}
        {{--<div class="col-sm-4 col-md-4">--}}
            {{--<input id="username" type="text" class="form-control" name="username" value="{{ $formType == 'edit' && !old('name') ? $adminUser->name : old('name') }}" />--}}
        {{--</div>--}}
    {{--</div>--}}

    {{--<div class="form-group">--}}
        {{--<label for="emp_no" class="col-sm-4 col-md-4 control-label"><span class="text-danger">*</span> 工号：</label>--}}
        {{--<div class="col-sm-4 col-md-4">--}}
            {{--<input id="mobile" type="text" class="form-control" name="emp_no" value="" />--}}
        {{--</div>--}}
    {{--</div>--}}

    <div class="form-group">
        <label class="col-sm-4 col-md-4 control-label" for="emp_name"><span class="text-danger">*</span> 真实姓名：</label>
        <div class="col-sm-4 col-md-4">
            <input id="emp_name" type="text" class="form-control" name="emp_name" value="{{ $formType == 'edit' && !old('emp_name') ? $adminUser->emp_name : old('emp_name') }}" />
        </div>
    </div>


    <div class="form-group">
        <label for="mobile" class="col-sm-4 col-md-4 control-label"><span class="text-danger">*</span> 手机号：</label>
        <div class="col-sm-4 col-md-4">
            <input id="mobile" type="text" class="form-control" name="mobile" value="{{ $formType == 'edit' && !old('mobile') ? $adminUser->mobile : old('mobile') }}" />
        </div>
    </div>

    <div class="form-group">
        <label for="telephone" class="col-sm-4 col-md-4 control-label">电话：</label>
        <div class="col-sm-4 col-md-4">
            <input id="telephone" type="text" class="form-control" name="telephone" value="{{ $formType == 'edit' && !old('telephone') ? $adminUser->telephone : old('telephone') }}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 col-md-4 control-label" for="gender"> 性别：</label>
        <div class="col-sm-4 col-md-4">
            <label class="radio-inline">
                <input type="radio" name="gender" value="1" checked="checked" @if(($formType == 'edit' && $adminUser->gender == 1) || (old('gender') == 1)) checked="checked" @endif> 男
            </label>
            <label class="radio-inline">
                <input type="radio" name="gender" value="2"  @if(($formType == 'edit' && $adminUser->gender == 2) || (old('gender') == 2)) checked="checked" @endif> 女
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="email" class="col-sm-4 col-md-4 control-label"><span class="text-danger">*</span> Email：</label>
        <div class="col-sm-4 col-md-4">
            <input id="email" type="text" class="form-control" name="email" value="{{ $formType == 'edit' && !old('email') ? $adminUser->email : old('email') }}" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 col-md-4 control-label" for="dept_id"><span class="text-danger">*</span> 部门：</label>
        <div class="col-sm-4 col-md-4">
            <select class="form-control" name="dept_id" id="dept_id">
                <option value="0">请选择所属部门</option>
            </select>
        </div>
    </div>


    <div class="form-group">
        <label class="col-md-4 control-label" for="role_id">角色：</label>
        <div class="col-sm-4 col-md-4">
            @foreach($role_list as $val)
                <input type="checkbox" name="role_ids[]" value="{{ $val['id'] }}" @if(($formType == 'edit' && in_array($val['id'], $admin_role_ids))) checked="checked" @endif /> {{ $val['name'] }}
            @endforeach
        </div>
    </div>

    <div class="form-group">
        <label for="password" class="col-sm-4 col-md-4 control-label">登陆密码：</label>
        <div class="col-sm-4 col-md-4">
            <input id="password" type="password" class="form-control" name="password" value="" />
        </div>
    </div>
    <div class="form-group">
        <label for="confirmPass" class="col-sm-4 col-md-4 control-label">确认密码：</label>
        <div class="col-sm-4 col-md-4">
            <input id="confirmPass" type="password" class="form-control" name="confirmPass" />
        </div>
    </div>

    <div class="form-group">
        <label for="avatar" class="col-sm-4 col-md-4 control-label">头像:</label>
        <div class="col-sm-4 col-md-4"  id="crop-avatar">
            <button type="button" class="btn btn-default avatar-view" name="avatar_btn">上传头像</button>
            <img width="30" height="30" src="@if($formType == 'edit' && !empty($adminUser->avatar)) {{ asset('/avatar/' . $adminUser->avatar) }} @else {{ '/images/avatar.png' }} @endif"  />
            <input type="hidden" name="avatar" id="avatar" value="{{ $formType == 'edit' && !old('avatar') ? $adminUser->avatar : old('avatar') }}"/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 col-md-4 control-label" for="is_del">状态：</label>
        <div class="col-sm-4 col-md-4">
            <label class="radio-inline">
                <input type="radio" name="is_del" value="0" checked="checked"  @if(($formType == 'edit' && $adminUser->is_del == 0) || (old('is_del') == 0)) checked="checked" @endif > 正常
            </label>
            <label class="radio-inline">
                <input type="radio" name="is_del" value="1" @if(($formType == 'edit' && $adminUser->is_del == 1) || (old('is_del') == 1)) checked="checked" @endif> 禁用
            </label>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-4 col-md-4 control-label" for="status">发送密码：</label>
        <div class="col-sm-4 col-md-4">
            <label class="checkbox-inline">
                <input type="checkbox" name="sendto" value="1" > 发送到邮箱
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" name="sendto" value="2"> 发送到手机
            </label>
        </div>
    </div>

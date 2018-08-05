@extends('layouts.main')
@section('content')
    <style>
        .tab-pane {
            padding:15px;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h5 class="pull-left">{{ trans('sys.sys_setting') }}</h5>
                </div>
                <div class="box-body no-padding">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist" id="myTab">
                        <li role="presentation" class="active"><a href="#home" role="tab" data-toggle="tab" aria-expanded="true">基本信息</a></li>
                        <li role="presentation" ><a href="#email" role="tab" data-toggle="tab">邮箱配置</a></li>
                        <li role="presentation" ><a href="#safe" role="tab" data-toggle="tab">安全配置</a></li>
                    </ul>

                    <!-- Tab panes -->
                    <form class="form-horizontal" id="syssetting" action="/api/sys/save" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="home">
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="sys_name">系统名称：</label>
                                    <div class="col-md-4">
                                        <input id="sys_name" type="text" class="form-control" name="sys_name" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2" for="sys_remark">系统描述：</label>
                                    <div class="col-md-4">
                                        <input id="sys_remark" type="text" class="form-control" name="sys_remark" value="" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="sys_logo" class="control-label col-md-2">系统LOGO：</label>
                                    <div class="col-md-4">
                                        <input id="sys_logo " type="file" class="form-control" name="sys_logo" value="" />

                                        <img src="##" />

                                    </div>
                                </div>
                            </div>

                            <!-- email setting start -->
                            <div role="tabpanel" class="tab-pane" id="email">
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="mail_server">邮件服务器:</label>
                                    <div class="col-md-4">
                                        <input id="mail_server" type="text" class="form-control" name="mail_server" value=""  placeholder="smtp.qq.com"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="mail_port">邮件发送端口:</label>
                                    <div class="col-md-2">
                                        <input id="mail_port" type="text" class="form-control" name="mail_port" value="25" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mail_from" class="control-label col-md-3">发件人地址:</label>
                                    <div class="col-md-4">
                                        <input id="mail_from " type="text" class="form-control" name="mail_from" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="mail_type">邮件发送模式:</label>
                                    <div class="col-md-4">
                                        <label class="radio-inline">
                                            <input type="radio" name="mail_type" value="1" > SMTP 函数发送
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="mail_type" value="0" > mail 模块发送
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mail_user" class="control-label col-md-3">验证用户名:</label>
                                    <div class="col-md-4">
                                        <input id="mail_user " type="text" class="form-control" name="mail_user" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mail_password" class="control-label col-md-3">验证密码:</label>
                                    <div class="col-md-4">
                                        <input id="mail_password " type="text" class="form-control" name="mail_password" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="mail_to" class="control-label col-md-3">测试邮箱:</label>
                                    <div class="col-md-4">
                                        <input id="mail_to " type="text" class="form-control" name="mail_to" value="" />
                                    </div>
                                    <div class="col-md-1">
                                        <a name="testmail" class="btn btn-sm btn-primary">测试发送</a>
                                    </div>
                                </div>
                            </div>
                            <!-- email setting end -->
                            <div role="tabpanel" class="tab-pane" id="safe">
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="maxloginfailedtimes">后台最大登陆失败次数：</label>
                                    <div class="col-md-4">
                                        <input id="maxloginfailedtimes" type="text" class="form-control" name="maxloginfailedtimes" value="" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="enablcodecheck">登陆是否开启验证码：</label>
                                    <div class="col-md-4">
                                        <div id="toggle-state-switch" class="switch has-switch" data-on-label="打开" data-off-label="关闭">
                                            <input type="checkbox" name="enablcodecheck"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="allow_file_type">允许上传文件类型：</label>
                                    <div class="col-md-4">
                                        <input id="allow_file_type" type="text" class="form-control" name="allow_file_type" value="" placeholder="pdf,doc,jpg,png,gif,txt,doc,xls,zip,docx" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-3" for="clearcache">清空缓存：</label>
                                    <div class="col-md-4">
                                        <button id="clearcache" type="button" class="btn btn-default">清空</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6 text-center">
                            <button type="submit" name="submit" class="btn btn-primary">提交</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop


@section("js")
<script type="text/javascript">
    $('#myTab a').click(function (e) {
        e.preventDefault();
        $("input[name='tab']").val($(this).attr('href').substring(1))
    });
    $("#clearcache").on("click", function(){
        $.ajax({
            url:'/setting/clearcache',
            type:'post',
            dataType:'json',
            success:function(ret){
                var t = ret.errcode==0? 'success' : 'danger';
                qiao.bs.msg({
                    msg  : ret.msg,
                    type : t,
                });
            }
        });
    });
    $('#myTab a[href="#{$tab}"]').tab('show');
</script>
<script type="text/javascript" src="{{'plugins/bootstrapSwitch/bootstrapSwitch.js'}}"></script>
@endsection
@section("css")
    <link rel="stylesheet" href="plugins/bootstrapSwitch/bootstrapSwitch.css">
@endsection

<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>统一后台</title>
    <script type="text/javascript" src="{{'/js/jquery.js'}}"></script>
    <link href="{{'/plugins/bootstrap/bootstrap.min.css'}}" rel="stylesheet">
    <link href="{{'/css/default/login.css'}}" rel="stylesheet">
</head>

<body class="login-page">
<div class="login-form">
    <div class="login-content">
        <div class="form-login-error">
            <p></p>
        </div>
            <form class="form-horizontal" id="loginform">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-user"></i>
                    </div>
                    <input type="text" class="form-control input-block-level" name="username" id="username" placeholder="用户名" autocomplete="off" />
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="input-group">
                    <div class="input-group-addon">
                        <i class="glyphicon glyphicon-lock"></i>
                    </div>
                    <input type="password" class="form-control input-block-level" name="password" id="password" placeholder="密码" autocomplete="off" />
                </div>
            </div>

            @if(!empty($enablcodecheck))
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-addon">
                            <i class="glyphicon glyphicon-qrcode"></i>
                        </div>
                        <input type="text" class="form-control" name="verifyCode" placeholder="验证码" style="width:120px;"/>
                        <img src="{{ captcha_src() }}" alt="verify_code" id="verifyCode">
                        <div class="input-group-addon" title="点击刷新" onclick="refreshCode();"><i class="glyphicon glyphicon-refresh"></i></div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block btn-lg text-center">
                    登录
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    var captcha = '{{ Captcha::src() }}';
</script>
<script type="text/javascript" src="{{'js/default/login.js'}}"></script>
</body>
</html>

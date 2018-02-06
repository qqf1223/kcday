/*刷新验证码*/
function refreshCode(){
    $("#verifyCode").attr('src', captcha + '&r='+Math.random());
}

// 表单提交
$("#loginform").submit(function(e){
    e.preventDefault();
    e.stopPropagation();
    var username = $("#username").val();
    var password = $("#password").val();
    if (username == '') {
        $("#username").focus();
        lump_error("请输入账号！");
        return false;
    }
    if (password == '') {
        $("#password").focus();
        lump_error("密码不能为空！");
        return false;
    }
    var data = $(this).serialize();
    $.post($(this).attr('action'), data , function(json){
        if (json.code == '200') {
            window.location.href = "/";
        } else {
            lump_error(json.msg);
            return false;
        }
    }, 'json');
    return false;
});
var timeoutId;
function lump_error(msg){
    $(".form-login-error").addClass('visible');
    $(".form-login-error p").text(msg);
    timeoutId = setTimeout('lump_hide()', 3000);
}
function lump_hide(){
    $(".form-login-error").removeClass('visible');
    $(".form-login-error p").text('');
    clearTimeout(timeoutId);
}
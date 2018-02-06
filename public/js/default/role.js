$("#roleSubmit").click(function(){
    if(validform().form()) {
        ajaxSubmit();
    }else{
        return false;
    }
});
function validform(){
    return $("#roleForm").validate({
        rules:{
            name:'required',
        },
        messages:{
            name:"请添加角色名称",
        },
        errorElement: "span",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            element.parents(".form-group").addClass("has-error has-feedback");
            if ( element.prop( "type" ) === "checkbox" ) {
            } else {
            }
        },
        success:function( error, element ){
            $(element).parents(".has-error").removeClass("has-error has-feedback");
        }
    });
}

function ajaxSubmit(){
    var data = $("#roleForm").serialize();
    var _url=$("#roleSubmit").attr('data-url');
    $.post(_url, data, function(ret){
        BootstrapDialog.alert({
            title:'提示',
            size: BootstrapDialog.SIZE_SMALL,
            message: ret.msg,
            callback:function(){
                if(ret.code == 200){
                    history.go(-1);
                }
            }
        });
    });
}

/**
 * 删除数据
 * @param $id
 */
function delRole(id)
{
    id = parseInt(id);
    BootstrapDialog.confirm({
        type: BootstrapDialog.TYPE_WARNING,
        title:'提示',
        size: BootstrapDialog.SIZE_SMALL,
        message: '您要确认删除该角色么？',
        callback:function(btn) {
            console.log(btn);
            if (btn) {
                $.ajax({
                    type:"post",
                    dataType:"json",
                    data:{_method:'delete'},
                    url:"/api/role/delete/"+id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success:function(ret){
                        if(ret.code == 200){
                            dataTable.ajax.reload();
                        }else{
                            window.wxc.dialog(ret.msg, window.wxc.dialog.typeEnum.error);
                        }
                    }
                })
            }
        }
    });
}

$("#save").click(function(){
    var data = $("#authform").serialize();
    var _url=$("#save").attr('data-url');
    $.post(_url, data, function(ret){
        BootstrapDialog.alert({
            title:'提示',
            size: BootstrapDialog.SIZE_SMALL,
            message: ret.msg,
            callback:function(){
                if(ret.code == 200){
                    history.go(-1);
                }
            }
        });
    });
});
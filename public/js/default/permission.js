/*权限操作*/
$("#permissionSubmit").click(function(){
    if(validform().form()) {
        ajaxSubmit();
    }else{
        return false;
    }
});
function validform(){
    return $("#permissionForm").validate({
        rules:{
            name:"required",
            rule:"required",
        },
        messages:{
            name:"请输入权限名称",
            rule:"请输入权限规则"
        },
        errorElement: "span",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            element.parents(".form-group").addClass("has-error has-feedback");
            if ( element.prop( "type" ) === "checkbox" ) {} else {}
        },
        success:function( error, element ){
            $(element).parents(".has-error").removeClass("has-error has-feedback");
        }
    });
}

function ajaxSubmit(){
    var data = $("#permissionForm").serialize();
    var _url=$("#permissionSubmit").attr('data-url');
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
$("#sSearchSubmit").on('click', function(){
    dataTable.ajax.reload();
});

function ajaxDataTable(sSource, aoData, fnCallback){
    var sSearch = $('#sSearch').val();
    aoData.push({"name":"sSearch", "value":sSearch});
    $.ajax({
        url:sSource,
        data:aoData,
        type: "post",
        dataType: "json",
        async: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result){
            fnCallback(result);
        },
        error: function(result){
            alert(result);
        }
    });
}
/**
 * 删除数据
 * @param $id
 */
function delPermissionData(id)
{
    id = parseInt(id);
    BootstrapDialog.confirm({
        type: BootstrapDialog.TYPE_WARNING,
        title:'提示',
        size: BootstrapDialog.SIZE_SMALL,
        message: '您要确认删除该权限么？',
        callback:function(btn) {
            console.log(btn);
            if (btn) {
                $.ajax({
                    type: "post",
                    dataType: "json",
                    data: {_method: 'delete'},
                    url: "/api/permission/delete/" + id,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (ret) {
                        if (ret.code == 200) {
                            dataTable.ajax.reload();
                        } else {
                            BootstrapDialog.alert({
                                title: '提示',
                                size: BootstrapDialog.SIZE_SMALL,
                                message: ret.msg,
                            });
                        }
                    }
                })
            }
        }
    });
}
/*权限操作end*/


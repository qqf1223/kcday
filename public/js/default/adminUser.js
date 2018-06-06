$("#adminUserSubmit").click(function(){
    if(validform().form()) {
        var data = $("#adminUserForm").serialize();
        var _url=$("#adminUserSubmit").attr('data-url');
        $.post(_url, data, function(ret){
            BootstrapDialog.alert({
                title:'提示',
                size: BootstrapDialog.SIZE_SMALL,
                message: ret.msg,
            });
        });
    }else{
        return false;
    }
});
function validform(){
    return $("#adminUserForm").validate({
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

/**
 * 删除数据
 * @param $id
 */
function delUser(id)
{
    id = parseInt(id);
    BootstrapDialog.confirm({
        type: BootstrapDialog.TYPE_WARNING,
        title:'提示',
        size: BootstrapDialog.SIZE_SMALL,
        message: '您要确认删除管理员么？',
        callback:function(btn) {
            if (btn) {
                $.ajax({
                    type: "post",
                    dataType: "json",
                    data: {_method: 'delete'},
                    url:"/api/adminUser/delete/"+id,
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

$("#sSearchSubmit").on('click', function(){
    dataTable.ajax.reload();
});


$("#addnew").on('click',function(){
    //BootstrapDialog.show({
    //    message: $('<div></div>').load("test.blade.php")
    //});
    location.href = "/adminUser/add";
});

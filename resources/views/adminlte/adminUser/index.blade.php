@extends('layouts.main')
@section('css')
    <link href="{{ '/bower_components/datatables/dataTables.bootstrap.css' }}" rel="stylesheet" />
@stop
@section('js')
    <script src="{{ asset('/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/bower_components/datatables/dataTables.bootstrap.min.js') }}"></script>
    <script>
        var dataTable = null;
        $(function(){
            //数据表格
            dataTable = $("#dataTable").DataTable({
                //配置
                "bServerSide": true,
                "bSort": true,
                "searching": false,
                "lengthChange": false,
                "autoWidth": false,
                "fnServerData" : function(sSource, aoData, fnCallback){
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
                            console.log(result);
                        }
                    });
                },
                "sAjaxSource": "/api/adminUser",
                "iDisplayLength": 10,
                "oLanguage": {
                    "sProcessing": "正在加载中...",
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "sZeroRecords": "抱歉, 没有匹配的数据",
                    "sInfo": "从 _START_ 到 _END_ /共 _TOTAL_ 条数据",
                    "sInfoEmpty": "没有数据",
                    "sInfoFiltered": "(从 _MAX_ 条数据中检索)",
                    "sSearch": "搜索",
                    "sLengthMenu": "_MENU_ 页/条",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上一页",
                        "sNext": "下一页",
                        "sLast": "尾页"
                    },
                    "sZeroRecords": "没有检索到数据"
                },
                "aaSorting": [
                    [0, 'desc'],
                    [3]
                ],
                "aoColumns": [
                    { "data": "id" },
                    { "data": "emp_name", "bSortable": false },
                    { "data": "dept_id", "bSortable": false },
                    { "data": "gender" , "bSortable": false},
                    { "data": "email", "bSortable": false  },
                    { "data": "mtime", "bSortable": false },
                    { "data": "id", "bSortable": false },
                ],
                "columnDefs" : [
                    //规则
                    {
                        "render" : function(data){
                            return '<div style="word-wrap:break-word;" >'+data+'</div>'
                        },
                        "sWidth" : "100px",
                        "targets": 2
                    },
                    //是否菜单
                    {
                        "render" : function(data) {
                            if(data == 1){
                                return "<span class='btn btn-danger btn-xs'>否</span>";
                            }
                            return "";
                        },
                        "targets": 3
                    },
                    //操作
                    {
                        "render" : function(data, type, row) {
                            if(data > 0) {
                                var opt_html = '';
                                @if(adminAuth('adminUser.show'))
                                        opt_html += "<a href='{{ url('adminUser/show') }}/"+data+"' class='X-Small btn-xs text-info'><i class='fa fa-send'></i> 详情</a>";
                                @endif
                                        @if(adminAuth('adminUser.edit'))
                                        opt_html += "<a href='{{ url('adminUser/edit') }}/"+data+"' class='X-Small btn-xs text-success'><i class='fa fa-edit'></i> 编辑</a>";
                                @endif
                                        @if(adminAuth('adminUser.delete'))
                                        opt_html += "<a href='javascript:;' onclick='delUser("+data+")' class='X-Small btn-xs text-danger'><i class='fa fa-times-circle'></i> 删除</a>";
                                @endif
                                        return opt_html;
                            }
                        },
                        "targets": 6
                    }
                ],
            });
        })
    </script>
    <script type="text/javascript" src="{{ asset('/js/default/adminUser.js') }}"></script>
@stop
@section('content')


    <div class="row head">
        <div class="col-xs-4 col-md-3">
            <form class="form-horizontal">
                <div class="input-group">
                    <input type="text" class="form-control input-sm" name="sSearch" id="sSearch" placeholder="{{ trans('user.user_name')  }}" >
                <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" type="button" id="sSearchSubmit">{{ trans('common.search')  }}</button>
                </span>
                </div>
            </form>
        </div>
        <div class="text-right  col-xs-8 col-md-9">
            <button type="button" class="btn btn-primary btn-sm" onclick="location.href='{{ url('adminUser/add') }}'">
                <span class="glyphicon glyphicon-plus-sign"></span> {{ trans('common.add_new')  }}
            </button>
        </div>
    </div>
    <div>
        <table id="dataTable" class="table table-hover table-striped">
            <thead>
            <tr>
                <th>管理员ID</th>
                <th>用户名</th>
                <th>部门</th>
                <th>是否有效</th>
                <th>邮箱</th>
                <th>编辑时间</th>
                <th>操作</th>
            </tr>
            </thead>

        </table>
    </div>
@stop

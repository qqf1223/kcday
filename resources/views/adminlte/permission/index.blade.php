@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="pull-left">权限列表</h5>
                    <div class="pull-right" style="margin-left:5px;">
                        @if(adminAuth('permission.add'))
                            <button type="button" class="btn btn-primary" onclick="location.href='{{ url('permission/add').'/'.$pid }}'">
                                <span class="glyphicon glyphicon-plus-sign"></span> {{ trans('permission.add_permission') }}
                            </button>
                        @endif
                        @if($pid)
                            <button type="button" class="btn btn-primary" onclick="location.href='{{ url('permission/index') .'/' . $parent_permission->pid }}'">
                                <span class="fa fa-reply"></span> {{ trans('common.go_back') }}
                            </button>
                        @endif
                    </div>
                    <div class="input-group col-md-3 pull-right">
                        <input type="text" class="form-control" name="sSearch" id="sSearch" placeholder="{{ trans('permission.permission_name')  }}">
                        <span class="input-group-btn">
                           <button class="btn btn-primary" type="button" id="sSearchSubmit">{{ trans('common.search')  }}</button>
                        </span>
                    </div>
                </div>

                <div class="box-body">
                    <table id="dataTable" class="table table-hover table-striped">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>权限名称</th>
                            <th>权限规则</th>
                            <th>菜单</th>
                            <th>排序</th>
                            <th>状态</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop

@section('js')
    <script type="text/javascript" src="{{ asset('/js/default/permission.js') }}"></script>
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
                "sAjaxSource": "/api/permission/index/{{ $pid }}",
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
                    { "data": "name", "bSortable": false },
                    { "data": "rule", "bSortable": false },
                    { "data": "is_menu" , "bSortable": false},
                    { "data": "sort", "bSortable": false  },
                    { "data": "status", "bSortable": false },
                    { "data": "id", "bSortable": false },
                ],
                "columnDefs" : [
                    //规则
                    {
                        "render" : function(data){
                            return '<div style="width:200px;word-wrap:break-word;" >'+data+'</div>'
                        },
                        "sWidth" : "250px",
                        "targets": 2
                    },
                    //是否菜单
                    {
                        "render" : function(data) {
                            if(data == 1){
                                return "<span class='btn btn-info btn-xs'>是</span>";
                            }
                            return "";
                        },
                        "targets": 3
                    },
                    //状态
                    {
                        "render" : function(data) {
                            if(data == 1){
                                return "<span class='btn btn-danger btn-xs'>禁用</span>";
                            }
                            return "<span class='btn btn-success btn-xs'>正常</span>";
                        },
                        "targets": 5
                    },
                    //操作
                    {
                        "render" : function(data, type, row) {
                            if(data > 0) {
                                var opt_html = '';
                                @if(adminAuth('permission.index'))
                                        opt_html += "<a href='{{ url('permission/index') }}/"+data+"' class='X-Small btn-xs text-navy'><i class='fa fa-navicon'></i> 子级权限</a>";
                                @endif
                                        @if(adminAuth('permission.edit'))
                                        opt_html += "<a href='{{ url('permission/edit') }}/"+data+"' class='X-Small btn-xs text-success'><i class='fa fa-edit'></i> 编辑</a>";
                                @endif
                                        @if(adminAuth('permission.delete'))
                                        opt_html += "<a href='javascript:;' onclick='delPermissionData("+data+")' class='X-Small btn-xs text-danger'><i class='fa fa-times-circle'></i> 删除</a>";
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
@stop

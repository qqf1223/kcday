@extends('layouts.main')
@section('js')
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
                "sAjaxSource": "/api/department/index",
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
                    { "data": "description", "bSortable": false },
                    { "data": "mtime" , "bSortable": false},
                    { "data": "status", "bSortable": false },
                    { "data": "id", "bSortable": false },
                ],
                "columnDefs" : [
                    //状态
                    {
                        "render" : function(data) {
                            if(data == 1){
                                return "<span class='btn btn-danger btn-xs'>禁用</span>";
                            }
                            return "<span class='btn btn-success btn-xs'>正常</span>";
                        },
                        "targets": 4
                    },
                    //操作
                    {
                        "render" : function(data, type, row) {
                            if(data > 0) {
                                var opt_html = '';
                                @if(adminAuth('department.edit'))
                                        opt_html += "<a href='{{ url('role/edit') }}/"+data+"' class='X-Small btn-xs text-success'><i class='fa fa-edit'></i> 编辑</a>";
                                @endif
                                        @if(adminAuth('department.delete'))
                                        opt_html += "<a href='javascript:;' onclick='delRole("+data+")' class='X-Small btn-xs text-danger'><i class='fa fa-times-circle'></i> 删除</a>";
                                @endif
                                        return opt_html;
                            }
                        },
                        "targets": 5
                    }
                ],
            });
        })
    </script>
    <script src="{{ asset('/js/default/department.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h5 class="pull-left">{{ trans('role.role_list')  }}</h5>
                    <div class="pull-right" style="margin-left:5px;">
                        <button type="button" class="btn btn-primary" onclick="location.href='{{ url('role/add') }}'">
                            <span class="glyphicon glyphicon-plus-sign"></span> {{ trans('role.add_role')  }}
                        </button>
                    </div>
                    <div class="input-group col-md-3 pull-right">
                        <input type="text" class="form-control" name="sSearch" id="sSearch" placeholder="{{ trans('role.role_name')  }}">
                        <span class="input-group-btn">
                           <button class="btn btn-primary" type="button" id="sSearchSubmit">{{ trans('common.search')  }}</button>
                        </span>
                    </div>
                </div>

                <div class="box-body">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>{{ trans('common.name') }}</th>
                            <th>{{ trans('common.description') }}</th>
                            <th>{{ trans('common.update_time') }}</th>
                            <th>{{ trans('common.status') }}</th>
                            <th>{{ trans('common.operation') }}</th>
                        </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

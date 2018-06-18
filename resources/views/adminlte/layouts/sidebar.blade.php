<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">菜单</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="/"><i class="fa fa-link"></i> <span>面板</span></a></li>
            <li class="treeview">
                <a href="#"><i class="fa fa-link"></i> <span>系统管理</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="/adminUser">管理员管理</a></li>
                    <li><a href="/permission">权限管理</a></li>
                    <li><a href="/role">角色管理</a></li>
                    <li><a href="/role">用户管理</a></li>
                    <li><a href="/sys">系统设置</a></li>
                </ul>
            </li>
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
@section('menu_js')
<script type="text/javascript">
    var aa = '{{ Request::path() }}';
    var menu_c = $('.sidebar-menu').find("[href='/"+aa+"']");

    menu_c.parent('li').addClass('active');
    menu_c.parents('.treeview').addClass('active').addClass('menu_open');
    $('.treeview').on('click', function(){
        $(this).siblings('li').removeClass('active').removeClass('menu_open');
    });
</script>
@stop

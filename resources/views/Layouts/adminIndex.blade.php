<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>后台首页</title>
    <link rel="stylesheet" type="text/css" href="{{url('/Adm/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/Adm/css/bootstrap-table.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/Adm/css/iconfont.css')}}">
    <link rel="stylesheet" type="text/css" href="{{url('/Adm/css/style.css')}}">
    @section('admincss')  @show
    <link rel="stylesheet" href="{{url('/Adm/css/my-style.css')}}">
</head>
<body>
<div class="skin-default" id="wrapper">
    <header class="navbar-header">
        <div class="brand">
            <a class="navbar-brand" href="{{url('/admin')}}" title="AlphaAdmin">首页</a>
        </div>
        <div class="navbar">
            <i class="sidebar-toggle iconfont icon-menu" data-toggle="push-menu" role="button"></i>
            <div class="navbar-menu pull-right">
                <ul class="nav navbar-nav">
                    <li class="dropdown user">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="用户">{{Session::get('admin_name')}}</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a data-toggle="modal" data-target=".menu-adduser" href="#" title="添加管理员">
                                    <i class="iconfont icon-menu-user"></i>
                                    添加管理员
                                </a>
                            </li>
                            <li>
                                <a data-toggle="modal" data-target=".menu-setpassword" href="#" title="修改密码">
                                    <i class="iconfont icon-menu-user"></i>
                                    修改密码
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a data-toggle="modal" data-target=".menu-logout" href="#" title="登出">
                                    <i class="iconfont icon-power"></i>
                                    登出
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- 左侧导航 -->
    <aside class="main-sidebar">
        <div class="user-panel">
            <div class="image pull-left">
                <img src="/uploads/{{Session::get('admin_head_img')}}" alt="头像">
            </div>
            <div class="info pull-right">
                <p class="title">{{Session::get('admin_name')}}</p>
                <strong>管理员</strong>
            </div>
        </div>
        <section class="sidebar">
            <ul class="sidebar-menu" data-widget="tree">
                <li class="treeview @section('menu1') @show ">
                    <a href="##" title="首页">
                        <i class="iconfont icon-dashborad"></i>
                        <small>首页</small>
                        <span class=" pull-right">
                            <i class="iconfont icon-menu-left-small"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{url('/admin')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>网站信息</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="{{url('/admin/loop')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>轮播图</small>
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="{{url('/admin/banner')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>Banner图</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview @section('menu2') @show ">
                    <a href="##" title="品牌背景">
                        <i class="glyphicon glyphicon-home"></i>
                        <small>品牌背景</small>
                        <span class=" pull-right">
                            <i class="iconfont icon-menu-left-small"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{url('/admin/brand')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>品牌内容1</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview @section('menu3') @show ">
                    <a href="##" title="新闻动态">
                        <i class="glyphicon glyphicon-tags"></i>
                        <small>新闻动态</small>
                        <span class=" pull-right">
                            <i class="iconfont icon-menu-left-small"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{url('/admin/news')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>新闻内容1</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview @section('menu4') @show ">
                    <a href="##" title="加盟专区">
                        <i class="glyphicon glyphicon-check"></i>
                        <small>加盟专区</small>
                        <span class=" pull-right">
                            <i class="iconfont icon-menu-left-small"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{url('/admin/join')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>加盟内容1</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview @section('menu5') @show ">
                    <a href="##" title="加盟动态">
                        <i class="glyphicon glyphicon-modal-window"></i>
                        <small>加盟动态</small>
                        <span class=" pull-right">
                            <i class="iconfont icon-menu-left-small"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{url('/admin/dynamic')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>动态内容1</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview @section('menu6') @show ">
                    <a href="##" title="创业学院">
                        <i class="glyphicon glyphicon-book"></i>
                        <small>创业学院</small>
                        <span class=" pull-right">
                            <i class="iconfont icon-menu-left-small"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{url('/admin/school')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>学院内容1</small>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="treeview @section('menu7') @show ">
                    <a href="##" title="在线留言">
                        <i class="glyphicon glyphicon-pencil"></i>
                        <small>在线留言</small>
                        <span class=" pull-right">
                            <i class="iconfont icon-menu-left-small"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="{{url('/admin/word')}}">
                                <i class="iconfont icon-circle-hollow"></i>
                                <small>留言内容1</small>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
    </aside>

    <!--自定义页面-->
    <div class="page-wrapper">
        @section('itemnav')

        @show
        <div style="padding: 15px;margin: 0 auto;">
        @if(Session::has('success'))
            <!-- 成功提示框 -->
            <div class="alert alert-success alert-dismissible m-alert my-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="margin-left: -50px">&times;</span>
                </button>
                <p>{{Session::get('success')}}</p>
            </div>
        @endif
        @if(Session::has('error'))
            <!-- 失败提示框 -->
            <div class="alert alert-danger alert-dismissible  m-alert my-alert" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="margin-left: -50px">&times;</span>
                </button>
                <p>{{Session::get('error')}}</p>
            </div>
        @endif
        </div>
        @section('main')

        @show
    </div>

    <!-- 修改密码模态框 -->
    <div class="modal fade menu-setpassword" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">修改密码</h4>
                </div>
                <form action="/admin/user/{{Session::get('admin_id')}}" id="edit-password-form" method="post">
                    {{method_field('PUT')}}
                    {{csrf_field()}}
                    <div class="modal-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    旧密码
                                </th>
                                <td>
                                    <input type="text" class="form-control" name="old-password" value="{{Session::get('admin_password')}}" readonly="readonly">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    新密码
                                </th>
                                <td>
                                    <div class="form-group mine-edit-password" style="margin-bottom:0;">
                                        <input type="password" id="edit-password" class="form-control" placeholder="请输入新密码" name="news-password">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    确认密码
                                </th>
                                <td>
                                    <div class="form-group mine-edit-password" style="margin-bottom:0;">
                                        <input type="password" id="edit-again-passowrd" class="form-control" placeholder="请再次输入新密码" name="agen-password">
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 添加管理员模态框 -->
    <div class="modal fade menu-adduser" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-xs" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">添加管理员</h4>
                </div>
                <form action="/admin/user" method="post" id="add-user" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="modal-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>
                                    管理员昵称
                                </th>
                                <td>
                                    <input type="text" class="form-control" placeholder="请输入昵称" name="name">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    管理员账号
                                </th>
                                <td>
                                    <input type="text" class="form-control" placeholder="请输入管理员账号" name="user_name">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    管理员密码
                                </th>
                                <td>
                                    <div class="form-group mine-password" style="margin-bottom:0;">
                                        <input type="password" id="user_password" class="form-control" placeholder="请输入密码" name="password">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    确认密码
                                </th>
                                <td>
                                    <div class="form-group mine-password" style="margin-bottom:0;">
                                        <input type="password" id="again_user_password" class="form-control" placeholder="请再次输入密码" name="agen_password">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    管理员头像
                                </th>
                                <td>
                                    <input type="file" class="form-control" name="head_img">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 退出提示模态框 -->
    <div class="modal fade menu-logout" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">提示</h4>
                </div>
                <div class="modal-body">
                    <p>是否确定退出</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                    <a href="/admin/login/create" class="btn btn-primary">登出</a>
                    {{-- <button type="submit" class="btn btn-primary">登出</button> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!--消除报错-->
<div id="canvashidden" style="display: none;">
    <div class="box-body" id="chart">
        <canvas id="lineChart" style="width: 100%;height: 350px;"></canvas>
    </div>
    <div class="box-body" id="chart">
        <canvas id="doughnutChart" style="width: 100%;height: 300px;"></canvas>
    </div>
</div>
</body>
</html>
<script type="text/javascript" src="{{url('/Adm/js/jquery-2.1.0.min.js')}}"></script>
<script type="text/javascript" src="{{url('/Adm/js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{url('/Adm/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{url('/Adm/js/Chart.min.js')}}"></script>
<script type="text/javascript" src="{{url('/Adm/js/echarts.min.js')}}"></script>
<script type="text/javascript" src="{{url('/Adm/js/alpha.js')}}"></script>
<script type="text/javascript" src="{{url('/Adm/js/dashboard.js')}}"></script>
<script type="text/javascript" src="{{url('/Adm/js/mine-function.js')}}"></script>
@section('adminjs')  @show
<script type="text/javascript">
    //提示框自动消失
    window.setTimeout(function(){
        $('[data-dismiss="alert"]').alert('close');
    },2000);
    var h = $('.main-sidebar').height();
    $('.main-sidebar').height(h-50);
    $('.page-wrapper').height(h-50);
</script>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" type="text/css" href="{{url('Adm/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('Adm/css/my-style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{url('Adm/css/login.css')}}" />
</head>
<body>
<div class="main">
    <div class="login">
        <h1>管理系统</h1>
        <div class="inset">
            <!--start-main-->
            <form class="loginForm" action="/admin/login" method="post">
            {{csrf_field()}}
                <div>
                    <h2>管理登录</h2>
                    <span><label>用户名</label></span>
                    <span><input type="text" class="textbox" name="user_name" placeholder="请输入用户名" autofocus ></span>
                </div>
                <div>
                    <span><label>密码</label></span>
                    <span><input type="password" class="password" name="password" placeholder="请输入密码"></span>
                </div>
                <div class="sign">
                    <input type="submit" value="登录" class="submit" />
                </div>
            </form>
        </div>
    </div>
@if(Session::has('error'))
    <!-- 失败提示框 -->
    <div class="alert alert-danger alert-dismissible" role="alert" style="position: fixed;z-index: 999;left: 50%;top: 100px;margin-left: -100px;">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {{Session::get('error')}}
    </div>
@endif
    <!--//end-main-->
</div>
</body>
</html>
<script type="text/javascript" src="{{url('Adm/js/jquery-2.1.0.min.js')}}"></script>
<script type="text/javascript" src="{{url('Adm/js/bootstrap.min.js')}}"></script>
<script type="text/javascript">
    window.setTimeout(function(){
        $('[data-dismiss="alert"]').alert('close');
    },3000);
</script>
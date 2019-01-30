<?php /*a:2:{s:57:"/www/wwwroot/tete/application/admin/view/admin/index.html";i:1548064484;s:59:"/www/wwwroot/tete/application/admin/view/layout/layout.html";i:1548064484;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="@pratikborsadiya">
    <meta property="twitter:creator" content="@pratikborsadiya">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 4 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 4, SASS and PUG.js. It's fully customizable and modular.">
    <title>推工具后台</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="/static/admin/css/main.css">
    <link rel="stylesheet" type="text/css" href="/static/admin/lib/bootstrap-3.3.7-dist/css/bootstrap.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="/static/admin/js/jquery-3.2.1.min.js"></script>

    <script src="/static/admin/lib/layer/layer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="/static/admin/js/popper.min.js"></script>
    <script src="/static/admin/js/bootstrap.min.js"></script>
    <script src="/static/admin/lib/bootstrap-3.3.7-dist/js/bootstrap.js"></script>


    <script src="/static/admin/js/main.js"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="/static/admin/js/plugins/pace.min.js"></script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="/static/admin/js/plugins/chart.js"></script>

</head>
<body>

<style>
    #iframeContent{
        width: 84%;
        height: 918px;
        margin-top: 51px;

        margin-left: 16%;
    }
    .app-menu .treeview .treeview-menu li{
        padding:7px 0px 7px 0px;
    }
</style>


<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="index.html">Vali</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">

        <!--Notification Menu-->

        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="javascript:;" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
                <li><a class="dropdown-item" href="page-user.html"><i class="fa fa-user fa-lg"></i> Profile</a></li>
                <li><a class="dropdown-item" href="adminlogout"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
            </ul>
        </li>
    </ul>
</header>


<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="http://img.zcool.cn/community/01218f554229710000019ae9631440.jpg" width="50px" height="50px" alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><?php echo htmlentities($adminuser['user']); ?></p>
            <p class="app-sidebar__user-designation">登录：<?php echo htmlentities($adminuser['logintime']); ?></p>
        </div>
    </div>
    <ul class="app-menu">


                <li><a class="treeview-item" href="/adminmember" target="main"><i class="icon fa fa-circle-o"></i>用户管理</a></li>






    </ul>
</aside>





<iframe id="iframeContent" name="main" scrolling="auto" frameborder="0" src="/adminmember"></iframe>


<script src="/static/admin/js/main.js"></script>
<script>


</script>
<!-- Essential javascripts for application to work-->


</body>
</html>
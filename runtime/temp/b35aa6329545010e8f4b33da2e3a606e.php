<?php /*a:2:{s:60:"G:\work\test\aa\application\admin\view\admingroup\index.html";i:1548643612;s:57:"G:\work\test\aa\application\admin\view\layout\layout.html";i:1548312815;}*/ ?>
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
    <title>私人领地</title>
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
  .infotextarea{
    width:100%;
    padding:10px;
    height:200px;
  }
.infotitle{
    color:#fff;
    padding:10px;
    background:#286090;
    margin-top:10px;
}
  .infotitle3{

      padding:10px;

  }
    .infotitletext{
        padding-top:10px;
    }
</style>
<link rel="stylesheet" href="/static/admin/lib/layui/css/layui.css" media="all">
<script src="/static/admin/lib/layui/layui.js"></script>
    <main class="app-content" id="app-1">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> 私人领地</h1>
          
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">私人领地</li>
          <li class="breadcrumb-item active"><a href="#">领地管理</a></li>
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
                    <form class="form-inline" role="form" action="javascript:;" style="padding:10px;">
                      <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="群组ID，群组名称" v-model="title">
                      </div>





                      <button type="submit" class="btn btn-default" @click="init(true)">提交</button>
                    </form>
            <div class="tile-body">
              <table class="table table-hover table-bordered" id="sampleTable">
                <thead>
                  <tr>
                    <th>领地编号</th>
                    <th>领地名称</th>
                    <th>领主ID</th>
                    <th>领主昵称</th>
                    <th>成员数量</th>

                    <th>操作</th>
                  </tr>
                </thead>

                <tbody>
                  <tr v-for="v in lists">
                    <td>{{ v.id }}</td>
                    <td>{{ v.groupname }}</td>
                    <td>{{ v.member.id}}</td>
                    <td>{{ v.member.nickname}}</td>
                    <td>{{ v.chatmember_count}}</td>

                    <td>
                      <button class="btn btn-primary btn-sm" type="button" @click="savename(v.id)">修改名称</button>


                     </td>

                  </tr>



                </tbody>
              </table>
<div style="width:600px;margin:0 auto;">
  <ul class="pager">
    <li><a href="javascript:;" @click="setpage(-1)">上一页</a></li>

    <li><a href="javascript:;" style="padding:5px;width:50px;"><input type="text" id="pagesetinput" style="width:40px;height:20px;text-align: center;" v-model="pagejump"/></a></li>
    <li><a href="javascript:;" @click="jumppage()">跳转</a></li>
    <li><a href="javascript:;" @click="setpage(1)">下一页</a></li>
    <li><a href="javascript:;">当前{{page}}页</a></li>
    <li><a href="javascript:;">共<span>{{ pagestyle }}</span>页</a></li>
    <li><a href="javascript:;"><select @change="init(true)" v-model="limits">
      <option value="10">10条</option>
      <option value="20">20条</option>
      <option value="50">50条</option>
      <option value="100">100条</option>

    </select></a></span></li>
  </ul>
</div>
            </div>

          </div>

        </div>
      </div>


    </main>

<script src="/static/admin/js/admingroup/index.js"></script>

<script>


</script>
<!-- Essential javascripts for application to work-->


</body>
</html>
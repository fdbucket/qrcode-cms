<!DOCTYPE html>
<html>
<head>
  <title>二维码管理系统</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/wangEditor.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../assets/css/huoma.css">
</head>
<body>

<!-- 全局信息提示框 -->
<div id="Result" style="display: none;"></div>

<?php
// 页面字符编码
header("Content-type:text/html;charset=utf-8");
// 判断登录状态
session_start();
if(isset($_SESSION["session_admin"])){

  // 数据库配置
  include '../db_config/db_config.php';

  // 创建连接
  $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

  echo '<!-- 顶部导航栏 -->
<div id="topbar">
  <div class="container">
    <span class="topbar-title"><a href="./">二维码管理系统后台</a></span>
    <span class="topbar-login-link">'.$_SESSION["session_admin"].'<a href="logout.php">退出</a></span>
  </div>
</div>

<!-- 操作区 -->
<div class="container">
  <br/>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">二维码管理系统</a></li>
      <li class="breadcrumb-item active" aria-current="page">邀请码</li>
    </ol>
  </nav>
  <p>邀请码管理（查看、创建、停用、删除）</p>
  
  <!-- 左右布局 -->
  <!-- 左侧布局 -->
  <div class="left-nav">
    <button type="button" class="btn btn-dark">邀请码列表</button>
    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#shengcheng_yqm" onclick="creatstr();">生成邀请码</button>
    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#creat_yqm">批量导入</button>
    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#clean_yqm">清空邀请码</button>
    <button type="button" class="btn btn-light"><a href="./">返回首页</a></button>
  </div>';

  //计算总活码数量
  $sql_yqm = "SELECT * FROM qrcode_invitecode";
  $result_yqm = $conn->query($sql_yqm);
  $allyqm_num = $result_yqm->num_rows;

  //每页显示的活码数量
  $lenght = 10;

  //当前页码
  @$page = $_GET['p']?$_GET['p']:1;

  //每页第一行
  $offset = ($page-1)*$lenght;

  //总数页
  $allpage = ceil($allyqm_num/$lenght);

  //上一页     
  $prepage = $page-1;
  if($page==1){
    $prepage=1;
  }

  //下一页
  $nextpage = $page+1;
  if($page==$allpage){
    $nextpage=$allpage;
  }

  // 获取群活码列表
  $sql = "SELECT * FROM qrcode_invitecode ORDER BY ID DESC limit {$offset},{$lenght}";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
      echo '<!-- 右侧布局 -->
      <div class="right-nav">
        <table class="table">
          <thead>
            <tr>
              <th>邀请码</th>
              <th>状态</th>
              <th>使用时间</th>
              <th>天数</th>
              <th style="text-align: center;">操作</th>
            </tr>
          </thead>
          <tbody>';

          // 遍历数据
          while($row = $result->fetch_assoc()) {
            $yqm = $row["yqm"];
            $yqm_usetime = $row["yqm_usetime"];
            $yqm_daynum = $row["yqm_daynum"];
            $yqm_status = $row["yqm_status"];

            // 渲染到UI
            echo '<tr>';
              echo '<td class="td-title">'.$yqm.'</td>';
              if ($yqm_status == 1) {
                echo '<td class="td-status"><span class="badge badge-success">未用</span></td>';
              }else{
                echo '<td class="td-status"><span class="badge badge-danger">已用</span></td>';
              }
              echo '<td class="td-status">'.$yqm_usetime.'</td>
              <td class="td-fwl">'.$yqm_daynum.'</td>
              <td class="td-caozuo" style="text-align: center;">
              <div class="btn-group dropleft">
              <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="badge badge-secondary" style="cursor:pointer;">•••</span></span>
              <div class="dropdown-menu">';
              if ($yqm_status == 2) {
                echo '<a class="dropdown-item" href="javascript:;" id="'.$yqm.'" onclick="tyyqm(this);">恢复</a>';
              }else if ($yqm_status == 1) {
                echo '<a class="dropdown-item" href="javascript:;" id="'.$yqm.'" onclick="tyyqm(this);">停用</a>';
              }
                echo '<a class="dropdown-item" href="javascript:;" id="'.$yqm.'" onclick="delyqm(this);" title="点击后马上就删除的哦！">删除</a>
              </div>
              </div>
              </td>';
            echo '</tr>';
          }

          // 分页
          echo '<div class="fenye"><ul class="pagination pagination-sm">';
          if ($page == 1 && $allpage == 1) {
            // 当前页面是第一页，并且仅有1页
            // 不显示翻页控件
          }else if ($page == 1) {
            // 当前页面是第一页，还有下一页
            echo '<li class="page-item"><a class="page-link" href="./yqm.php">首页</a></li>
            <li class="page-item"><a class="page-link" href="./yqm.php?p='.$nextpage.'">下一页</a></li>
            <li class="page-item"><a class="page-link" href="#">当前是第'.$page.'页</a></li>';
          }else if ($page == $allpage) {
            // 当前页面是最后一页
            echo '<li class="page-item"><a class="page-link" href="./yqm.php">首页</a></li>
            <li class="page-item"><a class="page-link" href="./yqm.php?p='.$prepage.'">上一页</a></li>
            <li class="page-item"><a class="page-link" href="#">当前页面是最后一页</a></li>';
          }else{
            echo '<li class="page-item"><a class="page-link" href="./yqm.php">首页</a></li>
            <li class="page-item"><a class="page-link" href="./yqm.php?p='.$prepage.'">上一页</a></li>
            <li class="page-item"><a class="page-link" href="./yqm.php?p='.$nextpage.'">下一页</a></li>
            <li class="page-item"><a class="page-link" href="#">当前是第'.$page.'页</a></li>';
          }
          echo '</ul></div></div></tbody></table>';

  }else{
    echo '<div class="right-nav">暂无邀请码</div>';
  }

echo '</div>';
}else{
  // 跳转到登陆界面
  header("Location:login.php");
}
?>

<!-- 导入邀请码 -->
<div class="modal fade" id="creat_yqm">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
 
      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">导入邀请码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form onsubmit="return false" id="daoru_yqm" enctype="multipart/form-data">
      <!-- 模态框主体 -->
      <div class="modal-body">
        <!-- txt导入 -->
        <div class="upload_txt">
          上传txt文件
          <input type="file" class="upload_txt_file" id="select_txt" name="file">
        </div>
        <!-- 上传格式提示 -->
        <p>* 每行格式：邀请码|可用天数</p>
        <p>* 例如：abcdefg|3</p>
        <p>* 一行一个，建议每次最多上传100行，太多上传容易出错。</p>
        <p>* 最后一个邀请码不能有换行（回车），否则会被识别为空值导入。</p>
        <p>* 示例文件：<a href="./yqm.txt" download="yqm">点击下载</a></p>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- 清空邀请码 -->
<div class="modal fade" id="clean_yqm">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
 
      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">确定要清空吗？</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- 模态框主体 -->
      <div class="modal-body"><button class="btn btn-dark" style="margin:10px auto;display: block;" onclick="clean_yqm();">立即清空</button></div>
    </div>
    
    <!-- 处理反馈 -->
    <div class="alert"></div>
  </div>
</div>

<!-- 生成邀请码 -->
<div class="modal fade" id="shengcheng_yqm">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content">
 
      <!-- 模态框头部 -->
      <div class="modal-header">
        <h4 class="modal-title">生成邀请码</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- 模态框主体 -->
      <div class="modal-body">
        <form onsubmit="return false" id="addyqm">
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">邀请码</span>
          </div>
          <input type="text" class="form-control" placeholder="请生成邀请码" id="yqm" name="yqm">
        </div>

        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">可用天数</span>
          </div>
          <input type="text" class="form-control" placeholder="注册后可以使用的天数" id="tianshu" name="tianshu">
        </div>
        <button class="btn btn-dark" style="margin:10px auto;display: block;" onclick="addyqm();">立即生成</button>
        </form>
      </div>

      <!-- 处理反馈 -->
      <div class="alert"></div>
    </div>
  </div>
</div>

<script>

// 延迟关闭信息提示框
function closesctips(){
  $("#Result").css('display','none');
}

function closesctips_yqm(){
  $("#shengcheng_yqm .alert").css('display','none');
}

function reload_yqmpage(){
  location.reload();
}

// 生成邀请码
function creatstr(){
  var yqmstr = Math.random().toString(36).slice(-10);
  $("#yqm").val(yqmstr);
}

// 将邀请码提交到数据库
function addyqm(){
  $.ajax({
      type: "POST",
      url: "../api/admin/creat_yqm.php",
      data: $('#addyqm').serialize(),
      success: function (data) {
        if (data.code == 200) {
          $("#shengcheng_yqm .alert").css("display","block");
          $("#shengcheng_yqm .alert").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
          location.reload();
        }else{
          $("#shengcheng_yqm .alert").css("display","block");
          $("#shengcheng_yqm .alert").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
        }
      },
      error : function() {
        // 失败
        $("#shengcheng_yqm .alert").css("display","block");
        $("#shengcheng_yqm .alert").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
      }
  });
  // 关闭信息提示框
  setTimeout('closesctips_yqm()', 2000);
}

// 清空邀请码
function clean_yqm(){
  $.ajax({
      type: "POST",
      url: "../api/admin/clean_yqm.php",
      success:function(data){
        if (data.code == 200) {
          $("#clean_yqm .modal-body").html("<h2 style='text-align:center;'>"+data.msg+"</h2>");
          setTimeout('reload_yqmpage()', 1000);
        }else{
          $("#clean_yqm .modal-body").html("<h2 style='text-align:center;'>"+data.msg+"</h2>");
        }
      },
      error:function(){
        $("#clean_yqm .modal-body").html("<h2>服务器发生错误</h2>");
      },
      beforeSend:function(){
        $("#clean_yqm .modal-body").html("<h3 style='text-align:center;'>正在导入...</h3>");
      }
  });
}

// 更新邀请码状态
function tyyqm(event){
  // 获得当前点击的邀请码
  var this_yqm = event.id;
  $.ajax({
      type: "GET",
      url: "../api/admin/ty_yqm.php?yqm="+this_yqm,
      success: function (data) {
        // 处理成功
        $("#Result").css("display","block");
        $("#Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
        location.reload();
      },
      error : function() {
        // 处理失败
        $("#Result").css("display","block");
        $("#Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
      }
  });
  // 关闭信息提示框
  setTimeout('closesctips()', 2000);
}

// 删除邀请码
function delyqm(event){
  // 获得当前点击的邀请码
  var del_yqm = event.id;
  // 执行删除动作
  $.ajax({
      type: "GET",
      url: "../api/admin/del_yqm.php?yqm="+del_yqm,
      success: function (data) {
        if (data.code == "100") {
          $("#Result").css("display","block");
          $("#Result").html("<div class=\"alert alert-success\"><strong>"+data.msg+"</strong></div>");
          // 刷新列表
          location.reload();
        }else{
          $("#Result").css("display","block");
          $("#Result").html("<div class=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
        }
      },
      error : function() {
        $("#Result").css("display","block");
        $("#Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
      }
  });
  // 关闭信息提示框
  setTimeout('closesctips()', 2000);
}

// 上传txt
var txt_lunxun = setInterval("upload_txt()",2000);
  function upload_txt() {
  var txt_filename = $("#select_txt").val();
  if (txt_filename) {
    clearInterval(txt_lunxun);
    var daoru_txt_form = new FormData(document.getElementById("daoru_yqm"));
    $.ajax({
      url:"../api/admin/daoru.php",
      type:"post",
      data:daoru_txt_form,
      cache: false,
      processData: false,
      contentType: false,
      success:function(data){
        if (data.code == 200) {
          $("#creat_yqm .modal-body").html("<h2 style='text-align:center;'>"+data.msg+"</h2>");
          setTimeout('reload_yqmpage()', 1000);
        }else{
          $("#creat_yqm .modal-body").html("<h2 style='text-align:center;'>"+data.msg+"</h2>");
        }
      },
      error:function(){
        $("#creat_yqm .modal-body").html("<h2>服务器发生错误</h2>");
      },
      beforeSend:function(){
        $("#creat_yqm .modal-body").html("<h3 style='text-align:center;'>正在导入...</h3>");
      }
    })
  }else{
    // console.log("等待上传");
  }
}
</script>
</body>
</html>
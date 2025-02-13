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
      <li class="breadcrumb-item active" aria-current="page">续费套餐管理</li>
    </ol>
  </nav>
  <p>管理套餐详情，有效期，金额等</p>
  
  <!-- 左右布局 -->
  <!-- 左侧布局 -->
  <div class="left-nav">
    <button type="button" class="btn btn-dark">套餐列表</button>
    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#add_taocan">添加套餐</button>
    <button type="button" class="btn btn-light"><a href="./">返回首页</a></button>
  </div>';

  // 获取套餐列表
  $sql = "SELECT * FROM qrcode_package ORDER BY ID DESC";
  $result = $conn->query($sql);
  
  if ($result->num_rows > 0) {
      echo '<!-- 右侧布局 -->
      <div class="right-nav">
        <table class="table">
          <thead>
            <tr>
              <th>套餐标题</th>
              <th>ID</th>
              <th>续期天数</th>
              <th>价格</th>
              <th style="text-align: center;">操作</th>
            </tr>
          </thead>
          <tbody>';

          // 遍历数据
          while($row = $result->fetch_assoc()) {
            $tc_id = $row["tc_id"];
            $tc_days = $row["tc_days"];
            $tc_title = $row["tc_title"];
            $tc_price = $row["tc_price"];

            // 渲染到UI
            echo '<tr>';
              echo '<td class="td-title" style="width:170px;">'.$tc_title.'</td>
              <td class="td-fwl">'.$tc_id.'</td>
              <td class="td-fwl">'.$tc_days.'</td>
              <td class="td-fwl">'.$tc_price.'</td>
              <td class="td-caozuo" style="text-align: center;">
              <div class="btn-group dropleft">
              <span data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="badge badge-secondary" style="cursor:pointer;">•••</span></span>
              <div class="dropdown-menu">
              <a class="dropdown-item" href="javascript:;" data-toggle="modal" data-target="#edi_taocan" id="'.$tc_id.'" onclick="get_taocan_info(this);">编辑</a>
              <a class="dropdown-item" href="javascript:;" id="'.$tc_id.'" onclick="del_taocan(this);" title="点击后马上就删除的哦！">删除</a>
              </div>
              </div>
              </td>';
            echo '</tr>';
          }
          echo '</div>
          </tbody>
          </table>';
          echo "说明：价格格式请保留后两位，例如0.01、1.00、9.90、39.99、100.00等。";

  }else{
    echo '<div class="right-nav">暂无套餐</div>';
  }

  echo '<!-- 编辑套餐模态框 -->
  <div class="modal fade" id="edi_taocan">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
   
        <!-- 模态框头部 -->
        <div class="modal-header">
          <h4 class="modal-title">编辑套餐信息</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
   
        <!-- 模态框主体 -->
        <div class="modal-body">
          <!-- 邮箱 -->
          <form onsubmit="return false" id="edi_taocan_val">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">套餐标题</span>
            </div>
            <input type="email" class="form-control" placeholder="请输入套餐标题" name="tc_title" id="tc_title">
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">续期时长</span>
            </div>
            <input type="email" class="form-control" placeholder="请输入续期时长（天）" name="tc_days" id="tc_days">
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">套餐价格</span>
            </div>
            <input type="email" class="form-control" placeholder="请输入套餐价格" name="tc_price" id="tc_price">
          </div>

          <input type="hidden" name="tc_id" id="tc_id"/>

          <!-- 提交 -->
          <button type="button" class="btn btn-dark" onclick="edi_taocan();">更新套餐</button>
          </form>
        </div>
   
      </div>
    </div>
  </div>

  <!-- 添加套餐 -->
  <div class="modal fade" id="add_taocan">
    <div class="modal-dialog modal-dialog-centered modal-sm">
      <div class="modal-content">
   
        <!-- 模态框头部 -->
        <div class="modal-header">
          <h4 class="modal-title">添加套餐</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
   
        <!-- 模态框主体 -->
        <div class="modal-body">
          <!-- 邮箱 -->
          <form onsubmit="return false" id="taocan_val">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">套餐标题</span>
            </div>
            <input type="text" class="form-control" placeholder="请输入套餐标题" name="tc_title">
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">续期时长</span>
            </div>
            <input type="text" class="form-control" placeholder="请输入续期时长（天）" name="tc_days">
          </div>

          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">套餐价格</span>
            </div>
            <input type="text" class="form-control" placeholder="请输入套餐价格" name="tc_price">
          </div>

          <!-- 提交 -->
          <button type="button" class="btn btn-dark" onclick="add_taocan();">添加套餐</button>
          </form>
        </div>
   
      </div>
    </div>
  </div>

</div>';
}else{
  // 跳转到登陆界面
  header("Location:login.php");
}
?>

<script>
// 延迟关闭信息提示框
function closesctips(){
  $("#Result").css('display','none');
}


// 获得套餐信息
function get_taocan_info(event){
  var get_tc_id = event.id;
  $.ajax({
      type: "GET",
      url: "../api/admin/get_taocan_info.php?tcid="+get_tc_id,
      success: function (data) {
        // 获取成功
        if (data.code==100) {
          $("#tc_title").val(data.tc_title);
          $("#tc_days").val(data.tc_days);
          $("#tc_price").val(data.tc_price);
          $("#tc_id").val(get_tc_id);
        }else{
          $("#Result").css("display","block");
          $("#Result").html("<div cout_trade_nolass=\"alert alert-danger\"><strong>"+data.msg+"</strong></div>");
        }
      },
      error : function() {
        // 获取失败
        $("#Result").css("display","block");
        $("#Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
      }
  });
  // 关闭信息提示框
  setTimeout('closesctips()', 2000);
}


// 更新套餐信息
function edi_taocan(){
  $.ajax({
      type: "POST",
      url: "../api/admin/update_taocan.php",
      data: $('#edi_taocan_val').serialize(),
      success: function (data) {
        // 更新成功
        if (data.code==100) {
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
        // 更新失败
        $("#Result").css("display","block");
        $("#Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
      }
  });
  // 关闭信息提示框
  setTimeout('closesctips()', 2000);
}


// 删除套餐
function del_taocan(event){
  // 获得当前点击的套餐id
  var del_tcid = event.id;
  // 执行删除动作
  $.ajax({
      type: "GET",
      url: "../api/admin/del_taocan.php?tcid="+del_tcid,
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


// 添加套餐
function add_taocan(){
  $.ajax({
      type: "POST",
      url: "../api/admin/add_taocan.php",
      data: $('#taocan_val').serialize(),
      success: function (data) {
        // 添加成功
        if (data.code==100) {
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
        // 添加失败
        $("#Result").css("display","block");
        $("#Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
      }
  });
  // 关闭信息提示框
  setTimeout('closesctips()', 2000);
}

</script>
</body>
</html>
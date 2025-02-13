<!DOCTYPE html>
<html>
<head>
  <title>用户管理后台 - 二维码管理系统</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <script src="../assets/js/jquery.min.js"></script>
  <script src="../assets/js/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
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
  include '../db_config/VersionCheck.php';

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
<div class="container">';
  if ($version !== $v_str_v) {
    echo '<br/>
    <div class="alert alert-warning">
      <strong>'.$v_str_m.'<a href="'.$v_str_u.'">点击更新</a></strong>
    </div>';
  }
  echo '<br/>
  <h3>二维码管理系统后台 / 系统设置 / SEO设置</h3> 
  <p>设置系统的全局参数，标题、描述、关键词、浏览器图标</p>
  
  <!-- 左右布局 -->
  <!-- 电脑端横排列表 -->
  <div class="left-nav">
    <button type="button" class="btn btn-dark">SEO设置</button>
    <a href="./set.php"><button type="button" class="btn btn-light">返回上一页</button></a>
    <a href="./index.php"><button type="button" class="btn btn-light">返回首页</button></a>
  </div>';

  // 获取设置参数
  $sql_setval = "SELECT * FROM qrcode_settings";
  $result_setval = $conn->query($sql_setval);

  if ($result_setval->num_rows > 0) {
    // 如果有参数
    while($row_setval = $result_setval->fetch_assoc()) {
      $title = $row_setval["title"];
      $keywords = $row_setval["keywords"];
      $description = $row_setval["description"];
      $favicon = $row_setval["favicon"];
    }

    echo '<!-- 右侧布局 -->
  <form onsubmit="return false" id="setval">
  <div class="right-nav">
    
    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">浏览器标题</span>
      </div>
      <input type="text" class="form-control" placeholder="请设置网站标题（title）" value="'.$title.'" name="title">
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">SEO关键词</span>
      </div>
      <input type="text" class="form-control" placeholder="请设置SEO所需的关键词，用逗号隔开（keywords）" value="'.$keywords.'" name="keywords">
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">系统描述</span>
      </div>
      <input type="text" class="form-control" placeholder="简单描述本套系统（description）" value="'.$description.'" name="description">
    </div>

    <div class="input-group mb-3">
      <div class="input-group-prepend">
        <span class="input-group-text">浏览器icon</span>
      </div>
      <input type="text" class="form-control" placeholder="即浏览器标题显示的logo，请粘贴图片URL（image/x-icon）" value="'.$favicon.'" name="favicon">
    </div>
    <button type="submit" class="btn btn-dark" onclick="setval();">提交设置</button>
  </div>
  </form>';
  }else{
    // 如果没有参数
    echo '<form onsubmit="return false" id="setval">
    <div class="right-nav">
      
      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">浏览器标题</span>
        </div>
        <input type="text" class="form-control" placeholder="请设置网站标题（title）" name="title">
      </div>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">SEO关键词</span>
        </div>
        <input type="text" class="form-control" placeholder="请设置SEO所需的关键词，用逗号隔开（keywords）" name="keywords">
      </div>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">系统描述</span>
        </div>
        <input type="text" class="form-control" placeholder="简单描述本套系统（description）" name="description">
      </div>

      <div class="input-group mb-3">
        <div class="input-group-prepend">
          <span class="input-group-text">浏览器icon</span>
        </div>
        <input type="text" class="form-control" placeholder="即浏览器标题显示的logo，请粘贴图片URL（image/x-icon）" name="favicon">
      </div>
      <button type="submit" class="btn btn-dark" onclick="setval();">提交设置</button>
    </div>
    </form>';
  }

}else{
  // 跳转到登陆界面
  header("Location:login.php");
}
?>

</div>

<script>
// 延迟关闭信息提示框
function closesctips(){
  $("#Result").css('display','none');
}

// 设置支付接口
function setval(){
  $.ajax({
      type: "POST",
      url: "../api/admin/seo_set.php",
      data: $('#setval').serialize(),
      success: function (data) {
        // 设置成功
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
        // 设置失败
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
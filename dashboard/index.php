<?php
  // 页面字符编码
  header("Content-type:text/html;charset=utf-8");
  include '../includes/common.php';
  // 数据库配置
  include '../db_config/db_config.php';

  // 创建连接
  $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

  // 获取设置项
  $sql_set = "SELECT * FROM qrcode_settings";
  $result_set = $conn->query($sql_set);
  if ($result_set->num_rows > 0) {
    while($row_set = $result_set->fetch_assoc()) {
      $title = $row_set['title'];
      $keywords = $row_set['keywords'];
      $description = $row_set['description'];
      $favicon = $row_set['favicon'];
    }
    if ($title == null || empty($title) || $title == '') {
        $title = "二维码管理系统";
        $keywords = "活码,群活码,微信群活码系统,活码系统,群活码,不过期的微信群二维码,永久群二维码";
        $description = "这是一套开源、免费、可上线运营的二维码管理系统，便于协助自己、他人进行微信私域流量资源获取，更大化地进行营销推广活动！降低运营成本，提高工作效率，获取更多资源。";
        $favicon = "../assets/images/favicon.png";
    }
  }else{
    $title = "二维码管理系统";
    $keywords = "活码,群活码,微信群活码系统,活码系统,群活码,不过期的微信群二维码,永久群二维码";
    $description = "这是一套开源、免费、可上线运营的二维码管理系统，便于协助自己、他人进行微信私域流量资源获取，更大化地进行营销推广活动！降低运营成本，提高工作效率，获取更多资源。";
    $favicon = "../assets/images/favicon.png";
  }

?>
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
  <link rel="stylesheet" type="text/css" href="../assets/css/huoma.css">
  <meta name="keywords" content="<?php echo $keywords; ?>">
  <meta name="description" content="<?php echo $description; ?>">
  <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
</head>
<body>

<!-- 全局信息提示框 -->
<div id="Result" style="display: none;"></div>

<?php
// 判断登录状态
session_start();
if(isset($_SESSION["session_admin"])){

  // 数据库配置
  include '../db_config/db_config.php';

  // 创建连接
  $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

  // 获取总用户数
  $sql_total_user = "SELECT * FROM qrcode_user";
  $result_total_user = $conn->query($sql_total_user);
  $total_user_num = $result_total_user->num_rows;

  // 获取今天新增用户数
  $today_date = date("Y-m-d");
  $sql_today_reg = "SELECT * FROM qrcode_user WHERE reg_time LIKE '%$today_date%'";
  $result_today_reg = $conn->query($sql_today_reg);
  $today_reg_num = $result_today_reg->num_rows;

  // 获取今天收款数
  $sql_today_pay = "SELECT pay_money FROM qrcode_order WHERE pay_time LIKE '%$today_date%'";
  $result_today_pay = $conn->query($sql_today_pay);
  if ($result_today_pay->num_rows > 0) {
    $pay_nums = 0;
    while($row_today_pay = $result_today_pay->fetch_assoc()) {
      $pay_nums = $pay_nums+$row_today_pay['pay_money'];
    }
  }else{
      $pay_nums = "0";
  }

  echo '<!-- 顶部导航栏 -->
<div id="topbar">
  <div class="container">
    <span class="topbar-title"><a href="./">二维码管理系统后台</a></span>
    <span class="topbar-login-link">'.$_SESSION["session_admin"].'<a href="logout.php">退出</a></span>
  </div>
</div>

<!-- 操作区 -->
<div class="container">';
  echo '<br/>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="./">二维码管理系统</a></li>
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
  </nav>

  <p>便捷管理用户创建的活码数据、用户账号、查看数据</p>
  
  <!-- 左右布局 -->
  <!-- 电脑端横排列表 -->
  <div class="left-nav">
    <a href="index.php" class="btn btn-dark">数据看板</a>
    <a href="qun.php" class="btn btn-light">微信群活码</a>
    <a href="wx.php" class="btn btn-light">客服活码</a>
    <a href="active.php" class="btn btn-light">活动码</a>
    <a href="user.php" class="btn btn-light">用户管理</a>
    <a href="order.php" class="btn btn-light">订单管理</a>
    <a href="taocan.php" class="btn btn-light">续费套餐</a>
    <a href="yqm.php" class="btn btn-light">邀请码</a>
    <a href="addons.php" class="btn btn-light">插件中心</a>
    <a href="set.php" class="btn btn-light">系统设置</a>
  </div>';

  echo '<!-- 右侧布局 -->
  <div class="right-nav">
    <div class="jumbotron" style="padding:30px 20px 10px 20px;">
      <h2>欢迎使用二维码管理系统</h2> 
      <p>这是一套开源、免费、可上线运营的二维码管理系统，便于协助自己、他人进行微信私域流量资源获取，更大化地进行营销推广活动！降低运营成本，提高工作效率，获取更多资源。</p> 
    </div>
    <!-- 数据看板 -->
    <div class="data-board">
      <div class="alert alert-success">
        <div class="title"><h5>总用户</h5></div>
        <div class="num"><h3>'.$total_user_num.'</h3></div>
      </div>
      <div class="alert alert-primary">
        <div class="title"><h5>今日新增</h5></div>
        <div class="num"><h3>'.$today_reg_num.'</h3></div>
      </div>
      <div class="alert alert-warning">
        <div class="title"><h5>今日收款</h5></div>
        <div class="num"><h3>¥'.$pay_nums.'</h3></div>
      </div>
    </div>
    <p><a href="' . $support_url . '" target="_blank">用户反馈：' . $support_url . '</a></p>
    <p><a href="' . $github_url . '" target="_blank">Github开源地址：' . $github_url . '</a></p>
  </div>';
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

//监听个人微信二维码的显示状态
$("#grwx_status").bind('input propertychange',function(e){
  //获取当前点击的状态
  var grwx_status = $(this).val();
  //如果开启备用群，则需要显示上传二维码和设置最大值
  if (grwx_status == 1) {
    $("#grwx_upload").css("display","block");
  }else if (grwx_status == 2) {
    //否则隐藏，不显示
    $("#grwx_upload").css("display","none");
  }
})

// 删除群活码
function delqun(event){
  // 获得当前点击的群活码id
  var del_qun_hmid = event.id;
  // 执行删除动作
  $.ajax({
      type: "GET",
      url: "../api/admin/del_qun.php?hmid="+del_qun_hmid,
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

// 分享群活码
function sharequn(event){
  // 获得当前点击的群活码id
  var share_qun_hmid = event.id;
  $.ajax({
      type: "GET",
      url: "../api/admin/share_qun.php?hmid="+share_qun_hmid,
      success: function (data) {
        // 分享成功
        $("#share_qun .modal-body .link").text("链接："+data.url+"");
        $("#share_qun .modal-body .qrcode").html("<img src='./qrcode.php?content="+data.url+"' width='200'/>");
      },
      error : function() {
        // 分享失败
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
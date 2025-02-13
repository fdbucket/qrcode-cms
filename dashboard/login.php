<!DOCTYPE html>
<html>
<head>
  <title>登陆 - 二维码管理系统</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <script src="../assets/js/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="../assets/css/loginreg.css">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
</head>
<body>

<!-- 操作区 -->
<div class="container">
  <h2>二维码管理系统</h2>
  <!-- 登录面板 -->
  <div class="pannel">
    <div class="left">
      <img src="../assets/images/loginlogo.png" />
    </div>
    <div class="right">
      <div class="form-con">
        <form onsubmit="return false" id="login-form">
        <br/>
        <!-- 账号 -->
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">账号</span>
          </div>
          <input type="text" class="form-control" placeholder="请输入账号" name="user">
        </div>
        <!-- 密码 -->
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text">密码</span>
          </div>
          <input type="password" class="form-control" placeholder="请输入密码" name="pwd">
        </div>
        <!-- 登陆按钮 -->
        <button type="submit" class="btn btn-dark" style="width: 100%;" onclick="logincheck();">登陆</button>
        <!-- 找回密码、注册账号 -->
        <p class="click"><a href="">找回密码</a>&nbsp;&nbsp;<a href="reg/">注册账号</a></p>
        </form>
      </div>
    </div>
  </div>
  <!-- 信息提示框 -->
  <div class="Result" style="display: none;"></div>
</div>

<!-- ajax登录验证 -->
<script>
function logincheck(){
    $.ajax({
        type: "POST",
        url: "../api/admin/login.php",
        data: $('#login-form').serialize(),
        success:function(data){
          // 登录成功
          if (data.code == 100) {
            $(".container .Result").css("display","block");
            $(".container .Result").html('<div class="alert alert-success"><strong>'+data.msg+'</strong></div>');
            location.href="./index.php";
          }else{
            // 登陆失败
            $(".container .Result").css("display","block");
            $(".container .Result").html('<div class="alert alert-danger"><strong>'+data.msg+'</strong></div>');
          }
        },
        error:function(data) {
          // 服务器发生错误
          $(".container .Result").css("display","block");
          $(".container .Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
        }
    });
}
</script>
</body>
</html>
<!DOCTYPE html>
<html>

<head>
    <title>注册账号 - 二维码管理系统</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/loginreg.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme.css">
</head>

<body>
    <!-- 操作区 -->
    <div class="container">
        <h2>注册账号</h2>
        <!-- 登录面板 -->
        <div class="pannel-reg">
            <div class="left">
                <img src="../../assets/images/loginlogo.png" />
            </div>
            <div class="right">
                <div class="form-con">
                    <form onsubmit="return false" id="regcheck">
                        <br />
                        <!-- 账号 -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">账<span style="opacity: 0;">占</span>号</span>
                            </div>
                            <input type="text" class="form-control" placeholder="请输入账号" name="user">
                        </div>
                        <!-- 密码 -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">密<span style="opacity: 0;">占</span>码</span>
                            </div>
                            <input type="text" class="form-control" placeholder="请输入密码" name="pwd">
                        </div>
                        <!-- 邮箱 -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">邮<span style="opacity: 0;">占</span>箱</span>
                            </div>
                            <input type="email" class="form-control" placeholder="请输入邮箱" name="email">
                        </div>
                        <!-- 邀请码 -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">邀请码</span>
                            </div>
                            <input type="text" class="form-control" placeholder="请输入邀请码" name="yqm">
                        </div>
                        <!-- 注册按钮 -->
                        <button type="submit" class="btn btn-tjzdy" style="width: 100%;" onclick="regcheck();">注册账号</button>
                        <p class="click"><a href="../getyqm.html">购买邀请码</a>&nbsp;&nbsp;<a href="login.php">登陆账号</a></p>
                </div>
                </form>
            </div>
        </div>
        <!-- 信息提示框 -->
        <div class="Result" style="display: none;"></div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <!-- ajax登录验证 -->
    <script>
        function regcheck() {
            $.ajax({
                type: "POST",
                url: "../api/user/regcheck.php",
                data: $('#regcheck').serialize(),
                success: function(data) {
                    // 登录成功
                    if (data.code == 100) {
                        $(".container .Result").css("display", "block");
                        $(".container .Result").html('<div class="alert alert-success"><strong>' + data.msg + '</strong></div>');
                        location.href = "../../user/";
                    } else {
                        // 登陆失败
                        $(".container .Result").css("display", "block");
                        $(".container .Result").html('<div class="alert alert-danger"><strong>' + data.msg + '</strong></div>');
                    }
                },
                error: function(data) {
                    // 服务器发生错误
                    $(".container .Result").css("display", "block");
                    $(".container .Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
                }
            });
        }
    </script>
</body>

</html>
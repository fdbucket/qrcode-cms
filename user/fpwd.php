<!DOCTYPE html>
<html>

<head>
    <title>找回密码 - 二维码管理系统</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/loginreg.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme.css">
</head>

<body>
    <!-- 操作区 -->
    <div class="container">
        <h2>找回密码</h2>
        <!-- 登录面板 -->
        <div class="pannel">
            <div class="left">
                <img src="../assets/images/loginlogo.png" />
            </div>
            <div class="right">
                <div class="form-con">
                    <form onsubmit="return false" id="logincheck">
                        <br />
                        <!-- 账号 -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">账号</span>
                            </div>
                            <input type="text" class="form-control" placeholder="请输入账号" name="user">
                        </div>
                        <!-- 邮箱 -->
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">邮箱</span>
                            </div>
                            <input type="email" class="form-control" placeholder="请输入邮箱" name="email">
                        </div>
                        <!-- 按钮 -->
                        <button type="submit" class="btn btn-tjzdy" style="width: 100%;" onclick="logincheck();">尝试找回密码</button>
                        <!-- 找回密码、注册账号 -->
                        <p class="click"><a href="login.php">登陆账号</a>&nbsp;&nbsp;<a href="reg.php">注册账号</a></p>
                    </form>
                </div>
            </div>
        </div>
        <!-- 信息提示框 -->
        <div class="Result" style="display: none;"></div>
    </div>

    <script src="../assets/js/jquery.min.js"></script>
    <!-- ajax登录验证 -->
    <script>
        function logincheck() {
            $.ajax({
                type: "POST",
                url: "../api/user/fpwdcheck.php",
                data: $('#logincheck').serialize(),
                success: function(data) {
                    // 找回成功
                    if (data.code == 100) {
                        $(".container .Result").css("display", "block");
                        $(".container .Result").html('<div class="alert alert-success"><strong>' + data.msg + '</strong></div>');
                    } else {
                        // 找回失败
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
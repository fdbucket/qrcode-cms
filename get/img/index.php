<?php
// 页面字符编码
header("Content-type:text/html;charset=utf-8");
// 获取参数
$img_id = $_GET["imgid"];
// 验证是否有参数
if (trim(empty($img_id))) {
    echo "参数错误";
    exit;
}
// 数据库配置
include '../../db_config/db_config.php';

// 创建连接
$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

if ($conn->connect_error) {
    die("数据库连接失败: " . $conn->connect_error);
}

// 获取二维码信息
$result_img_info = $conn->query("SELECT * FROM qrcode_img WHERE img_id={$img_id}");
while ($row_hminfo = $result_img_info->fetch_assoc()) {
    $img_status = $row_hminfo["img_status"]; // 微信活码启用状态
    $img_title = $row_hminfo["img_title"]; // 微信活码标题
    $img_user = $row_hminfo["img_user"]; // 发布者
    $img_moshi = $row_hminfo["img_moshi"]; // 展示模式
    $img_online = $row_hminfo["img_online"]; // 展示模式
}

// 获取客服子码信息
$sql_zminfo = "SELECT * FROM qrcode_imgs WHERE img_id = '$img_id' AND zima_status = '1'";
$result_zminfo = $conn->query($sql_zminfo);

// 更新活码访问量
mysqli_query($conn, "UPDATE qrcode_img SET img_fwl=img_fwl+1 WHERE img_id =" . $img_id);

// 获取用户账号信息
// 判断用户账号到期
$sql_userinfo = "SELECT * FROM qrcode_user WHERE user = '$img_user'";
$result_userinfo = $conn->query($sql_userinfo);
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="color-scheme" content="light dark">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0,viewport-fit=cover">
    <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/weixin.ico">
    <link rel="mask-icon" href="../../assets/images/weixin.svg" color="#4C4C4C">
    <link rel="apple-touch-icon-precomposed" href="../../assets/images/weixin.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="../../assets/css/common.css">
</head>

<body>
    <?php

    if ($result_userinfo->num_rows > 0) {
        while ($row_userinfo = $result_userinfo->fetch_assoc()) {
            $user_status = $row_userinfo["user_status"]; // 账号状态
            $expire_time = $row_userinfo["expire_time"]; // 到期日期
        }
        if ($user_status !== '1') {
            echo '<br/><br/><br/>
            <div id="tips_icon"><img src="../../assets/images/warning.png" /></div>
            <div id="tips_text">账号异常</div>';
            exit;
        }
        if (strtotime(date("Y-m-d")) >= strtotime($expire_time)) {
            echo '<br/><br/><br/>
                    <div id="tips_icon"><img src="../../assets/images/warning.png" /></div>
                <div id="tips_text">账号已到期</div>';
            exit;
        }
    } else {
        echo '<br/><br/><br/>
                <div id="tips_icon"><img src="../../assets/images/warning.png" /></div>
            <div id="tips_text">账号不存在</div>';
        exit;
    }
    ?>
    <?php
    // 验证该活码是否存在
    if ($result_img_info->num_rows > 0) {
        /**
         * 验证群活码的状态
         * img_status=1 开启
         * img_status=2 关闭
         * img_status=3 停用
         */
        if ($img_status == '1') {

            // 定义一个数组，用来储存所有子码
            $kfzmlist = array();

            // 获取子码
            while ($row_zminfo = $result_zminfo->fetch_assoc()) {

                // 将所有子码添加到数组
                $kfzmlist[] = $row_zminfo;
            }

            // 定义一个数组，用来储存经过条件筛选后的子码
            $kfzm = [];

            // 展示模式
            if ($img_moshi == '1') {

                // 阈值模式
                // 遍历所有符合以下条件的子码
                foreach ($kfzmlist as $k => $v) {
                    if ($kfzmlist[$k]['fwl'] < $kfzmlist[$k]['img_yuzhi']) {

                        // 返回符合条件的数组
                        $kfzm = $kfzmlist[$k];
                        $zmid = $kfzmlist[$k]['zmid'];
                        $qrcodeUrl = $kfzmlist[$k]['qrcode'];
                        $img_num = $kfzmlist[$k]['img_num'];
                        $img_beizhu = trim($kfzmlist[$k]['img_beizhu']);

                        // 设置群活码标题
                        echo '<title>' . $img_title . '</title>';

                        echo '<div id="safety-tips">
                            <div class="safety-icon"><img src="../../assets/images/safety-icon.png" /></div>
                            <div class="safety-title">此二维码已通过安全认证，可以放心扫码</div>
                        </div>
                        <!-- 扫码提示 -->
                        <div id="scan_tips" style="color:#999;">请再次长按下方二维码</div>
                        <!-- 展示二维码 -->
                        <div id="ewm"><img src="' . $qrcodeUrl . '" width="230"/></div>
                        <!-- 加微信 -->
                        <div id="wxnum">客服微信号：' . $img_num . '<div>';

                        // 加微信备注
                        if ($img_beizhu !== '') {
                            echo '<div id="wxbeizhu">' . $img_beizhu . '</div>';
                        }

                        $exist = false;
                        // 更新当前子码的访问量
                        mysqli_query($conn, "UPDATE qrcode_imgs SET fwl=fwl+1 WHERE zmid='$zmid'");

                        // 在线提示
                        date_default_timezone_set('asia/shanghai');
                        $week = date('w');
                        $day = date('md');
                        $time = date('G');

                        // 判断是否在线
                        if ($img_online == '1') {
                            if ($week == 0) {
                                echo '<div id="online_tips">提醒：今天周末休息，可能回复较慢！</div>';
                            } else if ($time >= 9 && $time < 18) {
                                echo '<div id="online_tips_sb">提醒：当前是上班时间，正常接待中！</div>';
                            } else {
                                echo '<div id="online_tips">提醒：当前是下班时间，可能回复较慢！</div>';
                            }
                        }

                        // 跳出循环
                        exit;
                    } else {
                        $exist = false;
                    }
                }
                if (!$exist && count($kfzm) <= 0) {

                    // 设置活码标题
                    echo '<title>提醒</title>
                    <br/><br/><br/>
                    <div id="tips_icon"><img src="../../assets/images/warning.png" /></div>
                    <div id="tips_text">暂无图片可用</div>';
                }
            } else if ($img_moshi == '2') {
                // 将数组打乱
                shuffle($kfzmlist);
                // 遍历数组，取第一个对象
                foreach ($kfzmlist as $k => $v) {
                    $kfzm = $kfzmlist[$k];
                    $zmid = $kfzmlist[$k]['zmid'];
                    $qrcodeUrl = $kfzmlist[$k]['qrcode'];
                    $img_num = $kfzmlist[$k]['img_num'];
                    $img_beizhu = trim($kfzmlist[$k]['img_beizhu']);

                    // 设置群活码标题
                    echo '<title>' . $img_title . '</title>';

                    echo '<div id="safety-tips">
                    <div class="safety-icon">
                        <img src="../../assets/images/safety-icon.png" />
                    </div>
                    <div class="safety-title">此二维码已通过安全认证，可以放心扫码</div>
                    </div>';

                    // 扫码提示
                    echo '<div id="scan_tips" style="color:#999;">请再次识别下方二维码</div>';

                    // 展示二维码
                    echo '<div id="ewm"><img src="' . $qrcodeUrl . '" width="280"/></div>';

                    // 加微信
                    echo '<div id="wxnum">客服微信号：' . $img_num . '<div>';

                    // 加微信备注
                    if ($img_beizhu !== '') {
                        echo '<div id="wxbeizhu">' . $img_beizhu . '<div>';
                    }

                    $exist = false;
                    // 更新当前子码的访问量
                    mysqli_query($conn, "UPDATE qrcode_imgs SET fwl=fwl+1 WHERE zmid='$zmid'");

                    // 判断是否在线
                    if ($img_online == '1') {
                        if ($week == 0) {
                            echo '<div id="online_tips">提醒：今天周末休息，可能回复较慢！</div>';
                        } else if ($time >= 9 && $time < 18) {
                            echo '<div id="online_tips_sb">提醒：当前是上班时间，正常接待中！</div>';
                        } else {
                            echo '<div id="online_tips">提醒：当前是下班时间，可能回复较慢！</div>';
                        }
                    }
                    exit;
                }
                if (!$exist && count($kfzm) <= 0) {

                    // 设置活码标题
                    echo '<title>提醒</title>';
                    echo '<br/><br/><br/>
                            <div id="tips_icon"><img src="../../assets/images/warning.png" /></div>
                            <div id="tips_text">暂无微信可以添加</div>';
                }
            }
        } else if ($img_status == '2') {

            // 设置群活码标题
            echo '<title>提醒</title>';
            echo '<br/><br/><br/>';
            echo '<div id="tips_icon"><img src="../../assets/images/warning.png" /></div>';
            echo '<div id="tips_text">该二维码已被管理员暂停使用</div>';
        } else if ($img_status == '3') {
            // 设置群活码标题
            echo '<title>提醒</title>';
            echo '<br/><br/><br/>';
            echo '<div id="tips_icon"><img src="../../assets/images/error.png" /></div>';
            echo '<div id="tips_text">该二维码因违规已被管理员停止使用</div>';
        }
    } else {
        // 设置群活码标题
        echo '<title>提醒</title>
        <br/><br/><br/>
        <div id="tips_icon"><img src="../../assets/images/error.png" /></div>
        <div id="tips_text">该二维码不存在或已被管理员删除</div>';
    } // 验证该页面是否存在结束
    $conn->close();
    ?>
</body>

</html>
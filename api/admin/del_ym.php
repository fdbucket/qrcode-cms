<?php
// 字符编码是json
header("Content-type:application/json");

// 验证登录状态
session_start();
if (isset($_SESSION["session_admin"])) {

    // 数据库配置
    include '../../db_config/db_config.php';

    // 创建连接
    $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

    // 获得要删除的ymid
    $ymid = $_GET["ymid"];

    if (empty($ymid)) {
        $result = array(
            "code" => "101",
            "msg" => "非法请求"
        );
    } else {
        // 删除活码数据
        mysqli_query($conn, "DELETE FROM qrcode_domain WHERE id=" . $ymid);
        // 返回结果
        $result = array(
            "code" => "100",
            "msg" => "已删除"
        );
    }
} else {
    $result = array(
        "code" => "102",
        "msg" => "未登录"
    );
}

// 输出json格式的数据
echo json_encode($result, JSON_UNESCAPED_UNICODE);

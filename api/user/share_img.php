<?php

include './common.php';

// 获取数据
$img_id = $_GET["imgid"];

if (empty($img_id)) {
    send_result(array(
        "code" => "101",
        "msg" => "非法请求"
    ));
}

// 数据库配置
include '../../db_config/db_config.php';

// 创建连接
$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

// 获取落地页域名
$sql_yuming = "SELECT * FROM qrcode_img WHERE img_id = '$img_id'";
$result_yuming = $conn->query($sql_yuming);
if ($result_yuming->num_rows > 0) {
    while ($row_yuming = $result_yuming->fetch_assoc()) {
        // 生成网址
        $url = $row_yuming["img_ldym"] . $site_path . "/get/img/?imgid=" . $img_id;
        $result = array(
            "code" => "100",
            "msg" => "分享成功",
            "url" => $url
        );
    }
} else {
    $result = array(
        "code" => "103",
        "msg" => "分享发生错误"
    );
}
// 返回结果
send_result($result);

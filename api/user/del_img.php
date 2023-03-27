<?php

include './common.php';

// 获得要删除的imgid
$img_id = $_POST["imgid"];

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
// 删除主码数据
mysqli_query($conn, "DELETE FROM qrcode_img WHERE img_id={$img_id} AND img_user='{$current_user}'");
// 删除子码数据
mysqli_query($conn, "DELETE FROM qrcode_imgs WHERE img_id={$img_id} AND img_user='{$current_user}'");
// 返回结果
send_result(array(
    "code" => "100",
    "msg" => "已删除"
));

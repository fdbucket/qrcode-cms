<?php
// 设置页面返回的字符编码为json格式
header("Content-type:application/json");

// 开启session，验证登录状态
session_start();
if (isset($_SESSION["session_user"])) {

    // 数据库配置
    include '../../db_config/db_config.php';

    // 创建连接
    $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

    // 获得表单POST过来的数据
    $img_title = trim($_POST["img_title"]);
    $img_ldym = trim($_POST["img_ldym"]);
    $img_status = trim($_POST["img_status"]);
    $img_id = trim($_POST["img_id"]);
    $img_moshi = trim($_POST["img_moshi"]);
    $img_online = trim($_POST["img_online"]);

    if (empty($img_title)) {
        $result = array(
            "code" => "101",
            "msg" => "标题不得为空"
        );
    } else if (empty($img_ldym)) {
        $result = array(
            "code" => "102",
            "msg" => "请选择落地域名"
        );
    } else if (empty($img_id)) {
        $result = array(
            "code" => "103",
            "msg" => "非法提交"
        );
    } else if (empty($img_status)) {
        $result = array(
            "code" => "104",
            "msg" => "状态未选择"
        );
    } else if (empty($img_moshi)) {
        $result = array(
            "code" => "105",
            "msg" => "展示模式未选择"
        );
    } else {
        // 当前时间
        $date = date('Y-m-d');
        // 设置字符编码为utf-8
        mysqli_query($conn, "SET NAMES UTF-8");
        // 更新数据库
        mysqli_query($conn, "UPDATE qrcode_img SET img_title='$img_title',img_ldym='$img_ldym',img_status='$img_status',img_update_time='$date',img_moshi='$img_moshi',img_online='$img_online' WHERE img_id=" . $img_id);
        $result = array(
            "code" => "100",
            "msg" => "更新成功"
        );
    }
} else {
    $result = array(
        "code" => "105",
        "msg" => "未登录"
    );
}

// 输出JSON格式的数据
echo json_encode($result, JSON_UNESCAPED_UNICODE);

<?php

// 返回json格式的数据
header("Content-type:application/json");

// 开启session，判断登陆状态
session_start();
if (isset($_SESSION["session_user"])) {

    // 当前登录的用户
    $current_user = $_SESSION["session_user"];

    // 数据库配置
    include '../../db_config/db_config.php';

    // 创建连接
    $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

    // 获得表单POST过来的数据
    $img_title = trim($_POST["img_title"]);
    $img_ldym = trim($_POST["img_ldym"]);
    $img_moshi = trim($_POST["img_moshi"]);

    // 创建活码id和日期
    $img_id = rand(10000, 99999);
    $img_update_time = date("Y-m-d");

    // 过滤表单
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
    } else if (empty($img_moshi)) {
        $result = array(
            "code" => "103",
            "msg" => "请选择展示模式"
        );
    } else {
        // 字符编码设为utf8
        mysqli_query($conn, "SET NAMES UTF-8");
        // 插入数据库
        $sql_creat_img = "INSERT INTO qrcode_img (img_title,img_ldym,img_id,img_moshi,img_update_time,img_user) VALUES ('$img_title','$img_ldym','$img_id','$img_moshi','$img_update_time','$current_user')";

        if ($conn->query($sql_creat_img) === TRUE) {

            // 创建5个子码
            $update_time = date("Y-m-d");
            $conn->query("INSERT INTO qrcode_imgs (img_id, zmid, update_time, xuhao, img_user) VALUES
                ('$img_id','" . rand(10000, 99999) . "','$update_time','1', '{$current_user}'),
                ('$img_id','" . rand(10000, 99999) . "','$update_time','2', '{$current_user}'),
                ('$img_id','" . rand(10000, 99999) . "','$update_time','3', '{$current_user}'),
                ('$img_id','" . rand(10000, 99999) . "','$update_time','4', '{$current_user}'),
                ('$img_id','" . rand(10000, 99999) . "','$update_time','5', '{$current_user}')
            ");

            $result = array(
                "code" => "100",
                "msg" => "创建成功"
            );
        } else {
            $result = array(
                "code" => "105",
                "msg" => "创建失败，数据库发生错误"
            );
        }

        // 断开数据库连接
        $conn->close();
    }
} else {
    $result = array(
        "code" => "106",
        "msg" => "未登录"
    );
}

// 输出JSON格式的数据
echo json_encode($result, JSON_UNESCAPED_UNICODE);

<?php
header("Content-type:application/json");
session_start();

function send_result($result)
{
    exit(json_encode($result, JSON_UNESCAPED_UNICODE));
}

if (!isset($_SESSION["session_user"])) {
    // 未登录
    send_result([
        "code" => "102",
        "msg" => "未登录"
    ]);
}

$site_url = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
$site_path = ''; // '/sitepath' or ''

// 当前登录的用户
$current_user = $_SESSION["session_user"];

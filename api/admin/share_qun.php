<?php
header("Content-type:application/json");
session_start();
if (isset($_SESSION["session_admin"])) {

    // 数据库配置
    include '../../db_config/db_config.php';

    // 创建连接
    $conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

    // 获取数据
    $qun_hmid = $_GET["hmid"];

    if (empty($qun_hmid)) {
        $result = array(
            "result" => "101",
            "msg" => "非法请求"
        );
    } else {
        // 获取落地页域名
        $sql_yuming = "SELECT * FROM qrcode_qun WHERE qun_hmid = '$qun_hmid'";
        $result_yuming = $conn->query($sql_yuming);
        if ($result_yuming->num_rows > 0) {
            while ($row_yuming = $result_yuming->fetch_assoc()) {
                $qun_ldym = $row_yuming["qun_ldym"];
                // 生成网址
                $SERVER = $qun_ldym . $_SERVER["REQUEST_URI"];
                $url = dirname(dirname($SERVER)) . "/get/qun/?hmid=" . $qun_hmid;
                $result = array(
                    "result" => "100",
                    "msg" => "分享成功",
                    "url" => $url
                );
            }
        } else {
            $result = array(
                "result" => "103",
                "msg" => "分享发生错误"
            );
        }
    }
} else {
    $result = array(
        "result" => "102",
        "msg" => "未登录"
    );
}

// 输出JSON格式的数据
echo json_encode($result, JSON_UNESCAPED_UNICODE);

<?php
// 页面字符编码
header("Content-type:text/html;charset=utf-8");

// 数据库配置
include '../db_config/db_config.php';

// 创建连接
$conn = new mysqli($db_url, $db_user, $db_pwd, $db_name);

// 获取设置项
$sql_set = "SELECT * FROM qrcode_settings";
$result_set = $conn->query($sql_set);
if ($result_set->num_rows > 0) {
    while ($row_set = $result_set->fetch_assoc()) {
        $title = $row_set['title'];
        $keywords = $row_set['keywords'];
        $description = $row_set['description'];
        $favicon = $row_set['favicon'];
    }
    if ($title == null || empty($title) || $title == '') {
        $title = "二维码管理系统";
        $keywords = "活码,群活码,微信群活码系统,活码系统,群活码,不过期的微信群二维码,永久群二维码";
        $description = "这是一套开源、免费、可上线运营的二维码管理系统，便于协助自己、他人进行微信私域流量资源获取，更大化地进行营销推广活动！降低运营成本，提高工作效率，获取更多资源。";
        $favicon = "../assets/images/favicon.png";
    }
} else {
    $title = "二维码管理系统";
    $keywords = "活码,群活码,微信群活码系统,活码系统,群活码,不过期的微信群二维码,永久群二维码";
    $description = "这是一套开源、免费、可上线运营的二维码管理系统，便于协助自己、他人进行微信私域流量资源获取，更大化地进行营销推广活动！降低运营成本，提高工作效率，获取更多资源。";
    $favicon = "../assets/images/favicon.png";
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>编辑个人微信活码 - <?php echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../assets/css/huoma.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/theme.css">
    <meta name="keywords" content="<?php echo $keywords; ?>">
    <meta name="description" content="<?php echo $description; ?>">
    <link rel="icon" href="<?php echo $favicon; ?>" type="image/x-icon" />
</head>

<body>

    <!-- 全局信息提示框 -->
    <div id="Result" style="display: none;"></div>

    <?php
    // 判断登录状态
    session_start();
    if (isset($_SESSION["session_user"])) {

        // 获得imgid
        $img_id = trim($_GET["imgid"]);

        // 获取当前imgid下的相关信息
        $sql_img = "SELECT * FROM qrcode_img WHERE img_id = '$img_id'";
        $result_img = $conn->query($sql_img);
        if ($result_img->num_rows > 0) {
            while ($row_img = $result_img->fetch_assoc()) {
                $img_title = $row_img["img_title"];
                $img_status = $row_img["img_status"];
                $img_ldym = $row_img["img_ldym"];
                $img_moshi = $row_img["img_moshi"];
                $img_online = $row_img["img_online"];

                // 渲染数据到UI
                echo '<!-- 顶部导航栏 -->
      <div id="topbar">
        <div class="container">
          <span class="topbar-title"><a href="./">' . $title . '</a></span>
          <span class="topbar-login-link">' . $_SESSION["session_user"] . '<a href="logout.php">退出</a></span>
        </div>
      </div>

      <!-- 操作区 -->
      <div class="container">
        <br/>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="./">二维码管理系统</a></li>
                <li class="breadcrumb-item"><a href="./img.php">图片二维码</a></li>
                <li class="breadcrumb-item active" aria-current="page">编辑</li>
            </ol>
        </nav>
        <h3>编辑客服活码</h3>
        <p>编辑客服活码，上传微信二维码</p>

        <!-- 左右布局 -->
        <!-- 电脑端横排列表 -->
        <div class="left-nav">
          <button type="button" class="btn btn-zdy">编辑客服活码</button>
          <a href="./img.php?t=home/ediimg"><button type="button" class="btn btn-zdylight">返回上一页</button></a>
          <a href="./"><button type="button" class="btn btn-zdylight">返回首页</button></a>
        </div>

        <!-- 右侧布局 -->
        <div class="right-nav">
          <!-- 标题 -->
          <form onsubmit="return false" id="ediimg" enctype="multipart/form-data">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">标题</span>
            </div>
            <input type="text" class="form-control" placeholder="请输入标题" value="' . $img_title . '" name="img_title">
          </div>';

                // 落地页域名
                echo '<select class="form-control" name="img_ldym" style="-webkit-appearance:none;"><option value="' . $img_ldym . '">落地页域名：' . $img_ldym . '</option>';
                // 获取落地页域名
                $sql_ldym = "SELECT * FROM qrcode_domain WHERE ym_type='2'";
                $result_ldym = $conn->query($sql_ldym);
                // 遍历列表
                if ($result_ldym->num_rows > 0) {
                    while ($row_ldym = $result_ldym->fetch_assoc()) {
                        $ldym = $row_ldym["yuming"];
                        echo '<option value="' . $ldym . '">' . $ldym . '</option>';
                    }
                    // 同时也可以选择当前系统使用的域名
                    echo '<option value="http://' . $_SERVER['HTTP_HOST'] . '">http://' . $_SERVER['HTTP_HOST'] . '</option>';
                } else {
                    // 没有绑定落地页，使用当前系统使用的域名
                    echo '<option value="http://' . $_SERVER['HTTP_HOST'] . '">http://' . $_SERVER['HTTP_HOST'] . '</option>';
                }
                echo '</select>';

                // 选择模式
                if ($img_moshi == '1') {
                    echo '<div class="radio">
              <input id="radio-1" name="img_moshi" type="radio" value="1" checked>
              <label for="radio-1" class="radio-label">阈值模式</label>
              <input id="radio-2" name="img_moshi" type="radio" value="2">
              <label for="radio-2" class="radio-label">随机模式</label>
            </div>';
                } else {
                    echo '<div class="radio">
              <input id="radio-1" name="img_moshi" type="radio" value="1">
              <label for="radio-1" class="radio-label">阈值模式</label>
              <input id="radio-2" name="img_moshi" type="radio" value="2" checked>
              <label for="radio-2" class="radio-label">随机模式</label>
            </div>';
                }

                // 在线提醒
                if ($img_online == '1') {
                    echo '<div class="radio">
              <input id="radio-7" name="img_online" type="radio" value="1" checked>
              <label for="radio-7" class="radio-label">开启在线提醒</label>
              <input id="radio-8" name="img_online" type="radio" value="2">
              <label for="radio-8" class="radio-label">关闭在线提醒</label>
            </div>';
                } else {
                    echo '<div class="radio">
              <input id="radio-7" name="img_online" type="radio" value="1">
              <label for="radio-7" class="radio-label">开启在线提醒</label>
              <input id="radio-8" name="img_online" type="radio" value="2" checked>
              <label for="radio-8" class="radio-label">关闭在线提醒</label>
            </div>';
                }

                // 活码状态切换
                if ($img_status == '3') {
                    echo '<br/><p style="color:#f00;">该活码因违规已被停止使用</p>';
                } else if ($img_status == '1') {
                    echo '<div class="radio">
              <input id="radio-5" name="img_status" type="radio" value="1" checked>
              <label for="radio-5" class="radio-label">正常使用</label>
              <input id="radio-6" name="img_status" type="radio" value="2">
              <label for="radio-6" class="radio-label">暂停使用</label>
            </div><br/>';
                } else if ($img_status == '2') {
                    echo '<div class="radio">
              <input id="radio-5" name="img_status" type="radio" value="1">
              <label for="radio-5" class="radio-label">正常使用</label>
              <input id="radio-6" name="img_status" type="radio" value="2" checked>
              <label for="radio-6" class="radio-label">暂停使用</label>
            </div><br/>';
                }

                echo '<!-- 隐藏域 -->
          <div>
            <input type="hidden" name="img_id" value="' . $img_id . '" />
          </div>';

                if ($img_status !== '3') {
                    echo '<!-- 提交按钮 -->
            <button type="button" class="btn btn-tjzdy" onclick="ediimg();">更新活码</button><br/><br/>';
                }

                echo '</form>';

                echo '<table class="table">
            <thead>
              <tr>
                <th>序号</th>
                <th>二维码</th>
                <th>状态</th>
                <th>时间</th>
                <th>访问</th>
                <th>阈值</th>
                <th style="text-align: center;">操作</th>
              </tr>
            </thead>
            <tbody>';

                // 获取当前活码id下的子码
                $sql_zima = "SELECT * FROM qrcode_imgs WHERE img_id = '$img_id' ORDER BY ID ASC";
                $result_zima = $conn->query($sql_zima);
                if ($result_zima->num_rows > 0) {
                    while ($row_zima = $result_zima->fetch_assoc()) {
                        $zmid = $row_zima["zmid"];
                        $qrcode = $row_zima["qrcode"];
                        $update_time = $row_zima["update_time"];
                        $fwl = $row_zima["fwl"];
                        $xuhao = $row_zima["xuhao"];
                        $zima_status = $row_zima["zima_status"];
                        $img_yuzhi = $row_zima["img_yuzhi"];

                        // 遍历列表
                        echo '<tr>
                <td class="td-title" style="width: 100px;">' . $xuhao . '</td>';
                        if ($qrcode == '') {
                            echo '<td class="td-status"><span class="badge badge-secondary">未上传</span></td>';
                        } else {
                            echo '<td class="td-status"><span class="badge badge-success">已上传</span></td>';
                        }
                        if ($zima_status == 1) {
                            echo '<td class="td-status"><span class="badge badge-success">开启</span></td>';
                        } else {
                            echo '<td class="td-status"><span class="badge badge-danger">关闭</span></td>';
                        }
                        echo '<td class="td-fwl">' . $update_time . '</td>
                <td class="td-fwl">' . $fwl . '</td>
                <td class="td-fwl">' . $img_yuzhi . '</td>
                <td class="td-caozuo" style="text-align: center;">
                  <div data-toggle="modal" data-target="#edizima" id="' . $zmid . '" onclick="getzmid(this);"><span class="badge badge-success" style="cursor:pointer;">编辑</span></div>
                </td>
              </tr>';
                    }
                }
                echo '</tbody>
          </table>

          <p style="color:#999;font-size:14px;">落地域名：用户扫码访问你的活码界面使用的域名。</p>
          <p style="color:#999;font-size:14px;">阈值模式：按照12345序号，每次扫码，达到阈值将自动切换为下一个客服二维码。</p>
          <p style="color:#999;font-size:14px;">随机模式：按照12345序号，每次扫码，展示随机序号的客服二维码。</p>
          <p style="color:#999;font-size:14px;">在线提醒：在工作日和上班时间提醒客服在线，在周日以及下班时间提醒不在线，默认周一至周六为工作日，早上9点上班下午6点下班。如需修改请在get/img/index.php找到相关代码进行修改。</p>
          <p style="color:#999;font-size:14px;">其他说明：本套系统仅支持创建5个客服二维码，按你设置的展示方式和状态进行展示。</p>
        </div>

      </div>';
            }
        } else {
            echo "<h1>参数错误！</h1>";
        }
    } else {
        echo "未登录";
    }
    ?>

    <!-- 编辑子码 -->
    <div class="modal fade" id="edizima">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">

                <!-- 模态框头部 -->
                <div class="modal-header">
                    <h4 class="modal-title">编辑二维码子码</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- 模态框主体 -->
                <form onsubmit="return false" id="ediwxzima" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control qrcode" placeholder="请上传微信二维码" name="qrcode" style="-webkit-appearance:none;">
                            <div class="input-group-append">
                                <span class="input-group-text" style="cursor:pointer;position: relative;">
                                    <input type="file" id="select_zimaqrcode" class="file_btn" name="file" /><span class="text">上传图片</span>
                                </span>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">微信号</span>
                            </div>
                            <input type="text" class="form-control imgnum" placeholder="请输入微信号" name="img_num">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">阈值</span>
                            </div>
                            <input type="text" class="form-control imgyuzhi" placeholder="达到阈值自动切换下一个" name="img_yuzhi">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">备注</span>
                            </div>
                            <input type="text" class="form-control imgbeizhu" placeholder="留空则不展示备注信息" name="img_beizhu">
                        </div>

                        <!-- 开启状态 -->
                        <div class="radio"></div>

                        <!-- 隐藏域，子码id -->
                        <input type="hidden" name="zmid" id="edizmid_val"><br />

                        <!-- 上传提示 -->
                        <div class="upload_status"></div>
                    </div>

                    <!-- 模态框底部 -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-tjzdy" onclick="ediimgzima();">更新</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        // 延迟关闭信息提示框
        function closesctips() {
            $("#Result").css('display', 'none');
        }

        // 编辑群活码
        function ediimg() {
            $.ajax({
                type: "POST",
                url: "../api/user/edi_img.php",
                data: $('#ediimg').serialize(),
                success: function(data) {
                    // 更新成功
                    if (data.code == 100) {
                        $("#Result").css("display", "block");
                        $("#Result").html("<div class=\"alert alert-success\"><strong>" + data.msg + "</strong></div>");
                        // 刷新列表
                        location.href = "./img.php";
                    } else {
                        $("#Result").css("display", "block");
                        $("#Result").html("<div class=\"alert alert-danger\"><strong>" + data.msg + "</strong></div>");
                    }
                },
                error: function() {
                    // 更新失败
                    $("#Result").css("display", "block");
                    $("#Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
                }
            });
            // 关闭信息提示框
            setTimeout('closesctips()', 2000);
        }


        // 上传客服二维码
        var zimaqrcode_lunxun = setInterval("upload_zimazimaqrcode()", 2000);

        function upload_zimazimaqrcode() {
            var zimaqrcode_filename = $("#select_zimaqrcode").val();
            if (zimaqrcode_filename) {
                clearInterval(zimaqrcode_lunxun);
                var edizima_form = new FormData(document.getElementById("ediwxzima"));
                $.ajax({
                    url: "upload.php",
                    type: "post",
                    data: edizima_form,
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        if (data.res == 400) {
                            $("#edizima .upload_status").css("display", "block");
                            $("#edizima .upload_status").html("<div class=\"alert alert-success\"><strong>" + data.msg + "</strong></div>");
                            $("#edizima .modal-body .qrcode").val(data.path);
                            $("#edizima .modal-body .text").text("已上传");
                        } else {
                            $("#edizima .upload_status").css("display", "block");
                            $("#edizima .upload_status").html("<div class=\"alert alert-danger\"><strong>" + data + "</strong></div>");
                        }
                    },
                    error: function(data) {
                        $("#edizima .upload_status").css("display", "block");
                        $("#edizima .upload_status").html("<div class=\"alert alert-danger\"><strong>" + data.msg + "</strong></div>");
                    },
                    beforeSend: function(data) {
                        $("#edizima .upload_status").css("display", "block");
                        $("#edizima .upload_status").html("<div class=\"alert alert-warning\"><strong>正在上传...</strong></div>");
                    }
                })
                // 关闭信息提示框
                setTimeout('closesctips()', 2000);
            } else {
                // console.log("等待上传");
            }
        }

        // 获得子码id和当前子码id下的信息
        function getzmid(event) {
            var zmid = event.id;
            // 把子码id传到表单里
            $("#edizmid_val").val(zmid);
            // 获取子码二维码和阈值
            $.ajax({
                type: "GET",
                url: "../api/user/get_imgs.php?zmid=" + zmid,
                success: function(data) {
                    // 获取成功
                    if (data.code == 100) {
                        $("#edizima .modal-body .qrcode").val(data.qrcode);
                        $("#edizima .modal-body .imgnum").val(data.img_num);
                        $("#edizima .modal-body .imgbeizhu").val(data.img_beizhu);
                        $("#edizima .modal-body .imgyuzhi").val(data.img_yuzhi);
                        if (data.zima_status == '1') {
                            $("#edizima .radio").html('<input id="radio-3" name="zima_status" type="radio" value="1" checked><label for="radio-3" class="radio-label">开启</label><input id="radio-4" name="zima_status" type="radio" value="2"><label for="radio-4" class="radio-label">关闭</label>');
                        } else {
                            $("#edizima .radio").html('<input id="radio-3" name="zima_status" type="radio" value="1"><label for="radio-3" class="radio-label">开启</label><input id="radio-4" name="zima_status" type="radio" value="2" checked><label for="radio-4" class="radio-label">关闭</label>');
                        }
                    } else {
                        $("#Result").css("display", "block");
                        $("#Result").html("<div class=\"alert alert-danger\"><strong>" + data.msg + "</strong></div>");
                    }
                },
                error: function() {
                    // 获取失败
                    $("#Result").css("display", "block");
                    $("#Result").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
                }
            });
        }

        // 编辑子码
        function ediimgzima() {
            $.ajax({
                type: "POST",
                url: "../api/user/edi_imgs.php",
                data: $('#ediwxzima').serialize(),
                success: function(data) {
                    // 更新成功
                    if (data.code == 100) {
                        $("#edizima .upload_status").css("display", "block");
                        $("#edizima .upload_status").html("<div class=\"alert alert-success\"><strong>" + data.msg + "</strong></div>");
                        // 关闭模态框
                        $('#edizima').modal('hide');
                        // 刷新列表
                        location.reload();
                    } else {
                        $("#edizima .upload_status").css("display", "block");
                        $("#edizima .upload_status").html("<div class=\"alert alert-danger\"><strong>" + data.msg + "</strong></div>");
                    }
                },
                error: function() {
                    // 更新失败
                    $("#edizima .upload_status").css("display", "block");
                    $("#edizima .upload_status").html("<div class=\"alert alert-danger\"><strong>服务器发生错误</strong></div>");
                }
            });
            // 关闭信息提示框
            setTimeout('closesctips()', 2000);
        }
    </script>
</body>

</html>
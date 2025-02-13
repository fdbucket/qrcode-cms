<?php
header("Content-type:text/html;charset=utf-8");
$phpv = PHP_VERSION; // php版本检测
file_put_contents("../db_config/test.txt", "test db_config 777"); // 检测创建文件权限
file_put_contents("../addons/test.txt", "test addons 777");
file_put_contents("../user/upload/test.txt", "test console 777");
?>

<!DOCTYPE html>
<html>

<head>
  <title>安装程序 - 二维码管理系统</title>
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
  <!-- 顶部 -->
  <div id="topbar">
    <span class="topbar-title">二维码管理系统v6.1.0安装程序</span>
  </div>
  <!-- 主体 -->
  <div class="container" style="width: 800px;">
    <br />
    <br />
    <div class="jumbotron" style="padding:35px 50px;background: #f2f2f2;">
      <h2>二维码管理系统</h2>
      <p>这是一套开源、免费、可上线运营的二维码管理系统，便于协助自己、他人进行微信私域流量资源获取，更大化地进行营销推广活动！降低运营成本，提高工作效率，获取更多资源。</p>
      <!-- 验证安装环境 -->
      <table class="table table-bordered" style="background: #fff;">
        <thead>
          <tr>
            <th>系统参数</th>
            <th>要求</th>
            <th>是否符合</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>PHP版本</td>
            <td>php5.5 - 7.2版本</td>
            <?php
            if ($phpv >= '5.5' && $phpv <= '7.2') {
              echo '<td><span class="badge badge-success">符合</span></td>';
            } else {
              echo '<td><span class="badge badge-danger">不符合</span></td>';
            }
            ?>
          </tr>
          <tr>
            <td>创建权限</td>
            <td>db_config目录777权限</td>
            <?php
            if (file_exists("../db_config/test.txt")) {
              echo '<td><span class="badge badge-success">符合</span></td>';
            } else {
              echo '<td><span class="badge badge-danger">不符合</span></td>';
            }
            ?>
          </tr>
          <tr>
            <td>创建权限</td>
            <td>addons目录777权限</td>
            <?php
            if (file_exists("../addons/test.txt")) {
              echo '<td><span class="badge badge-success">符合</span></td>';
            } else {
              echo '<td><span class="badge badge-danger">不符合</span></td>';
            }
            ?>
          </tr>
          <tr>
            <td>上传权限</td>
            <td>upload目录777权限</td>
            <?php
            if (file_exists("../user/upload/test.txt")) {
              echo '<td><span class="badge badge-success">符合</span></td>';
            } else {
              echo '<td><span class="badge badge-danger">不符合</span></td>';
            }
            ?>
          </tr>
        </tbody>
      </table>
      <!-- 安装按钮 -->
      <?php
      if ($phpv >= '5.5' && $phpv <= '7.1' && file_exists("../user/upload/test.txt") && file_exists("../db_config/test.txt") && file_exists("../addons/test.txt")) {
        echo '<a href="./install_form.php"><button type="button" class="btn btn-tjzdy" style="margin:20px auto 0;display: block;">开始安装</button></a>';
        unlink('../user/upload/test.txt');
        unlink('../addons/test.txt');
        unlink('../db_config/test.txt');
      }
      ?>

    </div>
  </div>

</body>

</html>
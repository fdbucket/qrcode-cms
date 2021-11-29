<?php
include("./includes/common.php");
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $site_title;?></title>
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.staticfile.org/popper.js/1.15.0/umd/popper.min.js"></script>
    <script src="https://cdn.staticfile.org/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./assets/css/index.css">
    <meta name="keywords" content="<?php echo $site_keywords;?>">
    <meta name="description" content="<?php echo $site_description;?>">
    <link rel="icon" href="./assets/images/fv.png" type="image/x-icon" />
</head>

<body>
    <nav class="navbar navbar-expand-sm bg-light navbar-dark">
        <!-- Brand/logo -->
        <a class="navbar-brand" href=".">
            <img src="./assets/images/logo.png" alt="logo" style="width:130px;">
        </a>

        <!-- Links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="link" target="blank"
                    href="https://mp.weixin.qq.com/s?__biz=MzU2NzIyMzA1Mw==&mid=100000294&idx=1&sn=c9d3c58983319c6547cc73abeccdbe35&chksm=7ca134444bd6bd52ae168fb1fc06c405be6db6ce0b5d4c49f7882145c0f923ff8fe2ad7388e0#rd">安装教程</a>
            </li>
            <li class="nav-item">
                <a class="link" target="blank" href="<?php echo $github_url;?>">Github</a>
            </li>
            <li class="nav-item">
                <a class="link" target="blank" href="javascript:alert('正在更新中...')">开发文档</a>
            </li>
            <li class="nav-item">
                <a class="link" target="blank" href="https://segmentfault.com/u/tanking">作者博客</a>
            </li>
        </ul>

        <!-- button -->
        <a href="javascript:alert('暂无插件')" class="cj">插件</a>
        <button class="btn btn-primary" style="position: absolute;right: 100px;"><a
                href="<?php echo $github_url;?>" target="blank">免费下载源码</a></button>
    </nav>

    <div class="jumbotron">
        <div class="middle">
            <div class="left">
                <div class="bigtitle">微信私域流量运营数据增长神器</div>
                <div class="miaoshu">全面升级6.0.1，多渠道引流获客，精细化高效社群数据增长，让管理和营销更简单！让获取数据更简单！</div>
                <div class="download">
                    <a href="">
                        <div class="dlbtn">
                            <div class="dltext">
                                <a href="<?php echo $github_url;?>" target="blank">
                                    <div class="text">免费下载源码</div>
                                </a>
                                <div class="icon">
                                    <img src="./assets/images/download.png">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="right">
                <img src="./assets/images/0.png">
            </div>
        </div>
    </div>

    <div class="intlist">
        <div class="li mr">
            <div class="left">
                <img src="./assets/images/icon1.png">
            </div>
            <div class="right">
                <div class="top">引流获客</div>
                <div class="bottom">多种方式引流，多种渠道投放，快速引流。</div>
            </div>
        </div>
        <div class="li mr">
            <div class="left">
                <div class="left">
                    <img src="./assets/images/icon2.png">
                </div>
            </div>
            <div class="right">
                <div class="top">多渠道运营</div>
                <div class="bottom">多种渠道管理，标准化管理，精细化运营，多种个性化功能。</div>
            </div>
        </div>
        <div class="li mr">
            <div class="left">
                <div class="left">
                    <img src="./assets/images/icon3.png">
                </div>
            </div>
            <div class="right">
                <div class="top">预防流失</div>
                <div class="bottom">快速切换引流渠道的导向，防止用户跳出和关闭页面。</div>
            </div>
        </div>
        <div class="li mr">
            <div class="left">
                <div class="left">
                    <img src="./assets/images/icon4.png">
                </div>
            </div>
            <div class="right">
                <div class="top">实用插件</div>
                <div class="bottom">各类实用插件，让系统更高级，辅助各类活动高效进行。</div>
            </div>
        </div>
    </div>

    <br />
    <br />
    <h2 style="text-align: center;font-weight: bold;">便捷操作面板</h2 style="text-align: center;">
    <p style="text-align: center;color: #666;">快速完成各项操作，手机电脑自适应操作</p>
    <br />
    <div class="pageint">
        <div class="left1">
            <img src="./assets/images/1.png">
        </div>
        <div class="right1">
            <div class="title">响应式操作面板</div>
            <div class="desc">手机、电脑、平板均可操作，自适应设备，随时随地管理活码系统。</div>
            <div class="dlbtn">
                <a href="<?php echo $github_url;?>">免费下载</a>
            </div>
        </div>
    </div>

    <br />
    <br />
    <h2 style="text-align: center;font-weight: bold;">多渠道运营</h2 style="text-align: center;">
    <p style="text-align: center;color: #666;">群活码、客服活码、活动码，多渠道运营推广</p>
    <br />
    <div class="pageint">
        <div class="left2">
            <div class="title">多种推广方式</div>
            <div class="desc">
                <p style="width: 300px;float: right;">群活码、客服微信、活动页面，多种推广方式，助力活动数据增长。</p>
            </div>
            <div class="dlbtn">
                <a href="<?php echo $github_url;?>">免费下载</a>
            </div>
        </div>
        <div class="right2">
            <img src="./assets/images/2.png">
        </div>
    </div>

    <br />
    <br />
    <h2 style="text-align: center;font-weight: bold;">超级管理员</h2 style="text-align: center;">
    <p style="text-align: center;color: #666;">对用户数据进行管理，对用户账号，权限进行操作</p>
    <br />
    <div class="pageint">
        <div class="left1">
            <img src="./assets/images/3.png">
        </div>
        <div class="right1">
            <div class="title">超级管理员</div>
            <div class="desc">管理用户发布的活码，及时处理违法违规活码、监控数据、切换域名、查看订单等。</div>
            <div class="dlbtn">
                <a href="<?php echo $github_url;?>">免费下载</a>
            </div>
        </div>
    </div>

    <br />
    <br />
    <h2 style="text-align: center;font-weight: bold;">个性化插件中心</h2 style="text-align: center;">
    <p style="text-align: center;color: #666;">开发各类个性化插件，加强平台的操作体检</p>
    <br />
    <div class="pageint">
        <div class="left2">
            <div class="title">各种实用插件</div>
            <div class="desc">
                <p style="width: 300px;float: right;">支持插件定制，根据个人运营需要开发各类实用插件，助力推广，更高效完成营销活动。</p>
            </div>
            <div class="dlbtn">
                <a href="<?php echo $github_url;?>">免费下载</a>
            </div>
        </div>
        <div class="right2">
            <img src="./assets/images/4.png">
        </div>
    </div>

    <br />
    <br />
    <h2 style="text-align: center;font-weight: bold;">免费开源，支持二次开发</h2 style="text-align: center;">
    <p style="text-align: center;color: #666;">本套源码免费开源，任意二次开发，不受限制</p>
    <br />
    <div class="pageint">
        <div class="left1">
            <img src="./assets/images/5.png">
        </div>
        <div class="right1">
            <div class="title">GitHub·源码开源</div>
            <div class="desc">本套活码系统免费开源，GitHub长期维护，任意修改，可商业化上线运营。</div>
            <div class="dlbtn">
                <a href="<?php echo $github_url;?>">免费下载</a>
            </div>
        </div>
    </div>
    <br />
    <h3 style="text-align: center;color: #eee;"><?php echo $site_title;?></h3>
    <!-- <div class="footer">
        <div class="left">
            <div class="top">
                <p>版权所有：活码管理系统</p>
                <p>备案信息：粤ICP备16088839号-1</p>
            </div>
            <div class="bottom">
                <p>xxx</p>
            </div>
        </div>
        <div class="right">
            <div class="zuo"></div>
            <div class="zhong"></div>
            <div class="you"></div>
        </div>
    </div> -->
</body>

</html>
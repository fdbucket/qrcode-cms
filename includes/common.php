<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if (defined('IN_CRONLITE')) return;
define('IN_CRONLITE', true);
define('SYSTEM_ROOT', dirname(__FILE__) . '/');
define('ROOT', dirname(SYSTEM_ROOT) . '/');
define('PLUGIN_ROOT', ROOT . 'addons/');
date_default_timezone_set('Asia/Shanghai');
$date = date("Y-m-d H:i:s");

$site_name = '活码管理系统'; // 网站名称
$site_title = '活码管理系统 - 微信私域流量运营数据增长神器'; // SEO网页标题
$site_url = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];

$site_keywords = '引流宝,活码管理系统,活码系统,微信活码,微信群活码,群活码系统,免费活码系统,二维码活码';
$site_description = '这是一套开源、免费、可上线运营的活码系统，便于协助自己、他人进行微信私域流量资源获取，更大化地进行营销推广活动！降低运营成本，提高工作效率，获取更多资源。微信群二维码活码工具，生成微信群活码，随时可以切换二维码！微信官方群二维码有效期是7天，过期后无法扫码进群，或者是群人数满200人就无法扫码进群，如果我们在推广的时候，群满人或者过期了，别人还想进群，我们将会失去很多推广效果，所以有了群活码，可以在不更换链接和二维码的前提下，切换扫码后显示的内容，灵活变换！';

$github_url = 'https://github.com/fdbucket/qrcode-cms';
$support_url = 'https://support.qq.com/products/345003';
$icp_number = '沪ICP备20016252号-10';
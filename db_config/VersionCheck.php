<?php
/*
  用于版本更新提示，获取最新版本
*/
$version = "6.0.2"; // 当前版本
// $v_file = file_get_contents("http://www.likeyuns.com/api/huoma_new_version.json", true); // 获取最新版本信息
$v_file = '{"v":"6.0.2","u":"http://www.likeyuns.com","m":"无更新"}';
$result_arr = json_decode($v_file);
$v_str_v = $result_arr->v; // 版本号
$v_str_m = $result_arr->m; // 版本提示
$v_str_u = $result_arr->u; // 更新链接

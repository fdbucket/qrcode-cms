<?php
header("Content-type:text/html;charset=utf-8");
session_start();
unset($_SESSION['session_user']);
echo "<script>location.href=\"../../user/\";</script>";
?>
<?php
header("Content-type:text/html;charset=utf-8");
session_start();
unset($_SESSION['session_admin']);
header("Location: login.php");

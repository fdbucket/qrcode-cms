<?php
header("Content-type:text/html;charset=utf-8");
session_start();
unset($_SESSION['huoma.user']);
header("Location: ../../user");

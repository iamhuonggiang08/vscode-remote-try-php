<?php
session_start();

// Reset trạng thái đăng nhập về false
$_SESSION["IsLogin"] = false;

// Chuyển hướng về trang đăng nhập
header("Location: login.html");
?>

<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION["IsLogin"]) || $_SESSION["IsLogin"] !== true) {
    // Nếu chưa đăng nhập, chuyển hướng về trang đăng nhập
    header("Location: login.html");
    exit;
}
?>

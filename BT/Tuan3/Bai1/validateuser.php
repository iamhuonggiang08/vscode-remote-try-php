<?php
session_start();

// Kiểm tra xem người dùng đã submit form chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối CSDL
    $servername = "localhost:3307";
    $username = "root"; // Thay đổi tên người dùng và mật khẩu của bạn tại đây nếu cần
    $password = ""; 
    $dbname = "myDB";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Kiểm tra kết nối
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Lấy thông tin từ form đăng nhập
    $username = $_POST["username"];
    $password = $_POST["password"];

    // SQL query để kiểm tra thông tin đăng nhập
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Đăng nhập thành công
        $_SESSION["IsLogin"] = true;
        header("Location: welcome.php"); // Chuyển hướng đến trang chào mừng sau khi đăng nhập thành công
    } else {
        // Đăng nhập thất bại
        header("Location: login.html"); // Chuyển hướng lại trang đăng nhập
    }

    $conn->close();
} else {
    // Nếu không phải là phương thức POST, chuyển hướng về trang đăng nhập
    header("Location: login.html");
}
?>

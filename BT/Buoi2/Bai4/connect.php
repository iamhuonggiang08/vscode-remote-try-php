<?php
$servername = "localhost";
$username = "root"; // Thay đổi tên người dùng và mật khẩu của bạn tại đây nếu cần
$password = "";
$dbname = "bai2buoi2";

// Tạo kết nối
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Tạo bảng uploads nếu chưa tồn tại
$sql = "CREATE TABLE IF NOT EXISTS uploads (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    file_name VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NOT NULL,
    file_size INT(10) NOT NULL,
    upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "Table 'uploads' created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?>

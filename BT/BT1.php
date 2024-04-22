<?php
// Kết nối CSDL
$servername = "localhost:3307";
$username = "root";
$password = "";
$database = "PKA_S";

$conn = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Truy vấn dữ liệu
$sql = "SELECT Sinhvien.MSSV, Sinhvien.HoTen, MonHoc.MaMH, MonHoc.TenMH, DangKy.Ky
        FROM Sinhvien
        INNER JOIN DangKy ON Sinhvien.MSSV = DangKy.MSSV
        INNER JOIN MonHoc ON DangKy.MaMH = MonHoc.MaMH";

$result = $conn->query($sql);

// Hiển thị dữ liệu
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>MSSV</th>
                <th>Họ và tên</th>
                <th>Mã môn học</th>
                <th>Tên môn học</th>
                <th>Kỳ</th>
            </tr>";
// Duyệt qua các hàng dữ liệu và hiển thị
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                        <td>".$row["MSSV"]."</td>
                        <td>".$row["HoTen"]."</td>
                        <td>".$row["MaMH"]."</td>
                        <td>".$row["TenMH"]."</td>
                        <td>".$row["Ky"]."</td>
                  </tr>";
    }
    echo "</table>";
} else {
    echo "Không có dữ liệu";
}

// Đóng kết nối
$conn->close();
?>
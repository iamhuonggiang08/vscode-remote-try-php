<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách sinh viên đăng ký môn học</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            padding: 12px 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .button-container {
            margin-top: 20px;
            text-align: center;
        }
        .button {
            background-color: #4CAF50; /* Green */
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .button.red {
            background-color: #f44336; /* Red */
        }
        .button:hover {
            background-color: #45a049; /* Darker green */
        }
    </style>
</head>
<body>
    <h2>Danh sách sinh viên đăng ký môn học</h2>
    <table border='1' id='myTable'>
        <tr>
            <th>MSSV</th>
            <th>Họ và tên</th>
            <th>Mã môn học</th>
            <th>Tên môn học</th>
            <th>Kỳ</th>
        </tr>
        <?php
        // Kết nối CSDL
        $servername = "localhost:3307";
        $username = "root";
        $password = "";
        $database = "pka_s";

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
        } else {
            echo "<tr><td colspan='5'>Không có dữ liệu</td></tr>";
        }

        // Đóng kết nối
        $conn->close();
        ?>
    </table>
</body>
</html>

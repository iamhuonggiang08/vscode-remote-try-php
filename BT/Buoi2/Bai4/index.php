<?php
// Kiểm tra nếu có yêu cầu upload file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["myfile"])) {
    $upload_dir = "uploads/";
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt');
    $max_file_size = 2097152; // 2MB

    // Lấy thông tin file được upload
    $file_name = $_FILES['myfile']['name'];
    $file_size = $_FILES['myfile']['size'];
    $file_tmp = $_FILES['myfile']['tmp_name'];
    $file_type = $_FILES['myfile']['type'];
    $file_ext = strtolower(end(explode('.', $_FILES['myfile']['name'])));

    // Kiểm tra loại file
    if (in_array($file_ext, $allowed_types) === false) {
        $error = "Chỉ cho phép upload các file có định dạng JPG, JPEG, PNG, GIF, PDF, TXT";
    }

    // Kiểm tra kích thước file
    if ($file_size > $max_file_size) {
        $error .= "\nKích thước file không được vượt quá 2MB";
    }

    // Kiểm tra xem có lỗi không
    if (empty($error) == true) {
        // Đổi tên file và upload vào thư mục upload
        $file_name = time() . "_" . bin2hex(random_bytes(5)) . "." . $file_ext;
        move_uploaded_file($file_tmp, $upload_dir . $file_name);
    }
}

// Xóa file
if (isset($_GET["action"]) && $_GET["action"] == "delete" && isset($_GET["file"])) {
    $file = "Bai4/upload/" . $_GET["file"];
    if (file_exists($file)) {
        unlink($file);
    }
}

// Lấy danh sách file trong thư mục upload
$files = glob("uploads/*.*");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>File Upload</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="myfile">
            <input type="submit" value="Upload">
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
        <h2>Uploaded Files</h2>
        <table>
            <tr>
                <th><a href="?sort=name">Tên tập tin</a></th>
                <th>Loại</th>
                <th><a href="?sort=date">Ngày tải lên</a></th>
                <th>Kích thước</th>
                <th>Xóa</th>
            </tr>
            <?php
            // Sắp xếp file
            if (isset($_GET["sort"]) && $_GET["sort"] == "name") {
                sort($files);
            } elseif (isset($_GET["sort"]) && $_GET["sort"] == "date") {
                array_multisort(array_map('filemtime', $files), SORT_DESC, $files);
            }

            foreach ($files as $file) {
                $file_name = basename($file);
                $file_size = filesize($file);
                $file_type = pathinfo($file, PATHINFO_EXTENSION);
                $file_date = date("d/m/Y H:i:s", filemtime($file));
                echo "<tr>";
                echo "<td>$file_name</td>";
                echo "<td>$file_type</td>";
                echo "<td>$file_date</td>";
                echo "<td>$file_size bytes</td>";
                echo "<td><a href='?action=delete&file=$file_name' onclick=\"return confirm('Are you sure?')\">Xóa</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
include 'db_config.php';

// Xử lý tải tệp lên
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    $target_dir = "upload/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $uploadOk = 1;

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($fileType != "jpg" && $fileType != "png" && $fileType != "jpeg" && $fileType != "gif") {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        $message = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            // Mã hóa mật khẩu bằng SHA1
            $password_hash = sha1($_POST['password']);

            $sql = "INSERT INTO files (name, type, size, password_hash) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([
                basename($_FILES["fileToUpload"]["name"]),
                $fileType,
                $_FILES["fileToUpload"]["size"],
                $password_hash
            ]);
            $message = "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }
}

// Hiển thị danh sách các tệp đã tải lên
$sql = "SELECT * FROM files ORDER BY upload_date DESC";
$files = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>File Upload & Display</h1>
    <div>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            Select file to upload:
            <input type="file" name="fileToUpload" id="fileToUpload">
            Password: <input type="password" name="password" id="password">
            <input type="submit" value="Upload File" name="submit">
        </form>
    </div>
    <?php if ($message) echo "<p>$message</p>"; ?>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Size</th>
                <th>Date Uploaded</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($file = $files->fetch()) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($file['name']); ?></td>
                    <td><?php echo htmlspecialchars($file['type']); ?></td>
                    <td><?php echo number_format($file['size'] / 1024, 2) . ' KB'; ?></td>
                    <td><?php echo htmlspecialchars($file['upload_date']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

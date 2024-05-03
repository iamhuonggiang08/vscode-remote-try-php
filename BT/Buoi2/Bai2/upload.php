<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file_name = $_FILES["file"]["name"];
    $file_type = $_FILES["file"]["type"];
    $file_size = $_FILES["file"]["size"];
    $file_tmp_name = $_FILES["file"]["tmp_name"];

    $upload_dir = 'upload/';
    $target_file = $upload_dir . basename($file_name);

    if (move_uploaded_file($file_tmp_name, $target_file)) {
        $upload_date = date("Y-m-d H:i:s");
        $query = "INSERT INTO files (name, type, size, upload_date) VALUES ('$file_name', '$file_type', '$file_size', '$upload_date')";
        mysqli_query($conn, $query);
        header("Location: index.php");
    } else {
        echo "Error uploading file.";
    }
}
?>

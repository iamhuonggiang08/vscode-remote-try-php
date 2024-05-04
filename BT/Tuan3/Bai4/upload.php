<?php
include 'db_config.php';

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    $target_dir = "upload_files/";
    $temp_file = $_FILES["fileToUpload"]["tmp_name"];
    $file_name = basename($_FILES["fileToUpload"]["name"]);
    $target_file = $target_dir . $file_name;
    $uploadOk = 1;
    $message = '';

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 2097152) {
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($target_file)) {
        $message = "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx');
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($file_type, $allowed_types)) {
        $message = "Sorry, only JPG, JPEG, PNG, GIF, PDF, DOC, and DOCX files are allowed.";
        $uploadOk = 0;
    }

    // If everything is ok, try to upload file
    if ($uploadOk) {
        // Rename file to specified format
        $file_name_parts = pathinfo($file_name);
        $new_file_name = date("Ymd") . "_" . substr(sha1($file_name_parts['filename']), 0, 7) . "." . $file_name_parts['extension'];

        if (move_uploaded_file($temp_file, $target_dir . $new_file_name)) {
            // Insert file details into database
            $sql = "INSERT INTO files (name, type, size, upload_date) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$new_file_name, $file_type, $_FILES["fileToUpload"]["size"]]);
            $message = "The file " . htmlspecialchars($file_name) . " has been uploaded.";
        } else {
            $message = "Sorry, there was an error uploading your file.";
        }
    }
}
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
    <h2>Upload File</h2>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <input type="file" name="fileToUpload" id="fileToUpload" class="file-input">
        <input type="submit" value="Upload File" name="submit">
    </form>
    <p><?php if ($message) echo $message; ?></p>
    <button onclick="location.href='index.php', '_blank';">View Upload File</button>
</body>
</html>

<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["file"])) {
    $file_name = $_GET["file"];
    $target_file = "upload_files/" . $file_name;

    // Delete file from directory
    if (unlink($target_file)) {
        // Delete file record from database
        $sql = "DELETE FROM files WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$file_name]);
        echo "File $file_name deleted successfully.";
    } else {
        echo "Error deleting file.";
    }
}
?>

<?php
include 'db_config.php';

// Sorting
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'upload_date';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

// Delete file
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $file_name = $_POST['file_name'];
    $target_file = "upload_files/" . $file_name;

    // Delete file from directory
    if (unlink($target_file)) {
        // Delete file record from database
        $sql = "DELETE FROM files WHERE name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$file_name]);
    }
}

// Get files from database
$sql = "SELECT * FROM files ORDER BY $sort_by $order";
$files = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploaded Files</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Uploaded Files</h2>
    <table>
        <thead>
            <tr>
                <th><a href="?sort_by=name&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Name</a></th>
                <th><a href="?sort_by=type&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Type</a></th>
                <th><a href="?sort_by=size&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Size</a></th>
                <th><a href="?sort_by=upload_date&order=<?php echo $order == 'ASC' ? 'DESC' : 'ASC'; ?>">Upload Date</a></th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($file = $files->fetch()) : ?>
                <tr>
                    <td><?php echo $file['name']; ?></td>
                    <td><?php echo $file['type']; ?></td>
                    <td><?php echo number_format($file['size'] / 1024, 2) . ' KB'; ?></td>
                    <td><?php echo $file['upload_date']; ?></td>
                    <td>
                        <form method="post" action="">
                            <input type="hidden" name="file_name" value="<?php echo $file['name']; ?>">
                            <button type="submit" name="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button class="upload-button" onclick="location.href='upload.php', '_blank';">Upload File</button>
</body>
</html>

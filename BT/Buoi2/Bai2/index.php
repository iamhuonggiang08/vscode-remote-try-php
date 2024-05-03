<!DOCTYPE html>
<html>
<head>
    <title>File Upload System</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>File Upload System</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <input type="file" name="file">
            <button type="submit" name="submit">Upload</button>
        </form>
        <table>
            <tr>
                <th><a href="?sort=name">Name</a></th>
                <th><a href="?sort=type">Type</a></th>
                <th><a href="?sort=upload_date">Upload Date</a></th>
                <th><a href="?sort=size">Size</a></th>
            </tr>
            <?php include 'display_files.php'; ?>
        </table>
    </div>
</body>
</html>

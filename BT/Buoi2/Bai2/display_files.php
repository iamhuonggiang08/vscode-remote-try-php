<?php
include 'db_config.php';

// Function to format file size
function formatSizeUnits($bytes){
    if ($bytes >= 1073741824){
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576){
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024){
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1){
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1){
        $bytes = $bytes . ' byte';
    } else{
        $bytes = '0 bytes';
    }
    return $bytes;
}

// Get sort parameter
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$sort_order = ($sort_by === 'name' || $sort_by === 'upload_date') ? 'ASC' : 'DESC';

// Query to fetch files from database
$query = "SELECT * FROM files ORDER BY $sort_by $sort_order";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>{$row['name']}</td>";
        echo "<td>{$row['type']}</td>";
        echo "<td>{$row['upload_date']}</td>";
        echo "<td>" . formatSizeUnits($row['size']) . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>No files uploaded yet.</td></tr>";
}
?>

<?php
// Database config
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'bsms_db';

// Connect to DB
$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query data
$sql = "SELECT `product_id`,  `name` FROM `product_list` ";
$result = $conn->query($sql);

// Set headers to force download
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="product_list.csv"');

$output = fopen('php://output', 'w');

// Add header row
fputcsv($output, ['product_id', 'name','quantity']);

// Add data rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
} else {
    fputcsv($output, ['No data found']);
}

fclose($output);
$conn->close();
exit;

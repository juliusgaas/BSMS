<?php

session_start();
$host = 'localhost';
$dbname = 'bsms_db';
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === 0) {
    $csvFile = $_FILES['csv_file']['tmp_name'];

    if (($handle = fopen($csvFile, 'r')) !== false) {
        $header = fgetcsv($handle); // skip header
        $count = 0;

        while (($data = fgetcsv($handle, 1000, ",")) !== false) {
            // Assign each value
            $product_code    = $conn->real_escape_string($data[0]);
            $category_id     = (int)$data[1];
            $name            = $conn->real_escape_string($data[2]);
            $description     = $conn->real_escape_string($data[3]);
            $price           = (float)$data[4];
            $original_price  = (float)$data[5];
            $alert_restock   = (int)$data[6];
            $status          = (int)$data[7];
            

            $sql = "INSERT INTO product_list 
                (`product_code`, `category_id`, `name`, `description`, `price`, `original_price`, `alert_restock`, `status`, `delete_flag`)
                VALUES 
                ('$product_code', $category_id, '$name', '$description', $price, $original_price, $alert_restock, $status, $delete_flag)";

            if ($conn->query($sql)) {
                $count++;
            }
        }

        fclose($handle);
        echo "$count products imported successfully.";
    } else {
        echo "Failed to read CSV file.";
    }
} else {
    echo "No file uploaded.";
}

$conn->close();
?>

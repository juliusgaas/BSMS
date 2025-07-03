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
            $product_id    = $conn->real_escape_string($data[0]);
            $quantity     = (int)$data[1];
          
           
            

            $sql = "INSERT INTO stock_list 
                ( `product_id`, `quantity`)
                VALUES 
                ('$product_id',$quantity)";

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

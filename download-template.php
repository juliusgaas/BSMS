<?php
// Define the CSV headers (template columns)
$headers = ['product_code','category_id','name','description','price','original_price','alert_restock','status'];

// Force browser to download as CSV
header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="template-csv.csv"');

// Open output buffer
$output = fopen('php://output', 'w');

// Write header row only
fputcsv($output, $headers);

fclose($output);
exit;

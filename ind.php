<?php
$servername = "localhost";
$username = "u138133975_ourhome";
$password = "7u&0t]B;uQ*";
$database = "u138133975_furniture";

// Create connection
$conn = mysqli_connect('localhost', 'u138133975_ourhome', 'A@&DDb;7', 'u138133975_furniture');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$productQuantitiesByMonth = array_fill(1, 12, 0);

$currentYear = date('Y');
$sql = "SELECT MONTH(date) AS month, SUM(quantity) AS total_quantity FROM products WHERE YEAR(date) = $currentYear GROUP BY MONTH(date)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetching data
    while ($row = $result->fetch_assoc()) {
        $month = intval($row["month"]);
        $productQuantitiesByMonth[$month] = intval($row["total_quantity"]);
    }
}


$conn->close();

echo json_encode(array_values($productQuantitiesByMonth)); 
?>

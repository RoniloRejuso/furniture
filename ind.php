<?php
// Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "furniture";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize an array to store product quantities for each month
$productQuantitiesByMonth = array_fill(1, 12, 0); // Initialize all months with 0 quantity

// Query to fetch product quantities for each month of the current year
$currentYear = date('Y');
$sql = "SELECT MONTH(date) AS month, SUM(quantity) AS total_quantity FROM products WHERE YEAR(date) = $currentYear GROUP BY MONTH(date)";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetching data
    while ($row = $result->fetch_assoc()) {
        // Storing product quantities by month
        $month = intval($row["month"]);
        $productQuantitiesByMonth[$month] = intval($row["total_quantity"]);
    }
}


$conn->close();

// Return product quantities by month as JSON
echo json_encode(array_values($productQuantitiesByMonth)); 
?>

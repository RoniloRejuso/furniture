<?php
include 'dbcon.php';

$sql = "SELECT product_name, product_image, quantity FROM products";
$result = $conn->query($sql);

$products = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();

echo json_encode($products);
?>

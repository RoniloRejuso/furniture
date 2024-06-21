<?php
// Retrieve data sent via AJAX
$productName = $_POST['product_name'];
$price = $_POST['price'];
$productImage = $_POST['product_image'];

// Insert the product into the cart table
$conn = mysqli_connect($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize the input to prevent SQL injection
$productName = $conn->real_escape_string($productName);
$price = $conn->real_escape_string($price);
$productImage = $conn->real_escape_string($productImage);

$sql = "INSERT INTO cart (product_name, price, product_image) VALUES ('$productName', '$price', '$productImage')";

if ($conn->query($sql) === TRUE) {
    echo "Product added to cart successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


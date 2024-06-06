<?php
// Database configuration
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'furniture';

// Establish database connection
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if (isset($_POST['submit'])) {
    // Check if required fields are filled
    if (empty($_POST['productName']) || empty($_POST['price']) || empty($_POST['quantity']) || empty($_POST['color'])) {
        echo "<script>alert('Please fill in all required fields.');
              window.location.href = 'addproduct.php';</script>";
        exit();
    }

    // Retrieve form data
    $productName = $_POST['productName'];
    $category = $_POST['category']; // Retrieve the selected category

    if (isset($_POST['status'])) {
        $status = $_POST['status'];
    } else {
        $status = ''; // Or set a default value
    }

    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $color = $_POST['color']; // Retrieve color from form
    $size = isset($_POST['size']) ? $_POST['size'] : ''; // Retrieve size from form
    $weightCapacity = isset($_POST['weight_capacity']) ? $_POST['weight_capacity'] : '';

    if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] === 0) {
        $productImage = $_FILES['product-image']['name'];
        $tempImage = $_FILES['product-image']['tmp_name'];

        // Upload product image
        $targetDir = "uploads/";
        $targetFilePath = $targetDir . basename($productImage);
        if (move_uploaded_file($tempImage, $targetFilePath)) {
            // Upload successful, proceed with insertion
        } else {
            echo "Error uploading image: " . $_FILES['product-image']['error'];
            exit();
        }
    } else {
        echo "Error: No image uploaded or upload failed.";
        exit();
    }

    // Insert data into the database (assuming $productImage is set correctly)
    $sql = "INSERT INTO products (product_name, category, status, price, quantity, product_image, color, size, weight_capacity) 
    VALUES ('$productName', '$category', '$status', '$price', '$quantity', '$targetFilePath', '$color', '$size', '$weightCapacity')";

    if ($conn->query($sql) === TRUE) {
        // Product added successfully, redirect to product_list.php
        header("Location: productlist.php");
        exit(); // Ensure no further output is sent to the browser
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

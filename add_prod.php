<?php
session_start();
include ('dbcon.php');

if (!isset($_SESSION['admin_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location: login.php");
    exit();
}

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
    $category = $_POST['category'];
    $status = isset($_POST['status']) ? $_POST['status'] : '';
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $color = $_POST['color'];
    $size = isset($_POST['size']) ? $_POST['size'] : '';
    $weightCapacity = isset($_POST['weight_capacity']) ? $_POST['weight_capacity'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    // Handle file uploads
    $productImage = '';
    if (isset($_FILES['product-image']) && $_FILES['product-image']['error'] === 0) {
        $productImage = $_FILES['product-image']['name'];
        $tempImage = $_FILES['product-image']['tmp_name'];
        $targetDir = "uploads/";
        $targetFilePath = $targetDir . basename($productImage);
        if (!move_uploaded_file($tempImage, $targetFilePath)) {
            echo "Error uploading image: " . $_FILES['product-image']['error'];
            exit();
        }
    } else {
        echo "Error: No image uploaded or upload failed.";
        exit();
    }

    // Handle GLB file upload
    $glbFile = '';
    if (isset($_FILES['glb-file']) && $_FILES['glb-file']['error'] === 0) {
        $glbFile = $_FILES['glb-file']['name'];
        $tempGlbFile = $_FILES['glb-file']['tmp_name'];
        $filePath = $targetDir . basename($glbFile);
        if (!move_uploaded_file($tempGlbFile, $filePath)) {
            echo "Error uploading GLB file: " . $_FILES['glb-file']['error'];
            exit();
        }
    }

    // Insert data into the database
    $sql = "INSERT INTO products (product_name, category, status, price, quantity, product_image, color, size, weight_capacity, file_path, description) 
            VALUES ('$productName', '$category', '$status', '$price', '$quantity', '$targetFilePath', '$color', '$size', '$weightCapacity', '$filePath', '$description')";

    if ($conn->query($sql) === TRUE) {
        // Product added successfully, redirect to product_list.php
        header("Location: productlist.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close database connection
$conn->close();
?>

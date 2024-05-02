<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "furniture"; // Replace with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div class='cart-item'>";
        echo "<h2>" . $row["product_name"] . "</h2>";
        echo "<p>Price: <span class='price'>$" . $row["price"] . "</span></p>";
        echo "<p>Quantity: " . $row["quantity"] . "</p>";
        echo "<p>Status: " . $row["status"] . "</p>";

        // Check if image path is not empty
        if (!empty($row["product_image"])) {
            // Assuming images are stored in the 'invent/uploads' folder relative to the PHP script
            $imagePath = "C:/xampp/htdocs/invent/uploads/.." . $row["product_image"];
            echo "<img src='" . $imagePath . "' alt='" . $row["product_name"] . "' style='max-width: 500px;'>";
        } else {
            echo "No image available";
        }

        echo "</div>";
    }
} else {
    echo "No products found";
}

// Close database connection
$conn->close();
?>

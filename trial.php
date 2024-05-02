<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="style.css">

    <style>
        /* Cart container */
        .cart-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }

        /* Cart item */
        .cart-item {
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
        }

        .cart-item img {
            max-width: 100%;
            height: auto;
        }

        .cart-item h2 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .cart-item p {
            font-size: 14px;
            margin-bottom: 5px;
        }

        .cart-item .price {
            font-weight: bold;
            color: #007bff; /* Blue color for price */
        }

    </style>
</head>

<body>
    <h1>Shopping Cart</h1>

    <div class="cart-container">
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
                    echo "<img src='" . $row["product_image"] . "' alt='" . $row["product_name"] . "' style='max-width: 500px;'>";
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
    </div>
</body>
</html>

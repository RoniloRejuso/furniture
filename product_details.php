<?php
session_start();
<<<<<<< HEAD
include 'dbcon.php';
=======

include 'dbcon.php'; // Include your database connection file
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location: user_login.php");
    exit();
}

if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $price = $_POST['price']; 
    $product_quantity = 1;
    $product_image = $_POST['product_image'];

    $select_cart = mysqli_query($conn, "SELECT * FROM cart WHERE product_name = '$product_name'");

    if(mysqli_num_rows($select_cart) > 0){
        $message[] = 'Product already added to cart';
    }else{

        $insert_product = mysqli_query($conn, "INSERT INTO `cart`(product_name, price, quantity, product_image) VALUES('$product_name', '$price', '$product_quantity', '$product_image')");
        
        if($insert_product){
            $message = 'Product added to cart successfully';
        } else {
            $message = 'Failed to add product to cart';
        }
    }

    // Redirect the user after adding to cart
    header("Location: user_carts.php");
    exit();
}

if(isset($_GET['product_id'])) {
    $productId = mysqli_real_escape_string($conn, $_GET['product_id']);

    $sql = "SELECT * FROM products WHERE product_id = '$productId'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
        exit;
    }

    mysqli_close($conn);
} else {
    echo "Product ID is missing.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'user_header.php'; ?>
</head>
<style>
.product-details {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    flex-wrap: wrap;
}
<<<<<<< HEAD
.product-container1 {
=======
.product-container {
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background-color: #FFF6EB;
    border-radius: 10px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    max-width: 100%;
}
.product_image {
    width: 100%;
<<<<<<< HEAD
=======
    max-width: 300px;
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
    height: auto;
    margin-bottom: 20px;
}
.product-info {
    text-align: center;
}
.product-price {
    color: black;
<<<<<<< HEAD
    font-size: 18px;
=======
    font-size: 24px;
    font-weight: bold;
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
}
.buttons {
    text-align: center;
    margin-top: 20px;
}
.buttons a {
    display: inline-block;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 30px;
    margin: 0 10px;
}
.btn-add-to-cart {
    padding: 10px;
    background-color: #964B33;
    border-radius: 5px !important;
    color: #fff;
    margin-left: 25px;
}
.btn-add-to-cart:hover {
    background-color: #964B33;
    color: #fff;
}
.btn-view-ar {
    padding: 10px;
    background-color: #493A2D;
    color: #fff;
    border-radius: 30px;
}
.btn-view-ar:hover {
    background-color: #493A2D;
    color: #fff;
}
.recommended-products {
    margin-top: 50px;
}
.recommended-products .row {
    margin: 0 -15px;
}
<<<<<<< HEAD
=======
.product-box {
    margin-bottom: 30px;
    padding: 15px;
    background: #f9f9f9;
    border-radius: 5px;
}
.product-box .product-image {
    max-width: 100%;
    height: auto;
}
.product-info {
    text-align: center;
}
.product-name {
    margin-top: 10px;
    font-size: 18px;
    color: #333;
}
.product-price {
    font-size: 16px;
    color: #000;
}
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54

@media (min-width: 768px) {
    .product-details {
        flex-wrap: nowrap;
    }
<<<<<<< HEAD
    .product-container1 {
=======
    .product-container {
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
        flex-direction: row;
        max-width: 800px;
    }
    .product_image {
        margin-bottom: 0;
<<<<<<< HEAD
        max-width: auto;
=======
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
    }
}
</style>
<body>
    <?php include 'user_body.php'; ?>
    <div class="container">
        <div class="row product-details">
<<<<<<< HEAD
            <div class="product-container1">
=======
            <div class="product-container">
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
                <div class="col-md-6">
                    <img src="<?php echo $product['product_image']; ?>" class="product_image" alt="Product Image">
                </div>
                    <div class="col-md-6">
<<<<<<< HEAD
                    <h2 class="product-name" style="text-align: center;"><b>Our Home <?php echo $product['product_name']; ?></b></h2>
                    <h3 class="product-price" style="font-size: 20px;">₱<?php echo $product['price']; ?></h3>
=======
                    <h3 class="product-name" style="font-size: 18px;">Our Home</h3>
                    <h2 class="product-name" style="margin-left:25px;"><b><?php echo $product['product_name']; ?></b></h2>
                    <h3 class="product-price">₱<?php echo $product['price']; ?></h3>
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
                    <p><?php echo $product['description']; ?></p>
                    <p>Size: <?php echo $product['size']; ?></p>
                    <p>Weight capacity: <?php echo $product['weight_capacity']; ?></p>
                    <p>Color: <?php echo $product['color']; ?></p>
                    <div class="buttons">
                    <form action="" method="POST">
                        <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $product['product_image']; ?>">
                        <div class="button-container">
                            <input type="button" class="btn btn-view-ar" value="View in AR" onclick="viewInAR()">
                            <input type="submit" class="btn btn-add-to-cart" value="Add to cart" name="add_to_cart">
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    <div class="recommended_products">
         <br><br>
         <h2><small><b>Recommended for You</b></small></h2>
         <div class="row">
            <?php
            include 'config.php';

            function generateRecommendations($transactions, $minSupport) {
<<<<<<< HEAD
                $allProducts = [];
                foreach ($transactions as $transaction) {
                    $products = explode(', ', $transaction["product_name"]);
                    $allProducts = array_merge($allProducts, $products);
                }
                return array_unique($allProducts);
=======
            $allProducts = [];
            foreach ($transactions as $transaction) {
                $products = explode(', ', $transaction["product_name"]);
                $allProducts = array_merge($allProducts, $products);
            }
            return array_unique($allProducts);
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
            }

            // Connect to the database
            $conn = new mysqli($host, $user, $password, $database);

            // Check connection
            if ($conn->connect_error) {
<<<<<<< HEAD
                die("Connection failed: " . $conn->connect_error);
=======
            die("Connection failed: " . $conn->connect_error);
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
            }

            // Fetch data from the orders table
            $sql = "SELECT product_name, price, product_image FROM orders";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
<<<<<<< HEAD
                $transactions = [];
                while ($row = $result->fetch_assoc()) {
                    $transactions[] = $row;
                }

                $minSupport = 0.1;
                $recommendations = generateRecommendations($transactions, $minSupport);

                shuffle($recommendations);

                $displayLimit = 4;
                $count = 0;

                foreach ($recommendations as $product) {
                    foreach ($transactions as $transaction) {
                        $products = explode(', ', $transaction["product_name"]);
                        $prices = explode(', ', $transaction["price"]);
                        $images = explode(', ', $transaction["product_image"]);

                        $index = array_search($product, $products);
                        if ($index !== false) {
                            $price = $prices[$index];
                            $product_image = $images[$index];
                            break;
                        }
                    }

=======
            // Store transactions in an array
            $transactions = [];
            while ($row = $result->fetch_assoc()) {
                $transactions[] = $row;
            }

            // Generate recommendations
            $minSupport = 0.1; // Minimum support threshold (adjust as needed)
            $recommendations = generateRecommendations($transactions, $minSupport);

            // Shuffle the recommendations
            shuffle($recommendations);

            // Limit the number of displayed products
            $displayLimit = 4; // Set the limit of products to display
            $count = 0;

            // Output recommendations
            foreach ($recommendations as $product) {
                // Fetch the price and image for each product
                foreach ($transactions as $transaction) {
                    if (strpos($transaction["product_name"], $product) !== false) {
                        $price = $transaction["price"];
                        $product_image = $transaction["product_image"];
                        break;
                    }
                }

                // Display the product
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
                echo '<div class="col-lg-3 col-sm-7">';
                echo '<div class="product_box">';
                echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                echo '<div class="product-info">';
                echo '<h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big>' . $product . '</big></b></h4>';
                echo '<h3 class="product-price" style="color: black; float: right;">₱' . $price . '.00</h3><br><br>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

                // Increment the count and check the limit
                $count++;
                if ($count >= $displayLimit) {
                    break;
                }
            }
            } else {
            echo '<div style="padding: 20px;text-align:center;margin: 0 auto;"><br>';
            echo '<b>No Products available.<b>';
            echo '</div>';
            }

            $conn->close();
            ?>
         </div>
      </div>
<<<<<<< HEAD
    </div><br><br><br>
=======
    </div>
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
    <div class="floating-navbar">
            <a href="user_index.php"><i class="fas fa-home"></i></a>
            <a href="user_prod.php"><i class="fas fa-couch"></i></a>
            <a href="user_carts.php"><i class="fas fa-shopping-bag"></i></a>
            <a href="user.php"><i class="fas fa-user"></i></a>
         </div>


    <!-- JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
    <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "100%";
         }
         
         function closeNav() {
           document.getElementById("mySidenav").style.width = "0";
         }
         function toggleDropdown() {
            var dropdownMenu = document.getElementById("furnitureMenu");
            if (dropdownMenu.style.display === "block") {
               dropdownMenu.style.display = "none";
            } else {
               dropdownMenu.style.display = "block";
            }
         }

        function viewInAR() {
            window.location.href = 'ar.php';
        }

         function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
</body>
</html>
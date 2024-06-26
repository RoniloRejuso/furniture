<?php
include 'dbcon.php';

if(isset($_POST['add_to_cart'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $product_quantity = 1;

    $fetch_product_query = "SELECT p.product_name, p.product_image, p.price
                            FROM products p
                            WHERE p.product_id = '$product_id'";
    
    $result = mysqli_query($conn, $fetch_product_query);

    if(mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        $user_id = 1;

        $select_cart_id = mysqli_query($conn, "SELECT cart_id FROM cart WHERE user_id = '$user_id'");
        if(mysqli_num_rows($select_cart_id) > 0) {
            $cart_row = mysqli_fetch_assoc($select_cart_id);
            $cart_id = $cart_row['cart_id'];
        } else {
            $insert_cart = mysqli_query($conn, "INSERT INTO cart (user_id) VALUES ('$user_id')");
            if($insert_cart) {
                $cart_id = mysqli_insert_id($conn);
            } else {
                echo 'Failed to create cart for user';
                exit();
            }
        }

        $price = $product['price'];
        $amount = $price * $product_quantity;

        $insert_cart_item = mysqli_query($conn, "INSERT INTO cart_items (cart_id, product_id, quantity, amount) 
                                                 VALUES ('$cart_id', '$product_id', '$product_quantity', '$amount')");

        if($insert_cart_item) {
            $message = 'Product added to cart successfully';
        } else {
            $message = 'Failed to add product to cart';
        }
    } else {
        echo "Product not found.";
        exit;
    }

    // Redirect to cart page after processing
    header("Location: user_carts.php");
    exit();
}

// Handle GET request to display product details
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.min.css">
</head>
<style>
.product-details {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    flex-wrap: wrap;
}
.product-container1 {
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
    height: auto;
    margin-bottom: 20px;
}
.product-info {
    text-align: center;
}
.product-price {
    color: black;
    font-size: 18px;
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

@media (min-width: 768px) {
    .product-details {
        flex-wrap: nowrap;
    }
    .product-container1 {
        flex-direction: row;
        max-width: 800px;
    }
    .product_image {
        margin-bottom: 0;
        max-width: auto;
    }
}
</style>
<body>
    <?php include 'user_body.php'; ?>
    <div class="container">
        <div class="row product-details">
            <div class="product-container1">
                <div class="col-md-6">
                    <img src="<?php echo $product['product_image']; ?>" class="product_image" alt="Product Image">
                </div>
                <div class="col-md-6">
                    <h2 class="product-name" style="text-align: center;"><b>Our Home <?php echo $product['product_name']; ?></b></h2>
                    <h3 class="product-price" style="font-size: 20px;">₱<?php echo $product['price']; ?></h3>
                    <p><?php echo $product['description']; ?></p>
                    <p>Size: <?php echo $product['size']; ?></p>
                    <p>Weight capacity: <?php echo $product['weight_capacity']; ?></p>
                    <p>Color: <?php echo $product['color']; ?></p>
                    <div class="buttons">
                        <form id="add-to-cart-form" action="" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $product['product_name']; ?>">
                            <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $product['product_image']; ?>">
                            <div class="button-container">
                            <input type="button" class="btn btn-view-ar" value="View in AR" onclick="viewInAR(<?php echo $product['product_id']; ?>)">
                            <input type="submit" class="btn btn-add-to-cart" value="Add to cart" name="add_to_cart" onclick="checkStock(event)">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="recommended_products"><br><br>
            <h2><small><b>Recommended for You</b></small></h2>
            <div class="row">
                <?php
                include 'config.php';

                function generateRecommendations($transactions, $minSupport) {
                    $allProducts = [];
                    foreach ($transactions as $transaction) {
                        $products = explode(', ', $transaction["product_name"]);
                        $allProducts = array_merge($allProducts, $products);
                    }
                    return array_unique($allProducts);
                    }

                    $conn = mysqli_connect($servername, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT p.product_id, p.product_name, p.price, p.product_image FROM orders o
                    JOIN cart c ON o.cart_id = c.cart_id
                    JOIN cart_items ci ON c.cart_id = ci.cart_id
                    JOIN products p ON ci.product_id = p.product_id
                    WHERE o.orders_id = ?;";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $_GET['order_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
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
                                if ($product == $transaction["product_name"]) {
                                    $product_id = $transaction["product_id"];
                                    $price = $transaction["price"];
                                    $product_image = $transaction["product_image"];
                                    break;
                                }
                            }

                            echo '<div class="product_box" style="width: 250px;margin: 0 auto;">';
                            echo '<a href="product_details.php?product_id=' . $product_id . '">';
                            echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                            echo '<div class="product-info">';
                            echo '<h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big>' . $product . '</big></b></h4>';
                            echo '<h3 class="product-price" style="color: black; float: right;">₱' . $price . '.00</h3><br><br>';
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';

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
    </div><br><br><br>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "360px";
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

        function viewInAR(productId) {
        window.location.href = 'ar1.php?product_id=' + encodeURIComponent(productId);
    }


        function checkStock(event) {
            var quantity = document.getElementById('product_quantity').value;
            if (quantity == 0) {
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'This product is out of stock!',
                });
            }
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script> 
</body>
</html>

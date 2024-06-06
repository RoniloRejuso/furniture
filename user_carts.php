<?php
@include 'config.php';

if (isset($_POST['update_update_btn'])) {
$update_value = mysqli_real_escape_string($conn, $_POST['update_quantity']);
$update_id = mysqli_real_escape_string($conn, $_POST['update_quantity_id']);

// Check if the new quantity is valid (greater than or equal to 0)
if ($update_value >= 0) {
$update_quantity_query = mysqli_query($conn, "UPDATE cart SET quantity = '$update_value' WHERE id = '$update_id'");

if ($update_quantity_query) {
header('location: user_carta.php');
} else {
die('Failed to update cart quantity: ' . mysqli_error($conn));
}
} else {
die('Invalid quantity value');
}
}
if(isset($_GET['remove'])){
$remove_id = $_GET['remove'];
mysqli_query($conn, "DELETE FROM cart WHERE id = '$remove_id'");
header('location:user_carts.php');
};

if(isset($_GET['delete_all'])){
mysqli_query($conn, "DELETE FROM cart");
header('location:user_carts.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'user_header.php'; ?>
</head>
<style> 
        .btn {
             display: flex;
            justify-content: center;       
        }

        .cart-item1 {
            border-radius: 10px;
            border: transparent;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
            background-color: #FFF6EB;
            width: 350px;
            height: 250px;
            margin: 0 auto;
        }

        /* Mobile view adjustments */
        @media (max-width: 768px) {
            .cart-item1 {
                width: 100%; 
                height: auto;
                padding: 15px;
                margin: 10px auto;
                box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
            }
        }
        .divider-line {
            display: inline-block;
            width: 25%; /* Adjust the width of the line as needed */
            height: 1px;
            background-color: #000; /* Change the color of the line as needed */
            vertical-align: middle;
        }
</style>
<body>
<?php
include 'user_body.php';
?>

                <div class="second_header_section">
                    <div class="container-fluid">
                        <nav class="navbar navbar-light bg-light">
                            <a href="user_index.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
                        </nav>
                    </div>
                </div>
            <div class="user_settings_section text-center">
                <div class="container">
                    <section class="cart-container">
                        <?php
                        $select_cart = mysqli_query($conn, "SELECT * FROM cart");
                        $grand_total = 0;

                        if (mysqli_num_rows($select_cart) > 0) {
                            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                                ?>
                                <div class="cart-item">
                                    <div class="product-image">
                                        <img src="<?php echo $fetch_cart['product_image']; ?>" alt="Product Image">
                                    </div>
                                    <div class="product-details">
                                        <h3><b>Our Home <?php echo $fetch_cart['product_name']; ?></b></h3>
                                        <p>Sub Total: ₱<?php echo number_format($sub_total = $fetch_cart['price'] * $fetch_cart['quantity'], 2);?></p>
                                        <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                        <div class="quantity-input">
                                            <button type="button" class="quantity-btn minus">-</button>
                                            <input type="number" id="quantity" name="update_quantity" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9)" value="<?php echo $fetch_cart['quantity']; ?>" min="1" step="1" readonly>
                                            <button type="button" class="quantity-btn plus">+</button>
                                        </div>
                                        <a href="user_carts.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="remove-btn"> <i class="fas fa-times"></i></a>
                                    </div>
                                </div>
                                <?php
                                $grand_total += $sub_total;
                            }
                            ?>
                            <div class="cart-total">
                                <p><b>Total Amount: ₱ <?php echo $grand_total; ?>.00</b></p>
                                <div class="checkout-btn">
                                    <a href="user_checkout.php" class="btn" style="background-color: #964B33;color:#fff; width: 330px;margin: 0 auto;" <?= ($grand_total > 1) ? '' : 'disabled'; ?>>Checkout</a>
                                </div>
                            </div>
                        <?php
                        } else {
                            ?>
                            <div class="cart-item1">
                                <div class="product-box">
                                    <!-- Cart icon -->
                                    <img src="png/cart.png" alt="Cart Icon" style="width: 100px; margin-bottom: 20px;">
                                    <div><b>No items in cart.</b></div><br>
                                    <div>
                                    <a href="user_prod.php" class="btn" style="background-color: #964B33;color:#fff; width: 300px; margin:0 auto;">Browse Products</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </section>
                    
            <div class="recommended_products">
            <br><br>
            <h3><small><span class="divider-line"></span><b>  Interested in This?  </b><span class="divider-line"></span></small></h3>
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

                // Connect to the database
                $conn = new mysqli($host, $user, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the orders table
                $sql = "SELECT product_name, price, product_image FROM orders";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
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
                $displayLimit = 1; // Set the limit of products to display
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
        </div>
    </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  
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

         function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
   </body>
</html>
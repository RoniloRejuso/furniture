<?php
session_start();
include('dbcon.php');
@include 'config.php';

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
            $message[] = 'Product added to cart successfully';
        } else {
            $message[] = 'Failed to add product to cart';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
   <head>
<?php
include 'user_header.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="cs/style.css">
<link rel="stylesheet" href="css/style.css">
 </head>
   <body>
   <?php
include 'user_body.php';
?>
<style>
   .button-container {
    display: flex;
    justify-content: space-between;
}

.btn {
    /* Your existing button styles */
    padding: 8px 12px; /* Adjust padding to make buttons smaller */
}

.btn-add-to-cart {
    margin-right: 5px; 
    background-color: #964B33;
}

.btn-view-ar {
    background-color: #493A2D; 
    border-radius:30px;
    margin-right: 5px;
}


</style>
</head>
<div class="product_section layout_padding">
   <div class="container" style="padding:20px;">
      <div class="row">
         <div class="col-sm-12"><br>
            <h1 class="product_taital">All Products</h1>

         </div>
      </div>
      <div class="product_section_2 layout_padding">
         <div class="row">
</head>
<body>
<div class="container">
<div class="row">
            <div class="col-sm-12">
                <h1 class="product_taital"></h1>
            </div>
        </div>
        <div class="product_section_2 layout_padding">
            <div class="row">
                <?php
                include "dbcon.php";

                $sql = "SELECT * FROM products";
                $result = mysqli_query($conn, $sql);
                $products = [];

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $products[] = $row;
                    }
                } else {
                    echo "No products found.";
                }

                mysqli_close($conn);
                ?>

                    <?php foreach ($products as $product) { ?>
                        <div class="col-lg-3 col-sm-6">
                            <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                                <div class="product_box">
                                    <img src="<?php echo $product['product_image']; ?>" class="image_1" alt="Product Image">
                                    <div class="product-info">
                                        <h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big><?php echo $product['product_name']; ?></big></b></h4>
                                        <h3 class="product-price" style="color: black; float: right;">₱<?php echo $product['price']; ?></h3><br><br>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>  
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
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                $allProducts = [];
                foreach ($transactions as $transaction) {
                    $products = explode(', ', $transaction["product_name"]);
                    $allProducts = array_merge($allProducts, $products);
                }
                return array_unique($allProducts);
<<<<<<< HEAD
=======
=======
            $allProducts = [];
            foreach ($transactions as $transaction) {
                $products = explode(', ', $transaction["product_name"]);
                $allProducts = array_merge($allProducts, $products);
            }
            return array_unique($allProducts);
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
            }

            // Connect to the database
            $conn = new mysqli($host, $user, $password, $database);

            // Check connection
            if ($conn->connect_error) {
<<<<<<< HEAD
                die("Connection failed: " . $conn->connect_error);
=======
<<<<<<< HEAD
                die("Connection failed: " . $conn->connect_error);
=======
            die("Connection failed: " . $conn->connect_error);
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
            }

            // Fetch data from the orders table
            $sql = "SELECT product_name, price, product_image FROM orders";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                // Store transactions in an array
                $transactions = [];
                while ($row = $result->fetch_assoc()) {
                    $transactions[] = $row;
                }

                $minSupport = 0.1; // Minimum support threshold (adjust as needed)
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

<<<<<<< HEAD
=======
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
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                echo '<div class="col-lg-3 col-sm-7">';
                echo '<div class="product_box">';
                echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                echo '<div class="product-info">';
                echo '<h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big>' . $product . '</big></b></h4>';
                echo '<h3 class="product-price" style="color: black; float: right;">₱' . $price . '.00</h3><br><br>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
                // Increment the count and check the limit
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
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
<div class="floating-navbar">
            <a href="user_index.php"><i class="fas fa-home"></i></a>
            <a href="user_prod.php" class="active"><i class="fas fa-couch"></i></a>
            <a href="user_carts.php"><i class="fas fa-shopping-bag"></i></a>
            <a href="user.php"><i class="fas fa-user"></i></a>
</div>
<script src="js/script.js"></script>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
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

        function viewInAR() {
<<<<<<< HEAD
            window.location.href = 'ar.php';
=======
<<<<<<< HEAD
            window.location.href = 'ar.php';
=======
            window.location.href = 'AR.html';
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
        }

         function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
      <script src="java/script.js"></script>
      
   </body>
</html>
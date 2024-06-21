<?php
session_start();
include('dbcon.php');
@include 'config.php';

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
   <div class="col-sm-12"><br>
            <h1 class="product_taital">All Products</h1>
         </div>
         <div class="search-section" style="text-align: center;">
         <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products" style="margin: 0 auto; display: inline-block;">
            <button type="submit" class="search-icon" style="padding:3px 10px;background-color:#964B33;color:white;border-radius:3px;"><i class="fas fa-search"></i></button>
            </form>
      </div>
      <div class="sorting_filtering_section" style="text-align: center; margin-top: 10px;">
         <form method="GET" action="" id="filterForm">
            <select name="sort_by" style="padding:10px;" onchange="document.getElementById('filterForm').submit();">
               <option value="default">Default Sorting</option>
               <option value="name_asc">Name: A to Z</option>
               <option value="name_desc">Name: Z to A</option>
               <option value="price_asc">Price: Low to High</option>
               <option value="price_desc">Price: High to Low</option>
            </select>
            <select name="filter_by_category" style="padding:10px;" onchange="document.getElementById('filterForm').submit();">
                <option value="all">All Categories</option>
                <option value="bedroom">Bedroom</option>
                <option value="dining_room">Dining Room</option>
                <option value="living_room">Living Room</option>
                <option value="office">Office</option>            </select>
         </form>
      </div>
<div class="row">
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
                            <a href="product_details1.php?product_id=<?php echo $product['product_id']; ?>">
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

                echo '<div class="col-lg-3 col-sm-7">';
                echo '<div class="product_box">';
                echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                echo '<div class="product-info">';
                echo '<h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big>' . $product . '</big></b></h4>';
                echo '<h3 class="product-price" style="color: black; float: right;">₱' . $price . '.00</h3><br><br>';
                echo '</div>';
                echo '</div>';
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
            window.location.href = 'ar.php';
        }

         function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
      <script src="java/script.js"></script>
      
   </body>
</html>
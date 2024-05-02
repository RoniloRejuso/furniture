<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
   <body>
   <?php
include 'user_body.php';
?>

<div class="product_section layout_padding">
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <h1 class="product_taital">Our Products</h1>
            <p class="product_text">incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation</p>
         </div>
      </div>
      <div class="product_section_2 layout_padding">
         <div class="row">
         <?php
// Assuming you have already established a database connection
include "dbcon.php"; // Include your database connection script

// Fetch products from the database
$sql = "SELECT * FROM products";
$result = mysqli_query($conn, $sql);
$products = [];

// Check if there are any products
if (mysqli_num_rows($result) > 0) {
    // Fetch each row as an associative array and add it to the $products array
    while ($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }
} else {
    echo "No products found.";
}

// Close the database connection
mysqli_close($conn);
?>

<?php
// Now loop through the $products array to display each product
foreach ($products as $product) {
?>
<div class="col-lg-3 col-sm-6">
    <div class="product_box">
        <h4 class="bursh_text"><?php echo $product['product_name']; ?></h4>
        <!-- Display product name -->

        <p class="lorem_text">Category: <?php echo ucfirst(str_replace('_', ' ', $product['category'])); ?></p>


        <p class="lorem_text">Status: <?php echo $product['status']; ?></p>

        <p class="lorem_text">Quantity: <?php echo $product['quantity']; ?></p>

        <img src="<?php echo $product['product_image']; ?>" class="image_1" alt="Product Image">

        <div class="btn_main">
            <h3 class="price_text">Price: $<?php echo $product['price']; ?></h3>
            <!-- Display product price -->

            <div class="buttons">
                <a href="#" class="add_to_cart">Add to Cart</a>
                <a href="#" class="buy_now">Buy Now</a>
            </div>
        </div>
    </div>
</div>
<?php
}
?>

         </div>
         <div class="seemore_bt"><a href="#">See More</a></div>
      </div>
      <!-- Recommended Products Section -->
      <div class="recommended_products">
         <h2>Recommended for You</h2>
         <div class="row">
            <!-- Display recommended products here -->
         </div>
      </div>
   </div>
</div>
<!-- product section end -->

      <!-- Floating navbar section start -->
         <div class="floating-navbar">
            <a href="index.html" class="active"><i class="fas fa-home"></i></a>
            <a href="all_products.html"><i class="fas fa-couch"></i></a>
            <a href="favorites.html"><i class="fas fa-heart"></i></a>
            <a href="cart.html"><i class="fas fa-shopping-bag"></i></a>
            <a href="user.html"><i class="fas fa-user"></i></a>
         </div>
      <!-- Floating navbar section end -->
            
      <!-- Javascript files-->
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

         function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
         }
      </script> 
   </body>
</html>

<!DOCTYPE html>
<html lang="en">
   <head>
<?php
include 'user_header.php';
?>
 <style>
.buttons {
  text-align: center;
}

.buttons a {
  display: inline-block;
  background-color: red; 
  color: white; 
  text-decoration: none; 
  padding: 10px 20px; 
  border-radius: 20px; 
  margin: -10px; 
}
.add_to_cart {
  float: right;
}

.view {
  float: left;
}
.buttons a:hover {
  background-color: darkred; /* Dark red background on hover */
}


.product-name {
  float: left; 
  margin-right: 20px; 
}

  </style>
 </head>
   <body>
   <?php
include 'user_body.php';
?>

</head>

<div class="product_section layout_padding">
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <h1 class="product_taital">Our Products</h1>

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

<?php
foreach ($products as $product) {
?>

<div class="col-lg-3 col-sm-6">
    <div class="product_box">
        <img src="<?php echo $product['product_image']; ?>" class="image_1" alt="Product Image">
        <div class="product-info">
            <h4 class="product-name"><?php echo $product['product_name']; ?></h4>
            <h3 class="product-price" style="color: black; float: right;">₱<?php echo $product['price']; ?></h3>
        </div>
        <p class="lorem_text"><?php echo ucfirst(str_replace('_', ' ', $product['category'])); ?></p>
        <p class="lorem_text"><?php echo $product['status']; ?></p>
        <p class="lorem_text">Quantity: <?php echo $product['quantity']; ?></p>

        
    </div>
</div>

<?php
}
?>

         </div>
         <div class="seemore_bt"><a href="#">See More</a></div>
      </div>
      <div class="recommended_products">
         <h2>Recommended for You</h2>
         <div class="row">
            
         </div>
      </div>
   </div>
</div>

<?php
include 'user_footer.php';
?>


         <div class="floating-navbar">
            <a href="user_index.html" class="active"><i class="fas fa-home"></i></a>
            <a href="user_prod.php"><i class="fas fa-couch"></i></a>
            <a href="favorites.html"><i class="fas fa-heart"></i></a>
            <a href="user_carts.php"><i class="fas fa-shopping-bag"></i></a>
            <a href="user.php"><i class="fas fa-user"></i></a>
         </div>
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
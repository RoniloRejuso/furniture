<!DOCTYPE html>
<html lang="en">
<?php
include 'header.php';
?>
   <body>
      <div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-light bg-light justify-content-between">
               <div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <a href="new_products.html">New Products</a>
                  <a href="products_sale.html">Products on Sale</a>
                  <div class="dropdown">
                      <a href="#" class="dropdown-toggle" id="furnitureDropdown" onclick="toggleDropdown()" aria-haspopup="true" aria-expanded="false">
                          Furniture
                      </a>
                      <div class="dropdown-menu" id="furnitureMenu" aria-labelledby="furnitureDropdown">
                          <a class="dropdown-item" href="living_room.html">Living Room</a>
                          <a class="dropdown-item" href="dining_room.html">Dining Room</a>
                          <a class="dropdown-item" href="bedroom.html">Bedroom</a>
                          <a class="dropdown-item" href="home_office.html">Home Office</a>
                          <a class="dropdown-item" href="all_products.html">All products</a>
                      </div>
                  </div>
                  <div class="login-signup">
                     <a href="login.html">Log in</a> | <a href="signup.html">Sign up</a>
                  </div>
               </div>                          
               <span class="toggle_icon" onclick="openNav()"><img src="images/toggle-icon.png"></span>
               <a class="logo" href="index.html"><img src="images/logo.png" width="150px" height="50px"></a>
               <form class="form-inline ">
                     <div class="login_text">
                     </div>
               </form>
            </nav>
         </div>
      </div>
      
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
   <div class="carousel-inner">
   <?php
include "dbcon.php";


$sql = "SELECT * FROM carousel_banners";
$result = mysqli_query($conn, $sql); 


if ($result) {
    if (mysqli_num_rows($result) > 0) {
        $active = true;
        while ($row = mysqli_fetch_assoc($result)) {
            // Render carousel items dynamically
            echo '<div class="carousel-item ' . ($active ? 'active' : '') . '">';
            echo '<img src="' . $row['image_url'] . '" class="d-block w-100" alt="' . $row['title'] . '">';
            echo '<div class="carousel-caption d-none d-md-block">';
            echo '<h1 class="banner_taital">' . $row['title'] . '</h1>';
            echo '<p class="banner_text">' . $row['description'] . '</p>';
            echo '<div class="read_bt"><a href="#">Buy Now</a></div>';
            echo '</div></div>';
            $active = false;
        }
    } else {
        echo "No carousel banners found.";
    }
} else {
    echo "Error: " . mysqli_error($conn);
}


mysqli_close($conn);
?>

   </div>
</div>

      <div class="category_buttons_section layout_padding">
         <div class="container">
             <div class="row">
                 <div class="col-sm-12">
                     <div class="row justify-content-between" id="category_buttons_container">
                         <div class="col-md-auto">
                             <a href="#" class="category_button"><i class="fas fa-cube" style="font-size: 14px;"></i></a>
                         </div>
                         <div class="col-md-auto">
                             <a href="#" class="category_button"><i class="fas fa-tags"style="font-size: 14px;"></i></a>
                         </div>
                         <div class="col-md-auto">
                             <a href="#" class="category_button"><i class="fas fa-couch"style="font-size: 14px;"></i></a>
                         </div>
                         <div class="col-md-auto">
                             <a href="#" class="category_button"><i class="fas fa-chair"style="font-size: 20px;"></i></a>
                         </div>
                         <div class="col-md-auto">
                             <a href="#" class="category_button"><i class="fas fa-bed"style="font-size: 14px;"></i></a>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>


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
include "dbcon.php"; // Include your database connection script

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

mysqli_close($conn);
?>

<?php foreach ($products as $product) { ?>
    <div class="col-lg-3 col-sm-6">
        <div class="product_box">
            <h4 class="bursh_text"><?php echo $product['product_name']; ?></h4>
            <p class="lorem_text"><?php echo $product['quantity']; ?> in stock</p>
            
            <!-- Display the image -->
            <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
            
            <div class="btn_main">
                <h3 class="price_text">Price <?php echo $product['price']; ?></h3>
            </div>
        </div>
    </div>
<?php } ?>





         </div>
         <div class="seemore_bt"><a href="#">See More</a></div>
      </div>
   </div>
</div>

      <div class="copyright_section">
         <div class="container">
            <p class="copyright_text">2024 All Rights Reserved. OUR | HOME</a></p>
         </div>
      </div>
      
         <div class="floating-navbar">
            <a href="index.html" class="active"><i class="fas fa-home"></i></a>
            <a href="all_products.html"><i class="fas fa-couch"></i></a>
            <a href="favorites.html"><i class="fas fa-heart"></i></a>
            <a href="cart.html"><i class="fas fa-shopping-bag"></i></a>
            <a href="user.html"><i class="fas fa-user"></i></a>
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
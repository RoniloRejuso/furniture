<!DOCTYPE html>
<html lang="en">
<?php
include 'header.php';
?>
   <body>
      <!-- header section start -->
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
      <!-- header section end -->

<!-- Bedroom Section -->
<div class="bedroom_section">
   <div class="container">
      <div class="row">
         <!-- PHP loop for products -->
         <?php
            // Assuming you have PHP logic here to fetch bedroom products
            $products = get_bedroom_products(); // Function to get bedroom products from the database
            foreach ($products as $product) {
         ?>
         <div class="col-lg-3 col-md-6">
            <div class="product_item">
               <!-- Product Image -->
               <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
               <!-- Product Name -->
               <h4><?php echo $product['name']; ?></h4>
               <!-- Product Price -->
               <p><?php echo $product['price']; ?></p>
               <!-- Heart Icon for Adding to Favorites -->
               <button class="add-to-favorites"><i class="fas fa-heart"></i></button>
               <!-- Link to Product Details -->
               <a href="product.php?id=<?php echo $product['id']; ?>" class="product-details-link">View Details</a>
            </div>
         </div>
         <?php
            }
         ?>
      </div>
   </div>
</div>
<!-- Bedroom Section End -->


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
      </script> > 
   </body>
</html>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <title>Our Home</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
      <link rel="stylesheet" type="text/css" href="css/style.css">
      <link rel="stylesheet" href="css/responsive.css">
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link href="https://fonts.googleapis.com/css?family=Great+Vibes|Open+Sans:400,700&display=swap&subset=latin-ext" rel="stylesheet">
      <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="css/owl.theme.default.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Include Font Awesome CSS -->
   </head>
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
      <!-- header section end <!--

        <!-- second header section start -->
        <div class="second_header_section">
            <div class="container-fluid">
            <nav class="navbar navbar-light bg-light justify-content-between">
                <!--<span class="navbar-brand"><b>CART</b></span>-->
                <a href="index.html" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
            </nav>
            </div>
        </div>
        <!-- second header section end -->
    
    <!-- cart items section start -->
    <div class="cart_items_section">
       <div class="container">
          <div class="row justify-content-center">
             <div class="col-md-8">
                <div class="cart_items">
                    <?php if ($cart_items_exist): ?>
                    <!-- If there are items in the cart -->
                    <!-- Loop through cart items and display them -->
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart_item" style="padding: 10px; background-color: #FFF6EB; margin-bottom: 10px;">
                            <!-- Display cart item details -->
                        </div>
                    <?php endforeach; ?>
                    <!-- Display total price and proceed to checkout button -->
                    <div class="total_price text-right" style="padding: 10px; background-color: #FFF6EB; border: 1px solid #FFF6EB;">
                        <h5>Total: $<?php echo $total_price; ?></h5>
                    </div>
                    <div class="proceed_to_checkout text-center" style="padding: 10px;">
                        <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
                    </div>
                <?php else: ?>
                    <!-- If no items in the cart -->
                    <div class="empty_cart" style="padding: 20px; background-color: #FFF6EB; border: 1px solid #FFF6EB;">
                        <div class="cart_icon text-center">
                            <i class="fas fa-shopping-cart fa-5x"></i>
                            <p class="text-uppercase mt-3"><b>Nothing in here.</b></p>
                            <p>Begin your Shopping Adventure now. Start Adding to your Cart!</p>
                            <div class="text-center">
                                <a href="browse_products.php" class="btn btn-primary"><i class="fas fa-plus"></i> Browse our products</a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                                </div>
             </div>
          </div>
       </div>
    </div>
    <!-- cart items section end -->
    
    <!-- Content interested in this -->
    <div class="interested_content">
       <!-- Your content here -->
    </div>
    
    <!-- Javascript files-->
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    </body>
    </html>
    
    <!-- user section end -->
            
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

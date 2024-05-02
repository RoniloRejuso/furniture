<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
   <body>

   <?php
include 'user_body.php';
?>
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

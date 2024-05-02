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
              <div class="second_header_section">
                <div class="container-fluid">
                <nav class="navbar navbar-light bg-light">

                    <a href="index.html" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
                </nav>
                </div>
            </div>

        <div class="login_section">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                    <form id="loginForm" method="POST" action="signin.php">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
    </div>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
    </div>
    <button type="submit" class="btn btn-primary">Login</button>
    <div class="or-divider">
        <span class="divider-line"></span>   OR   <span class="divider-line"></span>
    </div>
    <button type="button" class="btn btn-custom-color" data-toggle="modal" data-target="#signupModal">Create Account</button>
</form>

                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <h3 class="signup-modal-title" style="text-align: center;" id="signupModalLabel"><big>Create Account</big></h3>
                    <div class="modal-body">

                    <form id="signupForm" method="POST" action="signup.php">

    <div class="form-group">
        <label for="firstname">First name:</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name">
    </div>
    <div class="form-group">
        <label for="lastname">Last name:</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter lastname">
    </div>
    <div class="form-group">
        <label for="signupEmail">Email:</label>
        <input type="email" class="form-control" id="signupEmail" name="signupEmail" placeholder="Enter your email">
    </div>
    <div class="form-group">
        <label for="signupPassword">Password:</label>
        <input type="password" class="form-control" id="signupPassword" name="signupPassword" placeholder="Enter your password">
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="acceptTerms" name="acceptTerms">
        <label class="form-check-label" for="acceptTerms">I agree and consent to the collection, use or otherwise processing of my personal data by Casamia Furniture Center, Inc. (“Our Home”) and its service group. I agree to be bound by the Website’s Terms of Service and Privacy Notice. </label>
    </div>
    <button type="submit" class="btn btn-create-account mt-3" id="createAccountBtn">Create</button>
</form>

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
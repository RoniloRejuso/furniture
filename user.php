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
                <nav class="navbar navbar-light bg-light">
                    <a href="index.html" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
                </nav>
                </div>
            </div>
        <div class="user_settings_section text-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="account-form px-4 py-3">
                            <div class="profile-section mb-">
                                <img src="images/profile-pic.jpg" class="profile-pic" alt="Profile Picture">
                                <div class="name"><h3>User</h3>
                                </div>
                            </div>

                            <form action="update_settings.php" method="POST">
                                <div class="form-group position-relative">
                                    <label for="username" class="d-none">Username:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="username" name="username" value="Current Username" readonly>
                                        <div class="input-group-append">
                                        </div>
                                    </div>
                                </div>
                            <div class="form-group position-relative">
                                <label for="email" class="d-none">Email:</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" id="email" name="email" value="current@example.com" readonly>
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group position-relative">
                                <label for="contact" class="d-none">Contact Number:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="contact" name="contact" value="1234567890" readonly>
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group position-relative">
                                <label for="address" class="d-none">Address:</label>
                                <div class="input-group">
                                    <textarea class="form-control" id="address" name="address" rows="3" readonly>Current Address</textarea>
                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" id="save_button" style="display: none;">Save Changes</button>
                        </form>
                        <div class="logout-btn">
                            <button type="button" class="btn custom-logout-btn">Logout</button>
                        </div>
                    </div>
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
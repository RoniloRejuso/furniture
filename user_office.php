<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
   <body>
      <!-- header section start -->
      <?php
include 'user_body.php';
?>
      <!-- header section end -->

<!-- Office Section -->
<div class="office_section">
    <div class="container">
        <div class="row">
            <?php
            // Establish a database connection and fetch home office products
            $conn = new mysqli("localhost", "username", "password", "furniture");

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepare and execute SQL statement to fetch home office products
            $stmt = $conn->prepare("SELECT product_name, price, product_image, product_id FROM products WHERE category = 'home_office' AND status = 'Available'");
            $stmt->execute();
            $result = $stmt->get_result();

            // Loop through the fetched products
            while ($product = $result->fetch_assoc()) {
            ?>
                <div class="col-lg-3 col-md-6">
                    <div class="product_item">
                        <!-- Product Image -->
                        <img src="<?php echo $product['product_image']; ?>" alt="<?php echo $product['product_name']; ?>">
                        <!-- Product Name -->
                        <h4><?php echo $product['product_name']; ?></h4>
                        <!-- Product Price -->
                        <p><?php echo $product['price']; ?></p>
                        <!-- Heart Icon for Adding to Favorites -->
                        <button class="add-to-favorites"><i class="fas fa-heart"></i></button>

                        <a href="user_prod.php?id=<?php echo $product['product_id']; ?>" class="product-details-link">View Details</a>
                    </div>
                </div>
            <?php
            }
            // Close database connection
            $stmt->close();
            $conn->close();
            ?>
        </div>
    </div>
</div>


<?php
include 'user_footer.php';
?>
      
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
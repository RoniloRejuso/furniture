<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
   <body>
   <?php
include 'user_body.php';
?>
      <!-- header section end -->

      <!-- new product section start -->
      <div class="new_product_section">
         <div class="container">
            <input type="text" name="search" placeholder="Search products">
            <!-- Sorting and Filtering Section -->
            <div class="sorting_filtering_section">
            <!-- Sorting options -->
               <select name="sort_by">
                  <option value="default">Default Sorting</option>
                  <option value="name_asc">Name: A to Z</option>
                  <option value="name_desc">Name: Z to A</option>
                  <option value="price_asc">Price: Low to High</option>
                  <option value="price_desc">Price: High to Low</option>
               </select>
               <select name="filter_by_category">
                  <option value="all">All Categories</option>
               </select>
            <!-- Total newly added products -->
            <?php
               // Simulated data for newly added products
               $newly_added_products = 10; // Example count of newly added products
               ?>
               <p><?php echo $newly_added_products;?> Products: </p>

            </div>
            
            <!-- Product Grid Section -->
            <div class="product_grid_section">
               <?php
                  // Simulated product data
                  $products = array(
                     array("name" => "Product 1", "price" => 100, "category" => "Category 1"),
                     array("name" => "Product 2", "price" => 150, "category" => "Category 2"),
                     // More product data
                  );

                  // Pagination and product display
                  $limit = 6; // Number of products per page
                  $page = isset($_GET['page']) ? $_GET['page'] : 1;
                  $offset = ($page - 1) * $limit;
                  $total_products = count($products);
                  $total_pages = ceil($total_products / $limit);
                  
                  // Display products based on pagination
                  for ($i = $offset; $i < min($offset + $limit, $total_products); $i++) {
                     echo "<div class='product'>";
                     echo "<h3>" . $products[$i]['name'] . "</h3>";
                     echo "<p>Price: $" . $products[$i]['price'] . "</p>";
                     echo "<p>Category: " . $products[$i]['category'] . "</p>";
                     echo "</div>";
                  }

                  // Display total number of products
                  echo "<p>Total Products: " . $total_products . "</p>";

                  // Pagination links
                  echo "<div class='pagination'>";
                  for ($i = 1; $i <= $total_pages; $i++) {
                     echo "<a href='?page=" . $i . "'>" . $i . "</a>";
                  }
                  echo "</div>";
               ?>
            </div>
         </div>
      </div>
      <!-- new product section end -->
      <!-- new product section end -->

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
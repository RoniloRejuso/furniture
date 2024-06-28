<?php
session_start();
include('dbcon.php');

if (!isset($_SESSION['user_id'])) {
   $_SESSION['message'] = "You must log in first";
   header("Location: user_login.php");
   exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
   <body>
      <?php
include 'user_body.php';
?>
      <div class="sale_product_section">
         <div class="container">
         <div class="col-sm-12">
                <h1 class="product_taital">Sale</h1>
            </div>
            <input type="text" name="search" placeholder="Search products">
            <div class="sorting_filtering_section">
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
               <?php
                  $sale_products_count = 15; // Example count of sale products
               ?>
               <p><?php echo $sale_products_count;?> Products on Sale</p>
            </div>

            <div class="product_grid_section">
               <?php
                  // Simulated product data for sale
                  $sale_products = array(
                     array("name" => "Sale Product 1", "price" => 80, "category" => "Category 1"),
                     array("name" => "Sale Product 2", "price" => 120, "category" => "Category 2"),
                     // More sale product data
                  );

                  // Pagination and product display
                  $limit = 6; // Number of products per page
                  $page = isset($_GET['page']) ? $_GET['page'] : 1;
                  $offset = ($page - 1) * $limit;
                  $total_sale_products = count($sale_products);
                  $total_pages = ceil($total_sale_products / $limit);
                  
                  // Display products based on pagination
                  for ($i = $offset; $i < min($offset + $limit, $total_sale_products); $i++) {
                     echo "<div class='product'>";
                     echo "<h3>" . $sale_products[$i]['name'] . "</h3>";
                     echo "<p>Price: $" . $sale_products[$i]['price'] . "</p>";
                     echo "<p>Category: " . $sale_products[$i]['category'] . "</p>";
                     echo "</div>";
                  }

                  // Display total number of sale products
                  echo "<p>Total Sale Products: " . $total_sale_products . "</p>";

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
      <div class="floating-navbar">
        <a href="user_index.php"><i class="fas fa-home"></i></a>
        <a href="user_prod.php"><i class="fas fa-couch"></i></a>
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
            document.getElementById("mySidenav").style.width = "360px";
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
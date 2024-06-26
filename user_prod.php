<?php
include('dbcon.php');
@include 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
   <body>
   <?php
include 'user_body1.php';
?>
<div class="product_section layout_padding">
    <div class="container" style="padding:20px;">
        <div class="col-sm-12">
            <h1 class="product_taital">All Products</h1>
        </div>
        <div class="search-section" style="text-align: center;">
            <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products" style="margin: 0 auto; display: inline-block;border: 1px solid gray;">
            <button type="submit" class="search-icon" style="padding:3px 10px;background-color:#964B33;color:white;border-radius:3px;"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="sorting_filtering_section" style="text-align: center; margin-top: 10px;">
            <form method="GET" action="" id="filterForm">
                <select name="sort_by" style="padding:10px;" onchange="document.getElementById('filterForm').submit();">
                <option value="default">Default Sorting</option>
                <option value="name_asc">Name: A to Z</option>
                <option value="name_desc">Name: Z to A</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                </select>
                <select name="filter_by_category" style="padding:10px;" onchange="document.getElementById('filterForm').submit();">
                    <option value="all">All Categories</option>
                    <option value="bedroom">Bedroom</option>
                    <option value="dining_room">Dining Room</option>
                    <option value="living_room">Living Room</option>
                    <option value="office">Office</option>
                </select>
            </form>
        </div>
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
                echo '<div style="padding: 20px;text-align:center;margin: 0 auto;"><br>';
                echo '<b>No Products available.</b>';
                echo '</div>';
            }

            mysqli_close($conn);

            shuffle($products);
            ?>

            <?php foreach ($products as $product) { ?>
                <div class="col-lg-3 col-sm-6">
                    <a href="product_details1.php?product_id=<?php echo $product['product_id']; ?>">
                        <div class="product_box">
                            <img src="<?php echo $product['product_image']; ?>" class="image_1" alt="Product Image">
                            <div class="product-info">
                                <h4 class="product-name" style="margin-left: 20px;">
                                    <b><big>Our Home</big></b>&nbsp;<b><big><?php echo $product['product_name']; ?></big></b>
                                </h4>
                                <h3 class="product-price" style="color: black; float: right;">₱<?php echo $product['price']; ?></h3><br><br>
                            </div>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="floating-navbar">
    <a href="user_index.php"><i class="fas fa-home"></i></a>
    <a href="#" class="active"><i class="fas fa-couch"></i></a>
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
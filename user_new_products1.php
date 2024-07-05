<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
<body>
<style>
.sorting_filtering_section{
    text-align: center;
    margin-top: 10px;
}
@media (max-width: 320px) {
    .sorting_filtering_section form {
        flex-direction: column;
        align-items: stretch;
    }

    .sorting_filtering_section select {
        width: 130px;
        font-size: 12px;
    }
}
@media (max-width: 576px) {
    .divider-line {
        width: 30%;
    }
    .product_box {
        width: 170px;
        height: 200px;
        margin: 10px 5px;
        padding: 5px;
    }
    .image_1 {
        height: 100px;
        margin: 5px 0;
    }
    .product-name {
        float: left;
        margin-right: 5px;
        width: 140px;
        font-size: 14px;
    }
    .product-price {
        font-size: 14px;
        margin: 0 0 0 20px;
    }
}

@media (max-width: 400px) {
    .divider-line {
        width: 27%;
    }
    .product_box {
        width: 150px;
        padding: 5px;
        margin: 20px 0 0 5px;
    }
    .image_1 {
        height: 100px;
        margin: 5px 0;
    }
    .product-name {
        float: left;
        margin-right: 5px;
        width: 120px;
        font-size: 12px;
    }
    .product-price {
        font-size: 13px;
        margin: 0 0 0 20px;
    }
}

@media (max-width:320px) {
    .divider-line {
        width: 21%;
    }
    .product_box {
        width: 130px;
        height: 170px;
        margin: 20px 0 0 0;
    }
    .image_1 {
        height: 70px;
    }
    .product-name {
        float: left;
        margin-right: 5px;
        width: 100px;
        font-size: 12px;
    }
    .product-price {
        float: right;
        font-size: 11px;
        margin: 0 0 0 20px;
    }
}
</style>
<?php
include 'user_body1.php';
?>
<div class="new_product_section">
   <div class="container">
      <div class="col-sm-12">
         <h1 class="product_taital">New Products</h1>
      </div>
      <div class="search-section" style="text-align: center;">
         <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>" style="margin: 0 auto; display: inline-block; border: 1px solid gray;">
            <button type="submit" class="search-icon" style="padding:3px 10px;background-color:#964B33;color:white;border-radius:3px;"><i class="fas fa-search"></i></button>
         </form>
      </div>
      <div class="sorting_filtering_section">
         <form method="GET" action="" id="filterForm">
            <select name="sort_by" style="padding:5px;border: 1px solid gray;" onchange="document.getElementById('filterForm').submit();">
               <option value="default" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'default') ? 'selected' : ''; ?>>Default Sorting</option>
               <option value="name_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'name_asc') ? 'selected' : ''; ?>>Name: A to Z</option>
               <option value="name_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'name_desc') ? 'selected' : ''; ?>>Name: Z to A</option>
               <option value="price_asc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_asc') ? 'selected' : ''; ?>>Price: Low to High</option>
               <option value="price_desc" <?php echo (isset($_GET['sort_by']) && $_GET['sort_by'] == 'price_desc') ? 'selected' : ''; ?>>Price: High to Low</option>
            </select>
            <select name="filter_by_category" style="padding:5px;border: 1px solid gray;" onchange="document.getElementById('filterForm').submit();">
               <option value="all" <?php echo (isset($_GET['filter_by_category']) && $_GET['filter_by_category'] == 'all') ? 'selected' : ''; ?>>All Categories</option>
               <option value="bedroom" <?php echo (isset($_GET['filter_by_category']) && $_GET['filter_by_category'] == 'bedroom') ? 'selected' : ''; ?>>Bedroom</option>
               <option value="dining_room" <?php echo (isset($_GET['filter_by_category']) && $_GET['filter_by_category'] == 'dining_room') ? 'selected' : ''; ?>>Dining Room</option>
               <option value="living_room" <?php echo (isset($_GET['filter_by_category']) && $_GET['filter_by_category'] == 'living_room') ? 'selected' : ''; ?>>Living Room</option>
               <option value="home_office" <?php echo (isset($_GET['filter_by_category']) && $_GET['filter_by_category'] == 'home_office') ? 'selected' : ''; ?>>Office</option>
            </select>
         </form>
      </div>
      <div class="row">
         <?php
         include 'dbcon.php';

         // Check connection
         if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
         }

         // Handle search query
         $search_query = isset($_GET['search']) ? $_GET['search'] : '';
         $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'default';
         $category_filter = isset($_GET['filter_by_category']) ? $_GET['filter_by_category'] : 'all';

         // SQL query
         $sql = "SELECT product_name, price, product_image, product_id FROM products WHERE date <= NOW()";
         
         // Add search condition
         if (!empty($search_query)) {
            $sql .= " AND product_name LIKE '%$search_query%'";
         }

         // Add category filter condition
         if ($category_filter != 'all') {
            $sql .= " AND category = '$category_filter'";
         }

         // Add sorting condition
         switch ($sort_by) {
            case 'name_asc':
               $sql .= " ORDER BY product_name ASC";
               break;
            case 'name_desc':
               $sql .= " ORDER BY product_name DESC";
               break;
            case 'price_asc':
               $sql .= " ORDER BY price ASC";
               break;
            case 'price_desc':
               $sql .= " ORDER BY price DESC";
               break;
            default:
               $sql .= " ORDER BY date DESC";
               break;
         }

         $stmt = $conn->prepare($sql);
         $stmt->execute();
         $result = $stmt->get_result();

         while ($product = $result->fetch_assoc()) {
         ?>
            <div style="margin-left:18px;">
               <a href="product_details1.php?product_id=<?php echo $product['product_id']; ?>">
                  <div class="product_box">
                     <img src="<?php echo $product['product_image']; ?>" class="image_1" alt="Product Image">
                     <div class="product-info">
                        <h4 class="product-name">
                           <b>Our Home </b><b><?php echo $product['product_name'];?></b>
                        </h4>
                        <h3 class="product-price">₱<?php echo $product['price']; ?></h3><br><br>
                     </div>
                  </div>
               </a>
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

<div class="floating-navbar">
   <a href="index.php"><i class="fas fa-home"></i></a>
   <a href="user_prod.php"><i class="fas fa-couch"></i></a>
   <a href="user_carts.php"><i class="fas fa-shopping-bag"></i></a>
   <a href="user.php"><i class="fas fa-user"></i></a>
</div>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/owl.carousel.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

</body>
</html>
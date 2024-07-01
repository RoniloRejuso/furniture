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
            <input type="text" name="search" placeholder="Search products" style="margin: 0 auto; display: inline-block;border: 1px solid gray;"
>
            <button type="submit" class="search-icon" style="padding:3px 10px;background-color:#964B33;color:white;border-radius:3px;"><i class="fas fa-search"></i></button>
            </form>
      </div>
      <div class="sorting_filtering_section">
         <form method="GET" action="" id="filterForm">
            <select name="sort_by" style="padding:5px;border: 1px solid gray;" onchange="document.getElementById('filterForm').submit();">
               <option value="default">Default Sorting</option>
               <option value="name_asc">Name: A to Z</option>
               <option value="name_desc">Name: Z to A</option>
               <option value="price_asc">Price: Low to High</option>
               <option value="price_desc">Price: High to Low</option>
            </select>
            <select name="filter_by_category" style="padding:5px;border: 1px solid gray;" onchange="document.getElementById('filterForm').submit();">
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
            $conn = mysqli_connect('localhost', 'root', '', 'furniture');

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
   <a href="user_index.php"><i class="fas fa-home"></i></a>
   <a href="user_prod.php"><i class="fas fa-couch"></i></a>
   <a href="user_carts.php"><i class="fas fa-shopping-bag"></i></a>
   <a href="user.php"><i class="fas fa-user"></i></a>
</div>
</body>
</html>
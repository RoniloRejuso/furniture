<?php
session_start();
include 'dbcon.php';
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
<style>
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
   <body>

      <?php
include 'user_body.php';
?>

      <div class="living_room_section">
      <div class="container" style="padding:20px;">
      <div class="col-sm-12">
                <h1 class="product_taital">Living Room</h1>
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
            </form>
        </div>
         <div class="row">
               <?php
            
                include 'dbcon.php';

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
    
                // Get search and sort parameters
                $search = isset($_GET['search']) ? $_GET['search'] : '';
                $sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'default';
    
                // Base SQL query
                $sql = "SELECT product_name, price, product_image, product_id FROM products WHERE category = 'living_room' AND status = 'Available'";
    
                // Add search condition
                if (!empty($search)) {
                    $sql .= " AND product_name LIKE ?";
                }
    
                // Add sorting
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
                        $sql .= " ORDER BY product_id";
                        break;
                }
    
                // Prepare and execute the statement
                $stmt = $conn->prepare($sql);
    
                if (!empty($search)) {
                    $search_param = "%$search%";
                    $stmt->bind_param("s", $search_param);
                }
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
</div><br><br>
      <div class="floating-navbar">
            <a href="user_home.php"><i class="fas fa-home"></i></a>
            <a href="user_product.php"><i class="fas fa-couch"></i></a>
            <a href="user_carts.php"><i class="fas fa-shopping-bag"></i></a>
            <a href="user.php?user_id=<?php echo $_SESSION['user_id']; ?>"><i class="fas fa-user"></i></a>
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
   </body>
</html>
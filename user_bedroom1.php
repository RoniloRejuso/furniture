<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';

?>
   <body>
      <?php
include 'user_body1.php';
?>

            <div class="bedroom_section">
            <div class="container" style="padding:20px;">
            <div class="col-sm-12">
                <h1 class="product_taital">Bedroom</h1>
            </div>
            <div class="search-section" style="text-align: center;">
         <form method="GET" action="">
            <input type="text" name="search" placeholder="Search products" style="margin: 0 auto; display: inline-block;border: 1px solid gray;"
>
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
            $conn= mysqli_connect('localhost', 'root', '', 'furniture');

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $selected_category = $_POST['category'] ?? $_GET['category'] ?? 'bedroom'; // Default to 'bedroom' if not provided

            $stmt = $conn->prepare("SELECT product_name, price, product_image, product_id FROM products WHERE category = ? AND status = 'Available'");
            $stmt->bind_param("s", $selected_category);
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
        <a href="user_index.php"><i class="fas fa-home"></i></a>
        <a href="user_prod.php"><i class="fas fa-couch"></i></a>
        <a href="user_carts.php"><i class="fas fa-shopping-bag"></i></a>
        <a href="user.php"><i class="fas fa-user"></i></a>
      </div>
   </body>
</html>
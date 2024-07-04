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
<body>
<?php
include 'user_body1.php';
?>
<div class="product_section layout_padding">
    <div class="container" style="padding:20px;">
        <div class="col-sm-12">
            <h1 class="product_taital">All products</h1>
        </div>
        <div class="search-section" style="text-align: center;">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search products" style="margin: 0 auto; display: inline-block;border: 1px solid gray;">
                <button type="submit" class="search-icon" style="padding:3px 10px;background-color:#964B33;color:white;border-radius:3px;"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="sorting_filtering_section">
            <form method="GET" action="" id="filterForm">
                <select name="sort_by" style="padding:5px;" onchange="document.getElementById('filterForm').submit();">
                <option value="default">Default Sorting</option>
                <option value="name_asc">Name: A to Z</option>
                <option value="name_desc">Name: Z to A</option>
                <option value="price_asc">Price: Low to High</option>
                <option value="price_desc">Price: High to Low</option>
                </select>
                <select name="filter_by_category" style="padding:5px;" onchange="document.getElementById('filterForm').submit();">
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
            <?php } ?>
        </div>
        <div class="recommended_products"><br><br>
            <h2><small><b>Recommended for You</b></small></h2>
                <div class="row">
                    <?php
                    include 'dbcon.php';

                    function generateRecommendations($transactions, $minSupport) {
                        $allProducts = [];
                        foreach ($transactions as $transaction) {
                            $products = explode(', ', $transaction["product_name"]);
                            $allProducts = array_merge($allProducts, $products);
                        }
                        return array_unique($allProducts);
                    }

                    $conn = mysqli_connect($servername, $username, $password, $database);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = " SELECT p.product_id, p.product_name, p.price, p.product_image
                    FROM orders o
                    JOIN cart c ON o.cart_id = c.cart_id
                    JOIN cart_items ci ON c.cart_id = ci.cart_id
                    JOIN products p ON ci.product_id = p.product_id
                    WHERE o.orders_id = ?;";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $_GET['order_id']);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        $transactions = [];
                        while ($row = $result->fetch_assoc()) {
                            $transactions[] = $row;
                        }

                        $minSupport = 0.1;
                        $recommendations = generateRecommendations($transactions, $minSupport);

                        shuffle($recommendations);

                        $displayLimit = 4;
                        $count = 0;

                        foreach ($recommendations as $product) {
                            foreach ($transactions as $transaction) {
                                if ($product == $transaction["product_name"]) {
                                    $product_id = $transaction["product_id"];
                                    $price = $transaction["price"];
                                    $product_image = $transaction["product_image"];
                                    break;
                                }
                            }

                            echo '<div class="product_box" style="width: 250px;margin: 0 auto;">';
                            echo '<a href="product_details.php?product_id=' . $product_id . '">';
                            echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                            echo '<div class="product-info">';
                            echo '<h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big>' . $product . '</big></b></h4>';
                            echo '<h3 class="product-price" style="color: black; float: right;">₱' . $price . '.00</h3><br><br>';
                            echo '</div>';
                            echo '</a>';
                            echo '</div>';

                            $count++;
                            if ($count >= $displayLimit) {
                                break;
                            }
                        }
                    } else {
                        echo '<div style="padding: 20px;text-align:center;margin: 0 auto;"><br>';
                        echo '<b>No Products available.<b>';
                        echo '</div>';
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="floating-navbar">
    <a href="user_home.php"><i class="fas fa-home"></i></a>
    <a href="#" class="active"><i class="fas fa-couch"></i></a>
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
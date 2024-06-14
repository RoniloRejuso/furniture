<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location:user_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'user_header.php'; ?>
<style>
        .btn {
             display: flex;
            justify-content: center;       
        }

    .product-name {
        float: left;
        margin-right: 20px;
    }
</style>
</head>
<body>
<?php include 'user_body.php'; ?>

<div class="product_section layout_padding">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="product_taital">Our Products</h1>
            </div>
        </div>
        <div class="product_section_2 layout_padding">
            <div class="row">
                    <?php
                    include "dbcon.php";

                    $sql = "SELECT * FROM products LIMIT 4"; // Limiting to fetch only 4 products
                    $result = mysqli_query($conn, $sql);
                    $products = [];

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $products[] = $row;
                        }
                    } else {
                        echo "No products found.";
                    }

                    mysqli_close($conn);
                    ?>
                    <?php foreach ($products as $product) { ?>
                        <div class="col-lg-3 col-sm-6">
                            <a href="product_details.php?product_id=<?php echo $product['product_id']; ?>">
                                <div class="product_box">
                                    <img src="<?php echo $product['product_image']; ?>" class="image_1" alt="Product Image">
                                    <div class="product-info">
                                        <h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big><?php echo $product['product_name']; ?></big></b></h4>
                                        <h3 class="product-price" style="color: black; float: right;">₱<?php echo $product['price']; ?></h3><br><br>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php } ?>
                </div><br><br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="user_prod.php" class="btn" style="background-color: #964B33;color:#fff; width: 300px; margin:0 auto;">See More</a> <!-- Linking to user_prod.php -->
                    </div>
                </div>
            </div>
        <div class="recommended_products">
         <br><br>
         <h2><small><b>Recommended for You</b></small></h2>
         <div class="row">
         <?php
                include 'config.php';

                function generateRecommendations($transactions, $minSupport) {
                    $allProducts = [];
                    foreach ($transactions as $transaction) {
                        $products = explode(', ', $transaction["product_name"]);
                        $allProducts = array_merge($allProducts, $products);
                    }
                    return array_unique($allProducts);
                }
    
                $conn = new mysqli($host, $user, $password, $database);
    
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
    
                $sql = "SELECT product_name, price, product_image FROM orders";
                $result = $conn->query($sql);
    
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
                            $products = explode(', ', $transaction["product_name"]);
                            $prices = explode(', ', $transaction["price"]);
                            $images = explode(', ', $transaction["product_image"]);
    
                            $index = array_search($product, $products);
                            if ($index !== false) {
                                $price = $prices[$index];
                                $product_image = $images[$index];
                                break;
                            }
                        }

                    // Display the product
                    echo '<div class="col-lg-3 col-sm-7">';
                    echo '<div class="product_box">';
                    echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                    echo '<div class="product-info">';
                    echo '<h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big>' . $product . '</big></b></h4>';
                    echo '<h3 class="product-price" style="color: black; float: right;">₱' . $price . '.00</h3><br><br>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';

                    // Increment the count and check the limit
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
    <div class="floating-navbar">
        <a href="#" class="active"><i class="fas fa-home"></i></a>
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

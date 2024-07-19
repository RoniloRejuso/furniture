<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'user_header.php'; ?>
</head>
<style>
    .btn {
        display: flex;
        justify-content: center;       
    }
    .btn:hover {
        opacity: 0.8;
    }
    .row{
        margin: 0;
    }

    .divider-line {
        width: 40%;
    }
    .product_box {
        width: 230px;
        height: 200px;
        margin: 10px 10px;
        padding: 5px;
    }
    .image_1 {
        height: 100px;
        margin: 5px 0;
    }
    .product-name {
        float: left;
        width: 170px;
        font-size: 16px;
    }
    .product-price {
        font-size: 14px;
        margin: 0 0 0 20px;
    }

@media (max-width: 1440px) {
    .divider-line {
        width: 40%;
    }
    .product_box {
        width: 230px;
        height: 200px;
        margin: 10px 10px;
        padding: 5px;
    }
    .image_1 {
        height: 100px;
        margin: 5px 0;
    }
    .product-name {
        float: left;
        width: 120px;
        font-size: 14px;
    }
    .product-price {
        font-size: 14px;
        margin: 0 0 0 20px;
    }
}
@media (max-width: 1024px) {
    .divider-line {
        width: 40%;
    }
    .product_box {
        width: 200px;
        height: 200px;
        margin: 10px 10px;
        padding: 5px;
    }
    .image_1 {
        height: 100px;
        margin: 5px 0;
    }
    .product-name {
        float: left;
        width: 120px;
        font-size: 14px;
    }
    .product-price {
        font-size: 14px;
        margin: 0 0 0 20px;
    }
}
@media (max-width: 768px) {
    .divider-line {
        width: 38%;
    }
    .product_box {
        width: 150px;
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
        width: 120px;
        font-size: 14px;
    }
    .product-price {
        font-size: 14px;
        margin: 0 0 0 20px;
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
    .row{
        margin: 0 auto;
    }
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
<?php include 'user_body1.php'; ?>
<div class="product_section layout_padding">
    <div class="container">
        <div class="col-sm-12">
            <h1 class="product_taital">Our Products</h1>
        </div>
        <div class="search-section" style="text-align: center;">
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search products" style="margin: 0 auto; display: inline-block; border: 1px solid gray;">
                <button type="submit" class="search-icon" style="padding:3px 10px;background-color:#964B33;color:white;border-radius:3px;"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="product_section_2 layout_padding">
            <div class="row">
                    <?php
                    include 'dbcon.php';

                    if (isset($_GET['search']) && !empty($_GET['search'])) {
                        $search = $conn->real_escape_string($_GET['search']);
                        $sql = "SELECT * FROM products WHERE product_name LIKE '%$search%' OR product_id LIKE '%$search%'";
                    } else {
                        $sql = "SELECT * FROM products LIMIT 12";
                    }

                    $result = mysqli_query($conn, $sql);
                    $products = [];

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $products[] = $row;
                        }
                    } else {
                        echo '<div style="padding: 20px;text-align:center;margin: 0 auto;"><br>';
                        echo '<b>No Products available.<b>';
                        echo '</div>';
                    }

                    mysqli_close($conn);

                    shuffle($products);
                    ?>
                    <?php foreach ($products as $product) { ?>
                    <div style="margin-left: 10px;">
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
                </div><br>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <a href="user_prod.php" class="btn" style="background-color: #964B33;color:#fff; width: 250px; margin:0 auto;">See More</a> <!-- Linking to user_prod.php -->
                    </div>
                </div>
            </div>
            <div class="recommended_products"><br><br>
            <h2></small><span class="divider-line"></span><small><b> Suggested Picks </b></small><span class="divider-line"></span></h2>
                <div class="row">
                <?php
                include 'dbcon.php';

                function generateRecommendations($transactions) {
                    $allProducts = [];
                    foreach ($transactions as $transaction) {
                        $allProducts[] = $transaction["product_name"];
                    }
                    return array_unique($allProducts);
                }

                // Fetch all orders or specific criteria as needed
                $sql = "SELECT p.product_id, p.product_name, p.price, p.product_image
                        FROM order_items oi
                        JOIN products p ON oi.product_id = p.product_id
                        GROUP BY p.product_id, p.product_name, p.price, p.product_image";
                $stmt = $conn->prepare($sql);

                // Debugging: Check if the statement was prepared successfully
                if ($stmt === false) {
                    echo "Error preparing statement: " . $conn->error;
                    exit;
                }

                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $transactions = [];
                    while ($row = $result->fetch_assoc()) {
                        $transactions[] = $row;
                    }

                    $recommendations = generateRecommendations($transactions);
                    shuffle($recommendations);

                    $displayLimit = 4;
                    $count = 0;

                    foreach ($recommendations as $product_name) {
                        foreach ($transactions as $transaction) {
                            if ($product_name == $transaction["product_name"]) {
                                $product_id = $transaction["product_id"];
                                $price = $transaction["price"];
                                $product_image = $transaction["product_image"];
                                break;
                            }
                        }
                        echo '<div style="margin-left:10px;">';
                        echo '<div class="product_box">';
                        echo '<a href="product_details.php?product_id=' . $product_id . '">';
                        echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                        echo '<div class="product-info">';
                        echo '<h4 class="product-name"><b>Our Home</b>&nbsp; <b>' . $product_name . '</b></h4>';
                        echo '<h3 class="product-price" style="color: black; float: right;">₱' . $price . '</h3><br><br>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';
                        echo '</div>';


                        $count++;
                        if ($count >= $displayLimit) {
                            break;
                        }
                    }
                } else {
                    echo '<div style="padding: 20px; text-align:center; margin: 0 auto;"><br>';
                    echo '<b>No Products available.</b>';
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
        <a href="user_login.php"><i class="fas fa-user"></i></a>
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

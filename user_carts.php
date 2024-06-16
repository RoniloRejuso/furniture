<?php
session_start();
include('dbcon.php');
@include 'config.php';

// Handle updates and removal
if (isset($_POST['update_update_btn'])) {
$update_value = mysqli_real_escape_string($conn, $_POST['update_quantity']);
$update_id = mysqli_real_escape_string($conn, $_POST['update_quantity_id']);

    // Check if the new quantity is valid (greater than or equal to 0)
    if ($update_value >= 0) {
        $update_quantity_query = mysqli_query($conn, "UPDATE cart SET quantity = '$update_value' WHERE id = '$update_id'");

        if ($update_quantity_query) {
            header('location: user_carts.php');
        } else {
            die('Failed to update cart quantity: ' . mysqli_error($conn));
        }
    } else {
        die('Invalid quantity value');
    }
}

// Handle single item removal
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM cart WHERE id = '$remove_id'");
    header('location: user_carts.php');
}

// Handle clearing the entire cart
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM cart");
    header('location: user_carts.php');
}

// Handle multiple item checkout
if (isset($_POST['checkout'])) {
    $selected_items = isset($_POST['selected_items']) ? $_POST['selected_items'] : [];

    if (empty($selected_items)) {
        echo "<script>alert('Please select at least one item to checkout');</script>";
    } else {
        // Process multiple item checkout
        $selected_items_str = implode(',', $selected_items);
        header("Location: user_checkout.php?items=$selected_items_str");
        exit;
    }
}
?>
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

    .cart-item1 {
        border-radius: 10px;
        border: transparent;
        padding: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
        background-color: #FFF6EB;
        width: 350px;
        height: 250px;
        margin: 0 auto;
    }

    /* Mobile view adjustments */
    @media (max-width: 768px) {
        .cart-item1 {
            width: 100%;
            height: auto;
            padding: 15px;
            margin: 10px auto;
            box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        }
    }
    .divider-line {
        display: inline-block;
        width: 25%;
        height: 1px;
        background-color: #000;
        vertical-align: middle;
    }
    .custom-checkbox {
    position: absolute;
    top: 10px;
    right: 60px;
    background: none;
    border: none;
    cursor: pointer;
    color: #964B33;
    font-size: 20px;
    transform: scale(1.5);

}
</style>
<body>
<?php include 'user_body.php'; ?>

<div class="second_header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light">
            <a href="user_index.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
        </nav>
    </div>
</div>
<div class="user_settings_section text-center">
    <div class="container" style="background:#f6f6f6;padding:20px;border-radius:10px;">
        <section class="cart-container">
            <form method="post" action="">
                <?php
                $select_cart = mysqli_query($conn, "SELECT * FROM cart");
                $grand_total = 0;
                $item_count = mysqli_num_rows($select_cart);

                if ($item_count > 0) {
                    ?>
                    <label class="checkbox-container" style="transform: scale(1.5);">
                        <input type="checkbox" id="select-all" <?php echo $item_count <= 1 ? "style='display:none;'" : ""; ?>>
                        <span <?php echo $item_count <= 1 ? "style='display:none;user-select: none;'" : ""; ?>>Select All</span>
                    </label>
                    <?php
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        ?>
                        <div class="cart-item">
                            <div class="product-image">
                                <img src="<?php echo $fetch_cart['product_image']; ?>" alt="Product Image">
                            </div>
                            <div class="product-details">
                                <h3><b>Our Home <?php echo $fetch_cart['product_name']; ?></b></h3>
                                <p>Sub Total: ₱<?php echo number_format($sub_total = $fetch_cart['price'] * $fetch_cart['quantity'], 2); ?></p>
                                <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                                <div class="quantity-input">
                                    <button type="button" class="quantity-btn minus" onclick="updateQuantity(<?php echo $fetch_cart['id']; ?>, -1)">-</button>
                                    <input style="width:50px;text-align: center;border:transparent;" type="number" id="quantity_<?php echo $fetch_cart['id']; ?>" name="update_quantity" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9)" value="<?php echo $fetch_cart['quantity']; ?>" min="1" step="1" readonly>
                                    <button type="button" class="quantity-btn plus" onclick="updateQuantity(<?php echo
                                    $fetch_cart['id']; ?>, 1)">+</button>
                                </div>
                                <a href="user_carts.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Are you sure you want to remove product from your cart?')" class="remove-btn"> <i class="fas fa-times"></i></a>
                                <label class="custom-checkbox"><input type="checkbox" name="selected_items[]" value="<?php echo $fetch_cart['id']; ?>"></label>
                            </div>
                        </div>
                        <?php
                        $grand_total += $sub_total;
                    }
                    ?>
                    <div class="cart-total">
                        <?php if ($grand_total > 0): ?>
                            <p><b>Total Amount: ₱ <span id="total_amount"><?php echo $grand_total; ?></span>.00</b></p>
                            <div class="checkout-btn">
                                <button type="submit" class="btn" name="checkout" style="background-color: #964B33;color:#fff; width: 330px;margin: 0 auto;" onclick="return confirmCheckout();" <?php echo $item_count == 0 ? 'disabled' : ''; ?>>Checkout</button>
                            </div>
                        <?php
                        ?>
                        <?php else: ?>
                            <p><b>Total Amount: ₱ <span id="total_amount">0</span>.00</b></p>
                        <?php endif; ?>
                    </div>
                <?php
                } else {
                    echo '<div class="cart-item1">';
                    echo '<div class="product-box">';
                    echo '<img src="png/cart.png" alt="Cart Icon" style="width: 100px; margin-bottom: 20px;">';
                    echo '<div><b>No items in cart.</b></div><br>';
                    echo '<div><a href="user_prod.php" class="btn" style="background-color: #964B33;color:#fff; width: 300px; margin:0 auto;">Browse Products</a></div>';
                    echo '</div>';
                    echo '</div>';
                }
                ?>
            </form>
        </section>

        <div class="recommended_products">
            <br><br>
            <h3><small><span class="divider-line"></span><b> Interested in This? </b><span class="divider-line"></span></small></h3>
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

                // Connect to the database
                $conn = new mysqli($host, $user, $password, $database);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch data from the orders table
                $sql = "SELECT product_name, price, product_image FROM orders";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Store transactions in an array
                    $transactions = [];
                    while ($row = $result->fetch_assoc()) {
                        $transactions[] = $row;
                    }

                    // Generate recommendations
                    $minSupport = 0.1; // Minimum support threshold (adjust as needed)
                    $recommendations = generateRecommendations($transactions, $minSupport);

                    // Shuffle the recommendations
                    shuffle($recommendations);

                    $displayLimit = 1;
                    $count = 0;

                    foreach ($recommendations as $product) {
                        foreach ($transactions as $transaction) {
                            // Explode product_name, price, and product_image
                            $products = explode(', ', $transaction["product_name"]);
                            $prices = explode(', ', $transaction["price"]);
                            $images = explode(', ', $transaction["product_image"]);

                            // Check if product is in current transaction
                            $index = array_search($product, $products);
                            if ($index !== false) {
                                // Get corresponding price and image
                                $price = $prices[$index];
                                $product_image = $images[$index];
                                break;
                            }
                        }

                        echo '<div class="product_box" style="width: 250px;margin: 0 auto;">';
                        echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                        echo '<div class="product-info">';
                        echo '<h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big>' . $product . '</big></b></h4>';
                        echo '<h3 class="product-price" style="color: black; float: right;">₱' . $price . '.00</h3><br><br>';
                        echo '</div>';
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
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.0.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="js/jquery-3.0.0.0.min.js"></script>
<script src="js/plugin.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="js/custom.js"></script>
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

    function updateQuantity(id, change) {
        var quantityInput = document.getElementById('quantity_' + id);
        var newQuantity = parseInt(quantityInput.value) + change;

        if (newQuantity < 1) {
            if (confirm('Are you sure you want to remove item from your cart?')) {
                window.location.href = 'user_carts.php?remove=' + id;
            }
        } else {
            quantityInput.value = newQuantity;

            var formData = new FormData();
            formData.append('update_quantity', newQuantity);
            formData.append('update_quantity_id', id);
            formData.append('update_update_btn', true);

            fetch('user_carts.php', {
                method: 'POST',
                body: formData
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to update quantity.');
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Failed to update quantity.');
            });
        }
    }

    document.getElementById('select-all').addEventListener('change', function () {
        var checkboxes = document.getElementsByName('selected_items[]');
        for (var i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = this.checked;
        }
    });

    function updateTotal() {
        var checkboxes = document.getElementsByName('selected_items[]');
        var total = 0;
        var atLeastOneSelected = false;

        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                var itemPrice = parseFloat(document.getElementById('sub_total_' + checkboxes[i].value).innerText);
                total += itemPrice;
                atLeastOneSelected = true;
            }
        }

        if (atLeastOneSelected) {
            document.getElementById('total_amount').innerText = total.toFixed(2);
        } else {
            document.getElementById('total_amount').innerText = '0.00';
        }
    }

    // Add this function for checkout confirmation
    function confirmCheckout() {
        // Check if at least one item is selected
        var checkboxes = document.getElementsByName('selected_items[]');
        var atLeastOneSelected = false;
        for (var i = 0; i < checkboxes.length; i++) {
            if (checkboxes[i].checked) {
                atLeastOneSelected = true;
                break;
            }
        }

        if (atLeastOneSelected) {
            return confirm('Are you sure you want to proceed to checkout?');
        } else {
            alert('Please select at least one item to checkout');
            return false;
        }
    }

</script>
</body>
</html>

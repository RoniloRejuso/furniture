<?php
session_start();
include('dbcon.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location: user_login.php");
    exit();
}

if (isset($_POST['update_update_btn'])) {
    $update_value = mysqli_real_escape_string($conn, $_POST['update_quantity']);
    $update_id = mysqli_real_escape_string($conn, $_POST['update_quantity_id']);

    if ($update_value >= 0) {
        $update_quantity_query = mysqli_query($conn, "UPDATE cart_items SET quantity = '$update_value' WHERE cart_item_id = '$update_id'");

        if ($update_quantity_query) {
            header('Location: user_carts.php');
            exit();
        } else {
            die('Failed to update cart quantity: ' . mysqli_error($conn));
        }
    } else {
        die('Invalid quantity value');
    }
}

if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    mysqli_query($conn, "DELETE FROM cart_items WHERE cart_item_id = '$remove_id'");
    header('Location: user_carts.php');
    exit();
}

// Handle clearing the entire cart
if (isset($_GET['delete_all'])) {
    // Assuming cart_id is stored in session or user-specific
    $user_id = $_SESSION['user_id']; // Adjust based on your session handling
    mysqli_query($conn, "DELETE FROM cart_items WHERE cart_id IN (SELECT cart_id FROM cart WHERE user_id = '$user_id')");
    header('Location: user_carts.php');
    exit();
}

if (isset($_POST['checkout'])) {
    $selected_items = isset($_POST['selected_items']) ? $_POST['selected_items'] : [];

    if (empty($selected_items)) {
        echo "<script>alert('Please select at least one item to checkout');</script>";
    } else {
        $selected_items_str = implode(',', $selected_items);
        echo "<script>window.location.href = 'user_checkout.php?items=$selected_items_str';</script>";
        exit();
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
    .container {
        background: #f6f6f6;
        padding: 20px;
        border-radius: 10px;
    }
    @media (max-width: 768px) {
        .container {
            background: transparent;
            padding: 0 20px;
        }
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
    <div class="container">
        <section class="cart-container">
            <form method="post" action="">
                <?php
                // Query to fetch cart items with product details
                $user_id = $_SESSION['user_id'];
                $select_cart = mysqli_query($conn, "SELECT ci.cart_item_id, p.product_name, p.price, p.product_image, p.quantity AS available_quantity, ci.quantity
                                                    FROM cart_items ci
                                                    JOIN products p ON ci.product_id = p.product_id
                                                    WHERE ci.cart_id IN (SELECT cart_id FROM cart WHERE user_id = '$user_id')");
                
                $grand_total = 0;
                $item_count = mysqli_num_rows($select_cart);

                if ($item_count > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        ?>
                        <div class="cart-item">
                            <div class="product-image">
                                <img src="<?php echo $fetch_cart['product_image']; ?>" alt="Product Image">
                            </div>
                            <div class="product-details">
                                <h3>Our Home <?php echo $fetch_cart['product_name']; ?></h3>
                                <p>Sub Total: <span id="subtotal_<?php echo $fetch_cart['cart_item_id']; ?>">₱<?php echo number_format($sub_total = $fetch_cart['price'] * $fetch_cart['quantity'], 2); ?></span></p>
                                <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['cart_item_id']; ?>">
                                <input type="hidden" id="price_<?php echo $fetch_cart['cart_item_id']; ?>" value="<?php echo $fetch_cart['price']; ?>">
                                <div class="quantity-input">
                                    <button type="button" class="quantity-btn minus" onclick="updateQuantity(<?php echo $fetch_cart['cart_item_id']; ?>, -1)">-</button>
                                    <input type="number" id="quantity_<?php echo $fetch_cart['cart_item_id']; ?>" name="update_quantity" pattern="\d*" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9); updateSubtotal(<?php echo $fetch_cart['cart_item_id']; ?>)" 
                                        value="<?php echo $fetch_cart['quantity']; ?>" min="1" max="<?php echo $fetch_cart['available_quantity']; ?>" step="1">
                                    <button type="button" class="quantity-btn plus" onclick="updateQuantity(<?php echo $fetch_cart['cart_item_id']; ?>, 1)">+</button>
                                </div>
                                <a href="#" onclick="removeCartItem(<?php echo $fetch_cart['cart_item_id']; ?>)" class="remove-btn"><i class="fas fa-times"></i></a>
                                <label class="custom-checkbox"><input type="checkbox" name="selected_items[]" value="<?php echo $fetch_cart['cart_item_id']; ?>"></label>
                            </div>
                        </div>
                        <?php
                        $grand_total += $sub_total;
                    }
                    ?>
                    <div class="cart-total">
                        <p><b>Total Amount: ₱ <span id="total_amount"><?php echo number_format($grand_total, 2); ?></span></b></p>
                        <div class="checkout-btn">
                            <button type="button" class="btn" name="checkout" style="background-color: #964B33;color:#fff; width: 330px;margin: 0 auto;" onclick="confirmCheckout()" <?php echo $item_count == 0 ? 'disabled' : ''; ?>>Checkout</button>
                        </div>
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

        <div class="recommended_products"><br><br>
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

                    $displayLimit = 1;
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
</div>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function removeCartItem(cart_item_id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to remove this item from your cart?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#964B33',
            cancelButtonColor: '#493A2D',
            confirmButtonText: 'Yes'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'user_carts.php?remove=' + cart_item_id;
            }
        });
    }

    function updateQuantity(cart_item_id, change) {
        var quantityInput = document.getElementById('quantity_' + cart_item_id);
        var newValue = parseInt(quantityInput.value) + change;
        var maxQuantity = parseInt(quantityInput.max); // Fetch maximum quantity allowed
        
        if (newValue <= 0) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to remove this item from your cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#964B33',
                cancelButtonColor: '#493A2D',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'user_carts.php?remove=' + cart_item_id;
                }
            });
        } else if (newValue > maxQuantity) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Quantity exceeds available stock!',
                confirmButtonColor: '#964B33'
            });
        } else {
            quantityInput.value = newValue;
            updateSubtotal(cart_item_id);
        }
    }

    function updateSubtotal(cart_item_id) {
        var quantityInput = document.getElementById('quantity_' + cart_item_id);
        var priceInput = document.getElementById('price_' + cart_item_id);
        var subtotalSpan = document.getElementById('subtotal_' + cart_item_id);

        var quantity = parseInt(quantityInput.value);
        var price = parseFloat(priceInput.value);
        var subtotal = quantity * price;

        subtotalSpan.textContent = '₱' + subtotal.toFixed(2);

        updateTotalAmount();
    }

    function updateTotalAmount() {
        var totalAmountSpan  = document.getElementById('total_amount');
        var totalAmount = 0;

        var subtotals = document.querySelectorAll('.subtotal');

        subtotals.forEach(function(subtotal) {
            totalAmount += parseFloat(subtotal.textContent.replace('₱', ''));
        });

        totalAmountSpan.textContent = totalAmount.toFixed(2);
    }

    function confirmCheckout() {
        var selectedItems = document.querySelectorAll('input[name="selected_items[]"]:checked');
        var totalAmount = 0;

        selectedItems.forEach(function(item) {
            var cartItemId = item.value;
            var quantity = parseInt(document.getElementById('quantity_' + cartItemId).value);
            var price = parseFloat(document.getElementById('price_' + cartItemId).value);
            var subtotal = quantity * price;
            totalAmount += subtotal;
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select at least one item to checkout!',
                confirmButtonColor: '#964B33'
            });
        } else {
            var selectedItemsStr = Array.from(selectedItems, item => item.value).join(',');
            window.location.href = 'user_checkout.php?items=' + selectedItemsStr + '&total=' + totalAmount.toFixed(2);
        }
    }
</script>

</body>
</html>


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
            if ($update_value == 0) {
                mysqli_query($conn, "DELETE FROM cart_items WHERE cart_item_id = '$update_id'");
            }
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

if (isset($_GET['delete_all'])) {
    $user_id = $_SESSION['user_id'];
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
<link rel="stylesheet" href="css/cart.css">
</head>
<body>
<?php include 'user_body.php'; ?>

<div class="second_header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light">
            <a href="user_home.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Home</a>
        </nav>
    </div>
</div>
<div class="user_settings_section text-center">
    <div class="container">
        <section class="cart-container">
            <form method="post" action="">
                <?php
                // Query to fetch cart items with product details and aggregate quantities
                $user_id = $_SESSION['user_id'];
                $select_cart = mysqli_query($conn, "
                    SELECT p.product_id, p.product_name, p.price, p.product_image, SUM(ci.quantity) AS total_quantity
                    FROM cart_items ci
                    JOIN products p ON ci.product_id = p.product_id
                    WHERE ci.cart_id IN (SELECT cart_id FROM cart WHERE user_id = '$user_id')
                    GROUP BY p.product_id, p.product_name, p.price, p.product_image
                ");
                
                $grand_total = 0;
                $item_count = mysqli_num_rows($select_cart);

                if ($item_count > 0) {
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $product_id = $fetch_cart['product_id'];
                        $product_name = $fetch_cart['product_name'];
                        $price = $fetch_cart['price'];
                        $product_image = $fetch_cart['product_image'];
                        $total_quantity = $fetch_cart['total_quantity'];
                        $sub_total = $price * $total_quantity;

                        ?>
                        <div class="cart-item">
                            <div class="product-image">
                                <img src="<?php echo $product_image; ?>" alt="Product Image">
                            </div>
                            <div class="product-details">
                                <h3>Our Home <?php echo $product_name; ?></h3>
                                <p>Sub Total: <span id="subtotal_<?php echo $product_id; ?>">₱<?php echo number_format($sub_total, 2); ?></span></p>
                                <input type="hidden" name="update_quantity_id" value="<?php echo $product_id; ?>">
                                <input type="hidden" id="price_<?php echo $product_id; ?>" value="<?php echo $price; ?>">
                                <div class="quantity-input">
                                    <button type="button" class="quantity-btn minus" onclick="updateQuantity('<?php echo $product_id; ?>', -1)">-</button>
                                    <input type="number" id="quantity_<?php echo $product_id; ?>" name="update_quantity" pattern="\d*" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9); updateSubtotal('<?php echo $product_id; ?>')" 
                                        value="<?php echo $total_quantity; ?>" min="1" step="1">
                                    <button type="button" class="quantity-btn plus" onclick="updateQuantity('<?php echo $product_id; ?>', 1)">+</button>
                                </div>
                                <a href="#" onclick="removeCartItem('<?php echo $product_id; ?>')" class="remove-btn"><i class="fas fa-times"></i></a>
                                <label class="custom-checkbox"><input type="checkbox" name="selected_items[]" value="<?php echo $product_id; ?>"></label>
                            </div>
                        </div>
                        <?php
                        $grand_total += $sub_total;
                    }
                    ?>
                    <div class="cart-total">
                        <p><b>Total Amount: ₱ <span id="total_amount"><?php echo number_format($grand_total, 2); ?></span></b></p>
                        <div class="checkout-btn">
                            <button type="button" class="btn" name="checkout" onclick="confirmCheckout()" <?php echo $item_count == 0 ? 'disabled' : ''; ?>>Checkout</button>
                        </div>
                    </div>
                    <?php
                } else {
                    echo '<div class="cart-item1">';
                    echo '<div class="product-box">';
                    echo '<img src="png/cart.png" alt="Cart Icon" style="width: 100px; margin-bottom: 20px;">';
                    echo '<div><b>No items in cart.</b></div><br>';
                    echo '<div><a href="user_prod.php" class="btn">Browse Products</a></div>';
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
                include 'dbcon.php';

                // Function to generate unique product recommendations
                function generateRecommendations($transactions) {
                    $allProducts = [];
                    foreach ($transactions as $transaction) {
                        $allProducts[] = $transaction["product_name"];
                    }
                    return array_unique($allProducts);
                }

                // Create a connection to the database
                $conn = mysqli_connect($servername, $username, $password, $database);

                // Check for connection errors
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Check if orders_id is provided in the URL
                if (isset($_GET['orders_id']) && is_numeric($_GET['orders_id'])) {
                    $orders_id = intval($_GET['orders_id']);

                    // Debugging: Print the orders_id
                    echo "Orders ID: " . htmlspecialchars($orders_id) . "<br>";

                    // Fetch cart_id associated with the orders_id
                    $cartIdQuery = "SELECT c.cart_id 
                                    FROM orders o
                                    JOIN cart c ON o.cart_id = c.cart_id
                                    WHERE o.orders_id = ?";
                    $stmt = $conn->prepare($cartIdQuery);
                    $stmt->bind_param("i", $orders_id);
                    $stmt->execute();
                    $cartIdResult = $stmt->get_result();

                    // Debugging: Print the number of rows returned
                    echo "Cart ID Rows: " . $cartIdResult->num_rows . "<br>";

                    if ($cartIdResult->num_rows > 0) {
                        $cart = $cartIdResult->fetch_assoc();
                        $cart_id = $cart['cart_id'];

                        // Debugging: Print the cart_id
                        echo "Cart ID: " . htmlspecialchars($cart_id) . "<br>";

                        // Fetch products from cart_items associated with the cart_id
                        $sql = "SELECT p.product_id, p.product_name, p.price, p.product_image
                                FROM cart_items ci
                                JOIN products p ON ci.product_id = p.product_id
                                WHERE ci.cart_id = ?
                                GROUP BY p.product_id, p.product_name, p.price, p.product_image";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("i", $cart_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Debugging: Print the number of rows returned
                        echo "Product Rows: " . $result->num_rows . "<br>";

                        if ($result->num_rows > 0) {
                            $transactions = [];
                            while ($row = $result->fetch_assoc()) {
                                $transactions[] = $row;
                            }

                            $recommendations = generateRecommendations($transactions);
                            shuffle($recommendations);

                            $displayLimit = 1;
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

                                echo '<div class="product_box" style="width: 250px;margin: 0 auto;">';
                                echo '<a href="product_details.php?product_id=' . $product_id . '">';
                                echo '<img src="' . $product_image . '" class="image_1" alt="Product Image">';
                                echo '<div class="product-info">';
                                echo '<h4 class="product-name" style="margin-left: 20px;"><b><big>Our Home</big></b>&nbsp;<b><big>' . htmlspecialchars($product_name) . '</big></b></h4>';
                                echo '<h3 class="product-price" style="color: black; float: right;">₱' . htmlspecialchars($price) . '</h3><br><br>';
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
                    } else {
                        echo '<div style="padding: 20px;text-align:center;margin: 0 auto;"><br>';
                        echo '<b>Invalid order ID.<b>';
                        echo '</div>';
                    }
                } else {
                    echo '<div style="padding: 20px;text-align:center;margin: 0 auto;"><br>';
                    echo '<b>Invalid order ID.<b>';
                    echo '</div>';
                }

                $conn->close();
                ?>
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
        var quantityInput = document.getElementById('quantity_' + product_id);
        var newValue = parseInt(quantityInput.value) + change;
        var maxQuantity = parseInt(quantityInput.max); // Fetch maximum quantity allowed
        
        if (newValue <= 0) {
            Swal.fire({
                text: "You want to remove this item from your cart?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#964B33',
                cancelButtonColor: '#493A2D',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Set the quantity to 0 and submit the form
                    quantityInput.value = 0;
                    document.getElementById('update_form_' + product_id).submit();
                }
            });
        } else if (newValue > maxQuantity) {
            Swal.fire({
                icon: 'error',
                text: 'Quantity exceeds available stock!',
                confirmButtonColor: '#964B33'
            });
        } else {
            quantityInput.value = newValue;
            updateSubtotal(product_id);
        }
    }

    function updateSubtotal(product_id) {
        var quantityInput = document.getElementById('quantity_' + product_id);
        var priceInput = document.getElementById('price_' + product_id);
        var subtotalSpan = document.getElementById('subtotal_' + product_id);

        var quantity = parseInt(quantityInput.value);
        var price = parseFloat(priceInput.value);
        var subtotal = quantity * price;

        subtotalSpan.textContent = '₱' + subtotal.toFixed(2);

        updateTotalAmount();
    }

    function updateTotalAmount() {
        var totalAmountSpan  = document.getElementById('total_amount');
        var totalAmount = 0;

        var subtotals = document.querySelectorAll('[id^="subtotal_"]');

        subtotals.forEach(function(subtotal) {
            totalAmount += parseFloat(subtotal.textContent.replace('₱', ''));
        });

        totalAmountSpan.textContent = totalAmount.toFixed(2);
    }

    function confirmCheckout() {
        var selectedItems = document.querySelectorAll('input[name="selected_items[]"]:checked');
        var totalAmount = 0;

        selectedItems.forEach(function(item) {
            var product_id = item.value;
            var quantity = parseInt(document.getElementById('quantity_' + product_id).value);
            var price = parseFloat(document.getElementById('price_' + product_id).value);
            var subtotal = quantity * price;
            totalAmount += subtotal;
        });

        if (selectedItems.length === 0) {
            Swal.fire({
                icon: 'error',
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

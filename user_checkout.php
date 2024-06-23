<?php
@include 'config.php';
include ('dbcon.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location: user_login.php");
    exit();
}

if (!isset($_SESSION['email'])) {
    header('Location: user_login.php');
    exit();
}

$email = $_SESSION['email'];

// Fetch the user's details from the database
$user_query = mysqli_query($conn, "SELECT user_id, firstname, lastname, address, phone_number FROM users WHERE email = '$email'");
if (mysqli_num_rows($user_query) == 0) {
    die('User not found in the database.');
}
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['user_id'];  // Get the user ID
$firstname = $user_data['firstname'];
$lastname = $user_data['lastname'];
$address_parts = explode(', ', $user_data['address']);
$address = $address_parts[0];
$barangay = isset($address_parts[1]) ? $address_parts[1] : '';
$city = isset($address_parts[2]) ? $address_parts[2] : '';
$province = isset($address_parts[3]) ? $address_parts[3] : '';
$postal_code = isset($address_parts[4]) ? $address_parts[4] : '';
$additional_address = '';
$phone_number = $user_data['phone_number'];

if (isset($_POST['order_btn'])) {
    // Validate and sanitize input data
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $additional_address = mysqli_real_escape_string($conn, $_POST['additional_address']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
    $billing_address_option = mysqli_real_escape_string($conn, $_POST['billing_address']);

    // Compile full address
    $full_address = "$address, $barangay, $city, $province $postal_code";

    // Fetch the cart items
    $cart_query = mysqli_query($conn, "SELECT * FROM cart");
    $price_total = 0;
    $product_details = array();
    $product_images = array();
    $prices = array();
    $quantities = array();
    $product_ids = array();

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name = mysqli_real_escape_string($conn, $product_item['product_name']);
            $quantity = mysqli_real_escape_string($conn, $product_item['quantity']);
            $price = mysqli_real_escape_string($conn, $product_item['price']);
            $product_image = mysqli_real_escape_string($conn, $product_item['product_image']);
            $total_price = $price * $quantity;

            // Fetch product_id for the current product_name
            $fetch_product_id_query = mysqli_query($conn, "SELECT product_id FROM products WHERE product_name = '$product_name'");
            if ($fetch_product_id_query) {
                $product_id_row = mysqli_fetch_assoc($fetch_product_id_query);
                $product_id = $product_id_row['product_id'];
                $product_ids[] = $product_id;
            } else {
                die('Failed to fetch product_id from the database: ' . mysqli_error($conn));
            }

            $price_total += $total_price;
            $product_details[] = $product_name;
            $product_images[] = $product_image;
            $prices[] = $price;
            $quantities[] = $quantity;

            // Update the product quantity in the 'products' table
            $reduce_quantity_query = mysqli_query($conn, "UPDATE products SET quantity = quantity - $quantity WHERE product_name = '$product_name'");
            if (!$reduce_quantity_query) {
                die('Failed to update product quantity in the database: ' . mysqli_error($conn));
            }
        }

        $receipt_details = implode(', ', $product_details);

        // Insert order details into the database
        $insert_order_query = mysqli_query($conn, "INSERT INTO orders (user_id, email, firstname, lastname, address, barangay, city, province, postal_code, additional_address, phone_number, payment_method, billing_address_option, product_ids, product_name, product_image, price, quantity, amount, date) 
                                                  VALUES ('$user_id', '$email', '$firstname', '$lastname', '$full_address', '$barangay', '$city', '$province', '$postal_code', '$additional_address', '$phone_number', '$payment_method', '$billing_address_option', '" . implode(', ', $product_ids) . "', '" . implode(', ', $product_details) . "', '" . implode(', ', $product_images) . "', '" . implode(', ', $prices) . "', '" . implode(', ', $quantities) . "', '$price_total', NOW())");

        if (!$insert_order_query) {
            die('Failed to insert order details into the database: ' . mysqli_error($conn));
        }
    } else {
        die('Your cart is empty!');
    }

    // Clear the cart after successful order placement
    $delete_cart_query = mysqli_query($conn, "DELETE FROM cart");
    if (!$delete_cart_query) {
        die('Failed to clear the cart: ' . mysqli_error($conn));
    }

    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Thank you for shopping!',
            text: 'Your order has been placed successfully.',
            showCancelButton: true,
            confirmButtonText: 'Keep Shopping',
            cancelButtonText: 'Exit',
            confirmButtonColor: '#964B33',
            cancelButtonColor: '#493A2D'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'user_product.php';
            } else {
                window.location.href = 'user_index.php';
            }
        });
    </script>
    ";
    exit; 
}
?>

<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
<style>
.section_container {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 10px;
    background-color: #FFF6EB;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.3);
    width: 90%;
    max-width: 500px;
    margin: 20px auto;
}

@media (min-width: 768px) {
    .section_container {
        width: 100%;
    }
}

.section_container h2 {
    font-size: 1.5em;
    margin-bottom: 15px;
    color: #333;
    font-weight: bold;
}

.section_container input[type="text"],
.section_container input[type="email"],
.section_container input[type="tel"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.additional_address input {
    width: 100%;
    padding: 10px;
    margin-top: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

.section_container label {
    display: block;
    margin-top: 10px;
    color: #333;
}

.payment_section label {
    display: block;
    margin: 10px 0;
}

.order_summary_section {
    margin-bottom: 20px;
}

.checkout_button_section {
    text-align: center;
}

.checkout_button_section .pay_now_btn {
    padding: 15px 30px;
    background-color: #964B33;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 1em;
}

.checkout_button_section .pay_now_btn:hover {
    background-color: #7c3a28;
}

@media (max-width: 768px) {
    .section_container {
        padding: 15px;
    }

    .checkout_button_section .pay_now_btn {
        width: 100%;
    }
}
</style>
<body>
<?php
include 'user_body.php';
?>
<div class="second_header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light">
            <a href="user_prod.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
        </nav>
    </div>
</div>
<div class="user_settings_section text-center">
    <div class="container">
        <div class="checkout_section">
            <form action="" method="post">
                <div class="section_container">
                    <h2>Contact</h2>
                    <div>
                        <input type="email" class="email_input" value="<?= $email ?>" readonly>
                   
</div>
</div>
<div class="section_container">
    <div class="delivery_section">
        <h2>Delivery Address</h2>
        <input type="text" name="firstname" placeholder="First Name" value="<?= $firstname ?>" required>
        <input type="text" name="lastname" placeholder="Last Name" value="<?= $lastname ?>" required>
        <input type="text" name="address" placeholder="Address" value="<?= $address ?>" required>
        <input type="text" name="barangay" placeholder="Barangay" value="<?= $barangay ?>" required>
        <input type="text" name="city" placeholder="City" value="<?= $city ?>" required>
        <input type="text" name="province" placeholder="Province" value="<?= $province ?>" required>
        <input type="text" name="postal_code" placeholder="Postal Code" value="<?= $postal_code ?>" required>
        <div class="additional_address">
            <input type="text" name="additional_address" placeholder="Apartment, Suite, etc..." value="<?= $additional_address ?>">
        </div>
        <input type="tel" name="phone_number" placeholder="Phone Number" value="<?= $phone_number ?>" required>
        <label><input type="checkbox" required> Validate information</label>
    </div>
</div>
<div class="section_container">
    <div class="payment_section">
        <h2>Payment Method</h2>
        <label><input type="radio" name="payment_method" value="cash_on_delivery" required> Cash on Delivery (COD)</label>
    </div>
</div>
<div class="section_container">
    <div class="billing_section">
        <h2>Billing Address</h2>
        <label><input type="radio" name="billing_address" value="same_as_shipping" required> Same as Shipping Address</label>
        <label><input type="radio" name="billing_address" value="different" required> Use Different Billing Address</label>
    </div>
</div>
<div class="section_container">
    <div class="order_summary_section">
        <h2>Order Summary</h2>
        <?php
        $select_cart = mysqli_query($conn, "SELECT ci.cart_item_id, p.product_name, p.price, p.product_image, p.quantity, ci.quantity
                                            FROM cart_items ci
                                            JOIN products p ON ci.product_id = p.product_id
                                            WHERE ci.cart_id IN (SELECT cart_id FROM cart WHERE user_id = '$user_id')");
                            $grand_total = 0;

        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                $grand_total += $total_price;
                echo '<span>' . $fetch_cart['product_name'] . ' (' . $fetch_cart['quantity'] . ')</span>';
            }
        } else {
            echo "<div class='display-order'><span>Your cart is empty!</span></div>";
        }
        ?>
        <span class="grand-total">Total: ₱<?= number_format($grand_total, 2); ?></span>
    </div>
</div>
<div class="checkout_button_section">
    <button class="pay_now_btn" name="order_btn" type="submit">Place Order</button>
</div>
</form>
</div><br><br>
</div>
</div>
<script src="js/script.js"></script>
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
<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "100%";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
</body>
</html>

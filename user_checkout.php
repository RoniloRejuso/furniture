<?php
include 'dbcon.php';
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

$user_query = mysqli_query($conn, "SELECT user_id, firstname, lastname, address, phone_number FROM users WHERE email = '$email'");
if (mysqli_num_rows($user_query) == 0) {
    die('User not found in the database.');
}
$user_data = mysqli_fetch_assoc($user_query);
$user_id = $user_data['user_id'];
$firstname = $user_data['firstname'];
$lastname = $user_data['lastname'];
$address = $user_data['address'] ?? '';
$address_parts = $address ? explode(', ', $address) : [];
$address = $address_parts[0] ?? '';
$barangay = $address_parts[1] ?? '';
$city = $address_parts[2] ?? '';
$province = $address_parts[3] ?? '';
$postal_code = $address_parts[4] ?? '';
$additional_address = '';
$phone_number = $user_data['phone_number'];

$order_placed = false;

if (isset($_POST['order_btn'])) {
    // Validate and sanitize input data
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $barangay = mysqli_real_escape_string($conn, $_POST['barangay']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $postal_code = mysqli_real_escape_string($conn, $_POST['postal_code']);
    $additional_address = mysqli_real_escape_string($conn, $_POST['additional_address']);
    $phone_number = mysqli_real_escape_string($conn, $_POST['phone_number']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    // Compile full address
    $full_address = "$address, $barangay, $city, $province, $postal_code";

    // Update user address in the users table
    $update_user_address_query = mysqli_query($conn, "UPDATE users SET address = '$full_address', phone_number = '$phone_number' WHERE user_id = '$user_id'");

    // Fetch the cart id(s)
    $select_cart_ids = mysqli_query($conn, "SELECT cart_id FROM cart WHERE user_id = '$user_id'");
    if (mysqli_num_rows($select_cart_ids) > 0) {
        $cart_ids = [];
        while ($cart_row = mysqli_fetch_assoc($select_cart_ids)) {
            $cart_ids[] = $cart_row['cart_id'];
        }

        foreach ($cart_ids as $cart_id) {
            // Fetch the cart items for this cart_id
            $select_cart = mysqli_query($conn, "SELECT ci.cart_id, p.product_id, p.product_name, p.price, ci.quantity
                                                FROM cart_items ci
                                                JOIN products p ON ci.product_id = p.product_id
                                                WHERE ci.cart_id = '$cart_id'");

            if (mysqli_num_rows($select_cart) > 0) {
                // Initialize grand total
                $grand_total = 0;

                // Prepare for order insertion
                $insert_order_query = mysqli_query($conn, "INSERT INTO orders (cart_id, payment_method, date) VALUES ('$cart_id', '$payment_method', NOW())");

                if ($insert_order_query) {
                    $order_id = mysqli_insert_id($conn);

                    // Iterate through cart items and insert into order_items
                    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                        $product_id = $fetch_cart['product_id'];
                        $quantity = intval($fetch_cart['quantity']);
                        $price = floatval($fetch_cart['price']);
                        $amount = $price * $quantity;

                        // Update grand total
                        $grand_total += $amount;

                        // Insert order item
                        $insert_order_item_query = mysqli_query($conn, "INSERT INTO order_items (orders_id, product_id, quantity, price, amount)
                        VALUES ('$order_id', '$product_id', '$quantity', '$price', '$amount')");

                        if (!$insert_order_item_query) {
                            die('Failed to insert order item details into the database: ' . mysqli_error($conn));
                        }
                    }

                    // Clear cart items after successful order placement
                    $delete_cart_items_query = mysqli_query($conn, "DELETE FROM cart_items WHERE cart_id = '$cart_id'");
                    if ($delete_cart_items_query) {
                        $order_placed = true;
                    } else {
                        die('Failed to clear the cart items: ' . mysqli_error($conn));
                    }
                } else {
                    die('Failed to insert order details into the database: ' . mysqli_error($conn));
                }
            } else {
                die('Your cart is empty!');
            }
        }
    } else {
        die('Your cart is empty!');
    }
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
    text-align: left;
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
</style>
<body>
<?php include 'user_body.php'; ?>
<div class="second_header_section">
    <div class="container-fluid">
        <nav class="navbar navbar-light bg-light">
            <a href="user_product.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Home</a>
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
                        <input type="text" name="postal_code" placeholder="Postal Code" value="<?= $postal_code ?>" required pattern="\d{4}" title="Postal code must be exactly 4 digits">
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
                        <h2>Shipping Address</h2>
                        <label><input type="radio" name="billing_address" value="same_as_shipping" required> Home Address</label>
                        <label><input type="radio" name="billing_address" value="different" required> Use Other Address</label>

                        <div id="billing_address_fields" style="display: none;">
                            <h3>Enter Billing Address</h3>
                            <input type="text" name="billing_address" placeholder="Address" value="">
                            <input type="text" name="billing_barangay" placeholder="Barangay" value="">
                            <input type="text" name="billing_city" placeholder="City" value="">
                            <input type="text" name="billing_province" placeholder="Province" value="">
                            <input type="text" name="billing_postal_code" placeholder="Postal Code" value="" pattern="\d{4}" title="Postal code must be exactly 4 digits">
                            <div class="additional_billing_address">
                                <input type="text" name="billing_additional_address" placeholder="Apartment, Suite, etc...">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section_container">
                    <div class="order_summary_section">
                        <h2>Order Summary</h2>
                        <?php
                        $select_cart = mysqli_query($conn, "SELECT ci.cart_id, p.product_name, p.price, p.product_image, ci.quantity
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
        </div>
        <br><br>
    </div>
</div>

<?php if ($order_placed) : ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
    icon: 'success',
    title: 'Thank you for shopping!',
    text: 'Your order has been placed successfully.',
    showCancelButton: true,
    confirmButtonText: 'Keep Shopping',
    cancelButtonText: 'Check my Purchase',
    confirmButtonColor: '#964B33',
    cancelButtonColor: '#493A2D'
}).then((result) => {
    if (result.isConfirmed) {
        window.location.href = 'user_product.php';
    } else {
        window.location.href = 'user_purchase.php';
    }
});
document.addEventListener('DOMContentLoaded', (event) => {
    const postalCodeInput = document.querySelector('input[name="postal_code"]');

    postalCodeInput.addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '');

        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4);
        }
    });
});
document.addEventListener('DOMContentLoaded', (event) => {
    const billingAddressRadios = document.querySelectorAll('input[name="billing_address"]');
    const billingAddressFields = document.getElementById('billing_address_fields');

    billingAddressRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'different') {
                billingAddressFields.style.display = 'block';
            } else {
                billingAddressFields.style.display = 'none';
                // Clear the billing address fields when not needed
                billingAddressFields.querySelectorAll('input').forEach(input => input.value = '');
            }
        });
    });

    // Optional: Add validation for new billing address fields if necessary
    document.querySelector('form').addEventListener('submit', function (event) {
        const selectedBillingAddress = document.querySelector('input[name="billing_address"]:checked');
        if (selectedBillingAddress && selectedBillingAddress.value === 'different') {
            const billingFields = billingAddressFields.querySelectorAll('input');
            for (const field of billingFields) {
                if (field.required && !field.value.trim()) {
                    alert('Please fill out all required billing address fields.');
                    event.preventDefault();
                    return;
                }
            }
        }
    });
});
</script>
<?php endif; ?>

</body>
</html>

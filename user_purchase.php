<?php
session_start();
include('dbcon.php');

if (!isset($_SESSION['user_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location: user_login.php");
    exit();
}

function fetchUserPurchases($conn, $user_id) {
    $purchases = [];
    $query = "SELECT o.orders_id, ci.cart_item_id, p.product_name, p.price, p.product_image, ci.quantity, o.date, o.payment_method
                FROM orders o
                JOIN cart c ON o.cart_id = c.cart_id
                JOIN cart_items ci ON c.cart_id = ci.cart_id
                JOIN products p ON ci.product_id = p.product_id
                WHERE c.user_id = ?;";

    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        
        if ($result) {
            while ($fetch_purchase = mysqli_fetch_assoc($result)) {
                $purchases[] = $fetch_purchase;
            }
        } else {
            error_log("Error fetching purchases: " . mysqli_error($conn));
        }

        mysqli_stmt_close($stmt);
    } else {
        error_log("Error preparing statement: " . mysqli_error($conn));
    }

    return $purchases;
}

// Cancel order functionality
if (isset($_GET['cancel'])) {
    $cart_item_id = $_GET['cancel'];
    if (mysqli_query($conn, "DELETE FROM cart_items WHERE cart_item_id = '$cart_item_id'")) {
        header('Location: user_purchase.php');
    } else {
        error_log("Error canceling order: " . mysqli_error($conn));
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'user_header.php'; ?>
    <title>My Purchases</title>
    <style>
        .purchase-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .purchase-item {
            display: flex;
            padding: 20px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
            background-color: #FFF6EB;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.4);
            width: 400px;
        }
        .product-details {
            flex: 3;
            padding: 10px;
        }
    </style>
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
            <section class="purchase-container">
                <?php
                $user_id = $_SESSION['user_id'];
                $purchases = fetchUserPurchases($conn, $user_id);

                if (!empty($purchases)) {
                    foreach ($purchases as $purchase) {
                        ?>
                        <div class="purchase-item">
                            <div class="product-image">
                                <img src="<?php echo htmlspecialchars($purchase['product_image']); ?>" alt="Product Image">
                            </div>
                            <div class="product-details">
                                <h3><?php echo htmlspecialchars($purchase['product_name']); ?></h3>
                                <p>Price: ₱<?php echo number_format($purchase['price'], 2); ?></p>
                                <p>Quantity: <?php echo htmlspecialchars($purchase['quantity']); ?></p>
                                <p>Date: <?php echo htmlspecialchars($purchase['date']); ?></p>
                                <p>Payment Method: <?php echo htmlspecialchars($purchase['payment_method']); ?></p>
                                <button type="button" class="btn btn-danger" onclick="cancelOrder(<?php echo htmlspecialchars($purchase['cart_item_id']); ?>)">Cancel Order</button>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<p>No purchases found.</p>';
                }
                ?>
            </section>
        </div>
    </div>
    <!-- Include necessary scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        // JavaScript function to cancel an order
        function cancelOrder(cart_item_id) {
            Swal.fire({
                text: "You want to cancel this order?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#964B33',
                cancelButtonColor: '#493A2D',
                confirmButtonText: 'Yes'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'user_purchase.php?cancel=' + cart_item_id;
                }
            });
        }
    </script>
</body>
</html>

<?php
mysqli_close($conn);
?>

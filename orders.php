<?php
include 'dbcon.php';

if (isset($_GET['delete_id'])) {
    $product_id = (int)$_GET['delete_id']; // Ensure the ID is an integer

    $delete_query = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $delete_query->bind_param("i", $product_id);

    if ($delete_query->execute()) {
        $_SESSION['message'] = "Order deleted successfully";
        header("Location: orders.php");
        exit(); 
    } else {
        $_SESSION['error'] = "Error deleting record: " . $conn->error;
    }
}

// Fetch cart items with user and product details
$query = "SELECT cart_items.cart_item_id, cart_items.cart_id, cart_items.product_id, cart_items.quantity, cart_items.amount, 
                 cart.user_id, users.firstname, users.lastname, users.address, products.product_name
          FROM cart_items 
          JOIN cart ON cart_items.cart_id = cart.cart_id 
          JOIN users ON cart.user_id = users.user_id 
          JOIN products ON cart_items.product_id = products.product_id 
          ORDER BY cart_items.cart_item_id DESC 
          LIMIT 9"; // Adjust limit as needed

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Our Home</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
<div class="page-wrapper">
    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h4>Orders</h4>
            </div>
        </div>

<div class="card">
    <div class="card-body">
        <div class="table-top">
            <div class="search-set">
                <div class="search-path">

                </div>
                <div class="search-input">

                </div>
            </div>
            <div class="wordset">
                <ul>
                    <li>
                        <a href="users_pdf.php" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                            <img src="assets/img/icons/pdf.svg" alt="img">
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <table class="table datanew">
            <thead>
                <tr>
                    <th>Cart Item ID</th>
                    <th>Customer</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>User ID</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["cart_item_id"]; ?></td>
                            <td><?php echo $row["firstname"] . ' ' . $row["lastname"]; ?></td>
                            <td><?php echo $row["product_name"]; ?></td>
                            <td><?php echo $row["quantity"]; ?></td>
                            <td><?php echo $row["amount"]; ?></td>
                            <td><?php echo $row["user_id"]; ?></td>
                            <td><?php echo $row["address"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No cart items found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const userId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this user?')) {
                window.location.href = `delete_user.php?delete_id=${userId}`;
            }
        });
    });
</script>

<script src="assets/js/jquery-3.6.0.min.js"></script>
<script src="assets/js/feather.min.js"></script>
<script src="assets/js/jquery.slimscroll.min.js"></script>
<script src="assets/js/jquery.dataTables.min.js"></script>
<script src="assets/js/dataTables.bootstrap4.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/plugins/select2/js/select2.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalert2.all.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalerts.min.js"></script>
<script src="assets/js/script.js"></script>
<script>
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();

    $('.delete-btn').click(function(e) {
        e.preventDefault();
        var deleteUrl = '?delete_id=' + $(this).data('id');
        var result = confirm("Are you sure you want to delete this order?");
        if (result) {
            window.location.href = deleteUrl;
        }
    });
});
</script>
</body>
</html>
<?php
$conn->close();
?>

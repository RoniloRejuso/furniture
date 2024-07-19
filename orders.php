<?php
session_start();
include 'dbcon.php';

if (isset($_GET['delete_id'])) {
    $order_item_id = (int)$_GET['delete_id']; // Ensure the ID is an integer

    $delete_query = $conn->prepare("DELETE FROM order_items WHERE order_item_id = ?");
    $delete_query->bind_param("i", $order_item_id);

    if ($delete_query->execute()) {
        $_SESSION['message'] = "Order deleted successfully";
        header("Location: orders.php");
        exit(); 
    } else {
        $_SESSION['error'] = "Error deleting record: " . $conn->error;
    }
}

// Updated query to fetch user_id from cart via orders
$query = "SELECT oi.order_item_id, u.firstname, u.lastname, p.product_name, p.price, p.product_image, oi.quantity, (oi.quantity * p.price) AS amount
          FROM order_items oi
          JOIN products p ON oi.product_id = p.product_id
          JOIN orders o ON oi.orders_id = o.orders_id
          JOIN cart c ON o.cart_id = c.cart_id
          JOIN users u ON c.user_id = u.user_id
          ORDER BY oi.order_item_id";

$result = $conn->query($query);
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
    <title>FurniView</title>
    <link rel="icon" href="images/icon.png">
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
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Product Image</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["order_item_id"]; ?></td>
                            <td><?php echo $row["firstname"]; ?> <?php echo $row["lastname"]; ?></td>
                            <td>Our Home <?php echo $row["product_name"]; ?></td>
                            <td>₱<?php echo number_format($row["price"], 2); ?></td>
                            <td><img src="<?php echo $row["product_image"]; ?>" alt="Product Image" width="50"></td>
                            <td><?php echo $row["quantity"]; ?></td>
                            <td>₱<?php echo number_format($row["amount"], 2); ?></td>
                            <td>
                                <button class="btn btn-danger delete-btn" data-id="<?php echo $row['order_item_id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No orders found</td>
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
            const orderItemId = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this order?')) {
                window.location.href = `orders.php?delete_id=${orderItemId}`;
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
// Ensure select-all checkbox functionality
$('#select-all').click(function(event) {
    $(':checkbox').prop('checked', this.checked);
});

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

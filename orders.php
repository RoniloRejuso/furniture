<?php
include 'dbcon.php';

$conn = mysqli_connect('localhost', 'u138133975_ourhome', 'A@&DDb;7', 'u138133975_furniture');
if (!$conn) {
	echo ("Connection Failed: " . mysqli_connect_error());
	exit;
}
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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

$sql = "SELECT * FROM users";
$result = $conn->query($sql);

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
        
<?php
// Database connection details
$servername = "localhost";  // Replace with your server name
$username = "u138133975_ourhome";  // Replace with your MySQL username
$password = "A@&DDb;7";  // Replace with your MySQL password
$dbname = "u138133975_furniture";  // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch cart items query
$query = "SELECT cart_item_id, cart_id, product_id, quantity, amount
          FROM cart_items
          ORDER BY cart_item_id DESC
          LIMIT 9"; // Adjust limit as needed

$result = $conn->query($query);
?>

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
                    <th>Cart ID</th>
                    <th>Product ID</th>
                    <th>Quantity</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample data row -->
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>101</td>
                    <td>2</td>
                    <td>50.00</td>
                </tr>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["cart_item_id"]; ?></td>
                            <td><?php echo $row["cart_id"]; ?></td>
                            <td><?php echo $row["product_id"]; ?></td>
                            <td><?php echo $row["quantity"]; ?></td>
                            <td><?php echo $row["amount"]; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No cart items found</td>
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

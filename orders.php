<?php
session_start();
include 'dbcon.php';

<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
$conn = mysqli_connect('localhost', 'root', '', 'furniture');
if (!$conn) {
	echo ("Connection Failed: " . mysqli_connect_error());
	exit;
}
<<<<<<< HEAD
=======
=======
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $product_id = (int)$_GET['delete_id']; // Ensure the ID is an integer

    $delete_query = $conn->prepare("DELETE FROM orders WHERE orders_id = ?");
    $delete_query->bind_param("i", $product_id);

    if ($delete_query->execute()) {
        $_SESSION['message'] = "Order deleted successfully";
        header("Location: orders.php");
        exit(); 
    } else {
<<<<<<< HEAD
        $_SESSION['error'] = "Error deleting record: " . $conn->error;
=======
<<<<<<< HEAD
        $_SESSION['error'] = "Error deleting record: " . $conn->error;
=======
        echo "Error deleting record: " . $conn->error;
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
    }
}

$sql = "SELECT * FROM orders";
$result = $conn->query($sql);
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe

if (!$result) {
    die("Query failed: " . $conn->error);
}
<<<<<<< HEAD
=======
=======
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
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
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success">
                        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                    </div>
                <?php endif; ?>
<<<<<<< HEAD
=======
=======
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                <div class="table-top">
                    <div class="search-set">
                        <div class="search-path">
                            <button class="btn btn-filter" id="filter_search">
                                <img src="assets/img/icons/filter.svg" alt="img">
                                <span>
                                    <img src="assets/img/icons/closes.svg" alt="img">
                                </span>
                            </button>
                        </div>
                        <div class="search-input">
                            <button class="btn btn-searchset">
                                <img src="assets/img/icons/search-white.svg" alt="img">
                            </button>
                        </div>
                    </div>
                    <div class="wordset">
                        <ul>
                            <li>
                                <a href="orders_pdf.php" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                    <img src="assets/img/icons/pdf.svg" alt="img">
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-success">
                        <?php 
                            echo $_SESSION['message']; 
                            unset($_SESSION['message']);
                        ?>
                    </div>
                <?php endif; ?>
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                <table class="table datanew">
                    <thead>
                        <tr>
                            <th>
                                <label class="checkboxs">
                                    <input type="checkbox" id="select-all">
                                    <span class="checkmarks"></span>
                                </label>
                            </th>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Price</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>
                                        <label class="checkboxs">
                                            <input type="checkbox">
                                            <span class="checkmarks"></span>
                                        </label>
                                    </td>
                                    <td><?php echo $row["orders_id"]; ?></td>
<<<<<<< HEAD
                                    <td><?php echo $row["name"]; ?></td>
=======
<<<<<<< HEAD
                                    <td><?php echo $row["name"]; ?></td>
=======
                                    <td><?php echo $row["customer"]; ?></td>
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                                    <td><?php echo $row["price"]; ?></td>
                                    <td><?php echo $row["product_name"]; ?></td>
                                    <td><?php echo $row["quantity"]; ?></td>
                                    <td><?php echo $row["amount"]; ?></td>
                                    <td><?php echo $row["date"]; ?></td>
                                    <td>
<<<<<<< HEAD
                                        <a href="#" data-id="<?php echo $row["orders_id"]; ?>" class="btn btn-danger btn-sm delete-btn">Delete</a>
=======
<<<<<<< HEAD
                                        <a href="#" data-id="<?php echo $row["orders_id"]; ?>" class="btn btn-danger btn-sm delete-btn">Delete</a>
=======
                                        <a href="?delete_id=<?php echo $row["orders_id"]; ?>" class="btn btn-danger btn-sm">Delete</a>
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
<<<<<<< HEAD
                                <td colspan="9" class="text-center">No orders found</td>
=======
<<<<<<< HEAD
                                <td colspan="9" class="text-center">No orders found</td>
=======
                                <td colspan="8">No orders found</td>
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
<<<<<<< HEAD
    $(':checkbox').prop('checked', this.checked);
=======
<<<<<<< HEAD
    $(':checkbox').prop('checked', this.checked);
=======
    if(this.checked) {
        $(':checkbox').each(function() {
            this.checked = true;
        });
    } else {
        $(':checkbox').each(function() {
            this.checked = false;
        });
    }
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
});

$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe

    $('.delete-btn').click(function(e) {
        e.preventDefault();
        var deleteUrl = '?delete_id=' + $(this).data('id');
        var result = confirm("Are you sure you want to delete this order?");
        if (result) {
            window.location.href = deleteUrl;
        }
    });
<<<<<<< HEAD
=======
=======
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
});
</script>
</body>
</html>
<?php
$conn->close();
?>

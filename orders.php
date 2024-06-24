<?php
session_start();
include 'dbcon.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $product_id = $_GET['delete_id'];

    $delete_query = "DELETE FROM orders WHERE product_id = $product_id";

    if (mysqli_query($conn, $delete_query)) {
        header("Location: productlist.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

$sql = "SELECT *, IF(quantity = 0, 'Unavailable', status) AS status FROM orders";
$result = $conn->query($sql);
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
                    <h4>Orders List</h4>
                    <h6>Manage your Orders</h6>
                </div>

            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">

                            </div>
                            <div class="search-input">
                                <a class="btn btn-searchset">
                                    <img src="assets/img/icons/search-white.svg" alt="img">
                                </a>
                            </div>
                        </div>
                        <div class="wordset">
                            <ul>
                                <li>
                                    <a href="pdf_product.php" data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                                        <img src="assets/img/icons/pdf.svg" alt="img">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

<?php
$conn = mysqli_connect("localhost", "root", "", "furniture");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$query = "SELECT * FROM orders";

$result = mysqli_query($conn, $query);
?>

<div class="table-responsive">
    <table class="table datanew">
        <thead>
            <tr>
                <th>
                    <label class="checkboxs">
                        <input type="checkbox" id="select-all">
                        <span class="checkmarks"></span>
                    </label>
                </th>
                <th>Orders ID</th>
                <th>Payment</th>
                <th>Card_ID</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result) {
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>
                                <label class="checkboxs">
                                    <input type="checkbox">
                                    <span class="checkmarks"></span>
                                </label>
                              </td>';
                        echo '<td>' . htmlspecialchars($row["orders_id"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["payment_method"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["cart_id"]) . '</td>';
                        echo '<td>' . htmlspecialchars($row["date"]) . '</td>';
                        echo '<td>
                                <a href="?delete_id=' . htmlspecialchars($row["product_id"]) . '">Delete</a>
                              </td>';
                        echo '</tr>';
                    }
                } else {

                    echo "<tr><td colspan='6'>No records found.</td></tr>";
                }
            } else {

                echo "<tr><td colspan='6'>Error: " . mysqli_error($conn) . "</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
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
</body>
</html>

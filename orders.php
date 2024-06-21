<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['admin_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location:login.php");
    exit();
}

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['delete_id'])) {
    $product_id = $_GET['delete_id'];

    $delete_query = "DELETE FROM products WHERE product_id = $product_id";

    if (mysqli_query($conn, $delete_query)) {
        header("Location: productlist.php");
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

$sql = "SELECT *, IF(quantity = 0, 'Unavailable', status) AS status FROM products";
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
                <div class="page-btn">
                    <a href="addproduct.php" class="btn btn-added">
                        <img src="assets/img/icons/plus.svg" alt="img" class="me-1">Add New Product
                    </a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <div class="table-top">
                        <div class="search-set">
                            <div class="search-path">
                                <a class="btn btn-filter" id="filter_search">
                                    <img src="assets/img/icons/filter.svg" alt="img">
                                    <span>
                                        <img src="assets/img/icons/closes.svg" alt="img">
                                    </span>
                                </a>
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
                                    <th>Product ID</th>
                                    <th>Product Name</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>
                                                <label class="checkboxs">
                                                    <input type="checkbox">
                                                    <span class="checkmarks"></span>
                                                </label>
                                              </td>';
                                        echo '<td>' . $row["product_id"] . '</td>';
                                        echo '<td>' . $row["product_name"] . '</td>';
                                        echo '<td>' . $row["status"] . '</td>';
                                        echo '<td>' . $row["price"] . '</td>';
                                        echo '<td>' . $row["quantity"] . '</td>';
                                        echo '<td><img src="' . $row["product_image"] . '" alt="Product Image" width="50"></td>';
                                        echo '<td>
                                                <a href="?delete_id=' . $row["product_id"] . '">Delete</a>
                                              </td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo "<tr><td colspan='8'>0 results</td></tr>";
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

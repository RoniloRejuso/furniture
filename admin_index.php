<?php
session_start();
include 'dbcon.php';

if (!isset($_SESSION['admin_id'])) {
    $_SESSION['message'] = "You must log in first";
    header("Location: login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Our Home</title>
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="assets/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
  <?php
     include 'dbcon.php';
     include 'header.php'
          ?>
      <div class="page-wrapper">
        <div class="content">
          <div class="row">

          <div class="col-lg-4 col-sm-8 col-12">
    <div class="dash-widget">
        <div class="dash-widgetimg">
            <span>
                <img src="assets/img/icons/dash1.svg" alt="img">
            </span>
        </div>
        <div class="dash-widgetcontent">
            <h6>Total Quantity of Products</h6>
            <h5>
                <?php
                $sql = "SELECT SUM(quantity) AS total_quantity FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $totalQuantity = $row['total_quantity'];
                } else {
                    $totalQuantity = null;
                }

                if (is_null($totalQuantity) || $totalQuantity == 0) {
                    echo '<span class="counters" data-count="0">No data available</span>';
                } else {
                    echo '<span class="counters" data-count="' . $totalQuantity . '">' . $totalQuantity . '</span>';
                }
                ?>
            </h5>
        </div>
    </div>
</div>

<div class="col-lg-4 col-sm-8 col-12">
    <div class="dash-widget dash1">
        <div class="dash-widgetimg">
            <span>
                <img src="assets/img/icons/dash2.svg" alt="img">
            </span>
        </div>
        <div class="dash-widgetcontent">
            <h6>Total Price of Products</h6>
            <h5>
                ₱
                <?php
                $sql = "SELECT SUM(price * quantity) AS total_price FROM products";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $totalPrice = $row['total_price'];
                } else {
                    $totalPrice = null;
                }

                if (is_null($totalPrice) || $totalPrice == 0) {
                    echo '<span class="counters" data-count="0">No data available</span>';
                } else {
                    echo '<span class="counters" data-count="' . $totalPrice . '">' . $totalPrice . '</span>';
                }
                ?>
            </h5>
        </div>
    </div>
</div>

<div class="col-lg-4 col-sm-6 col-12">
    <div class="dash-widget dash2">
        <div class="dash-widgetimg">
            <span>
                <img src="assets/img/icons/printer.svg" alt="img">
            </span>
        </div>
        <div class="dash-widgetcontent">
            <h6>Logged-in Admins</h6>
            <h5>
                <?php
                $sql = "SELECT COUNT(*) AS admin_count FROM admin WHERE is_admin = 1";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $adminCount = $row['admin_count'];
                } else {
                    $adminCount = null;
                }

                if (is_null($adminCount) || $adminCount == 0) {
                    echo '<span class="counters" data-count="0">No data available</span>';
                } else {
                    echo '<span class="counters" data-count="' . $adminCount . '">' . $adminCount . '</span>';
                }
                ?>
            </h5>
        </div>
    </div>
</div>
    </div>
</div>
          <div class="row">
            <div class="col-lg-7 col-sm-12 col-12 d-flex">
              <div class="card flex-fill">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                  <h5 class="card-title mb-0">
                    Purchase & Sales
                  </h5>
                  <div class="graph-sets">
                    <ul>
                      <li>
                        <span>
                          Sales
                        </span>
                      </li>
                      <li>
                        <span>
                          Purchase
                        </span>
                      </li>
                    </ul>
                    
                  </div>
                </div>

                <div class="card-body">
    <div id="mixed-chart"></div>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $.ajax({
            url: 'ind.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                if ($('#mixed-chart').length > 0) {
                    var options = {
                        chart: {
                            height: 350,
                            type: 'line',
                            toolbar: {
                                show: false,
                            }
                        },
                        series: [{
                                name: 'Orders',
                                type: 'column',
                                data: response
                            },
                            {
                                name: 'Products Quantity',
                                type: 'line',
                                data: response
                            }
                        ],
                        stroke: {
                            width: [0, 4]
                        },
                        title: {
                            text: 'Products Data'
                        },
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                        xaxis: {
                            type: 'category'
                        },
                        yaxis: [{
                                title: {
                                    text: 'Products Quantity',
                                },
                            },
                            {
                                opposite: true,
                                title: {
                                    text: 'Orders'
                                }
                            }
                        ]
                    }
                    var chart = new ApexCharts(document.querySelector("#mixed-chart"), options);
                    chart.render();
                } else {
                    console.error('No element found with id "mixed-chart".');
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });
</script>


            <div class="col-lg-5 col-sm-12 col-12 d-flex">
              <div class="card flex-fill">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                  <h4 class="card-title mb-0">
                    Best Sellers
                  </h4>
                  <div class="dropdown">
                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false"
                    class="dropset">
                      <i class="fa fa-ellipsis-v">
                      </i>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <li>
                        <a href="productlist.php" class="dropdown-item">
                          Product List
                        </a>
                      </li>
                      <li>
                        <a href="addproduct.php" class="dropdown-item">
                          Product Add.
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
                
                <div class="card-body">
                  <div class="table-responsive dataview">
                  <table class="table datatable">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $servername = "localhost";
                $username = "u138133975_ourhome";
                $password = "A@&DDb;7";
                $database = "u138133975_furniture";

                // Create connection
                $conn= mysqli_connect('localhost', 'u138133975_ourhome', 'A@&DDb;7', 'u138133975_furniture');

                // Check connection
                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }


                      // Query to fetch top 3 products with highest quantity from the database
                      $query = "SELECT product_image, product_name, quantity, price FROM products ORDER BY quantity DESC LIMIT 2";
                      $result = mysqli_query($conn, $query);

                      // Check if there are any rows returned
                      if(mysqli_num_rows($result) > 0) {
                          while($row = mysqli_fetch_assoc($result)) {
                              echo "<tr>";
                              echo "<td><img src='".$row['product_image']."' alt='Product Image'></td>";
                              echo "<td>".$row['product_name']."</td>";
                              echo "<td>".$row['quantity']."</td>";
                              echo "<td>".$row['price']."</td>";
                              echo "</tr>";
                          }
                      } else {
                          echo "<tr><td colspan='4'>No products found</td></tr>";
                      }

                ?>
            </tbody>
        </table>

                  </div>
                </div>
              </div>
            </div>
          </div>

<?php
// Database connection details
$servername = "localhost";  // Replace with your server name
$username = "u138133975_ourhome";     // Replace with your MySQL username
$password = "A@&DDb;7";     // Replace with your MySQL password
$dbname = "u138133975_furniture";  // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch recently added products query
$query = "SELECT product_id, product_name, product_image, quantity, price, date
          FROM products
          WHERE date >= DATE_SUB(NOW(), INTERVAL 4 WEEK)
          ORDER BY date DESC
          LIMIT 9"; // Adjust limit to 9 to account for the 1 static row

$result = $conn->query($query);

?>

<div class="card mb-0">
    <div class="card-body">
        <h4 class="card-title">Newly Added Products</h4>
        <div class="table-responsive dataview">
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Product Quantity</th>
                        <th>Price</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><a href="javascript:void(0);">Nesting Table</a></td>
                        <td class="productimgname">
                            <a class="product-img" href="productlist.html">
                                <img
                                    src="uploads/nestingtable.png"
                                    alt="product"
                                />
                            </a>

                        </td>
                        <td>2</td>
                        <td>30000</td>
                        <td>2024-06-25</td>
                    </tr>
                    <?php
                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>" . $row["product_id"] . "</td>
                                    <td>" . $row["product_name"] . "</td>
                                    <td class='productimgname'>
                                        <a class='product-img' href='productlist.html'>
                                            <img src='" . $row["product_image"] . "' alt='product' />
                                        </a>

                                    </td>
                                    <td>" . $row["quantity"] . "</td>
                                    <td>" . $row["price"] . "</td>
                                    <td>" . $row["date"] . "</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No newly added products found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
</div>
</div>



          

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/feather.min.js"> </script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/plugins/apexchart/apexcharts.min.js"></script>
    <script src="assets/plugins/apexchart/chart-data.js"></script>
    <script src="assets/js/script.js"></script>
  </body>
</html>

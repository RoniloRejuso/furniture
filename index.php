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
     
     include 'header.php';
     include 'session.php';
   
     include 'dbcon.php';
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
                    <h6>
                        Orders
                      </h6>
                  <h5>
                    $
                    <span class="counters" data-count="307144.00">
                      $307,144.00
                    </span>
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
                    <h6>
                        Revenue
                      </h6>
                  <h5>
                    $
                    <span class="counters" data-count="4385.00">
                    </span>
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
                    <h6>
                        Products
                      </h6>
                  <h5>
                    $
                    <span class="counters" data-count="385656.50">
                      385,656.50
                    </span>
                  </h5>
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
                    <div class="dropdown">
                      <button class="btn btn-white btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                      data-bs-toggle="dropdown" aria-expanded="false">
                        2022
                        <img src="assets/img/icons/dropdown.svg" alt="img" class="ms-2">
                      </button>
                      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <li>
                          <a href="javascript:void(0);" class="dropdown-item">
                            2022
                          </a>
                        </li>
                        <li>
                          <a href="javascript:void(0);" class="dropdown-item">
                            2021
                          </a>
                        </li>
                        <li>
                          <a href="javascript:void(0);" class="dropdown-item">
                            2020
                          </a>
                        </li>
                      </ul>
                    </div>
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
                                data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
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
                        <a href="productlist.html" class="dropdown-item">
                          Product List
                        </a>
                      </li>
                      <li>
                        <a href="addproduct.html" class="dropdown-item">
                          Product Add
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
                // Assuming you have established a database connection already
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "furniture";

                // Create connection
                $connection = mysqli_connect($servername, $username, $password, $database);

                // Check connection
                if (!$connection) {
                    die("Connection failed: " . mysqli_connect_error());
                }


                      // Query to fetch top 3 products with highest quantity from the database
                      $query = "SELECT product_image, product_name, quantity, price FROM products ORDER BY quantity DESC LIMIT 2";
                      $result = mysqli_query($connection, $query);

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

          <div class="card mb-0">
    <div class="card-body">
        <h4 class="card-title">Recent Orders</h4>

        <div class="table-responsive dataview">
            <table class="table datatable">
                <thead>
                    <tr>
                        
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Amount Change</th>
                        <th>Date</th>
                        <th>ID</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    // Include your database connection configuration file
                    @include 'config.php';

                    // Fetch the latest 10 orders from the 'orders' table
                    $fetch_orders_query = mysqli_query($conn, "SELECT * FROM orders ORDER BY date DESC LIMIT 10");

                    // Check if there are any orders
                    if (mysqli_num_rows($fetch_orders_query) > 0) {
                        while ($order = mysqli_fetch_assoc($fetch_orders_query)) {
                            echo "<tr>";
                            
                            echo "<td>" . $order['product_name'] . "</td>";
                            echo "<td>₱" . number_format($order['price'], 2) . "</td>";
                            echo "<td>" . $order['quantity'] . "</td>";
                            echo "<td>₱" . number_format($order['amount_change'], 2) . "</td>";
                            echo "<td>" . $order['date'] . "</td>";
                            echo "<td>" . $order['id'] . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No orders found</td></tr>";
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

    <script src="assets/js/jquery-3.6.0.min.js">
    </script>
    <script src="assets/js/feather.min.js">
    </script>
    <script src="assets/js/jquery.slimscroll.min.js">
    </script>
    <script src="assets/js/jquery.dataTables.min.js">
    </script>
    <script src="assets/js/dataTables.bootstrap4.min.js">
    </script>
    <script src="assets/js/bootstrap.bundle.min.js">
    </script>
    <script src="assets/plugins/apexchart/apexcharts.min.js">
    </script>
    <script src="assets/plugins/apexchart/chart-data.js">
    </script>
    <script src="assets/js/script.js">
    </script>
  </body>

</html>
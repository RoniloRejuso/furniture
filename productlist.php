<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, invoice, html5, responsive, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>
      Our Home
    </title>
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
  <?php
     
     include 'header.php'; // This will include the content of header.php
            ?>
  
      <div class="page-wrapper">
        <div class="content">
          <div class="page-header">
            <div class="page-title">
              <h4>
                Product List
              </h4>
              <h6>
                Manage your products
              </h6>
            </div>
            <div class="page-btn">
              <a href="addproduct.php" class="btn btn-added">
                <img src="assets/img/icons/plus.svg" alt="img" class="me-1">
                Add New Product
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
                      <a data-bs-toggle="tooltip" data-bs-placement="top" title="pdf">
                        <img src="assets/img/icons/pdf.svg" alt="img">
                      </a>
                    </li>
                    <li>
                      <a data-bs-toggle="tooltip" data-bs-placement="top" title="excel">
                        <img src="assets/img/icons/excel.svg" alt="img">
                      </a>
                    </li>
                    <li>
                      <a data-bs-toggle="tooltip" data-bs-placement="top" title="print">
                        <img src="assets/img/icons/printer.svg" alt="img">
                      </a>
                    </li>
                  </ul>
                </div>
              </div>

              <div class="card mb-0" id="filter_inputs">
                <div class="card-body pb-0">
                  <div class="row">
                    <div class="col-lg-12 col-sm-12">
                      <div class="row">
                        <div class="col-lg col-sm-6 col-12">
                          <div class="form-group">
                            <select class="select">
                              <option>
                                Choose Product
                              </option>
                              <option>
                                Macbook pro
                              </option>
                              <option>
                                Orange
                              </option>
                            </select>
                          </div>
                        </div>

                        <div class="col-lg col-sm-6 col-12">
                          <div class="form-group">
                            <select class="select">
                              <option>
                                Choose Category
                              </option>
                              <option>
                                Computers
                              </option>
                              <option>
                                Fruits
                              </option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg col-sm-6 col-12">
                          <div class="form-group">
                            <select class="select">
                              <option>
                                Choose Sub Category
                              </option>
                              <option>
                                Computer
                              </option>
                            </select>
                          </div>
                        </div>

                        <div class="col-lg col-sm-6 col-12">
                          <div class="form-group">
                            <select class="select">
                              <option>
                                Brand
                              </option>
                              <option>
                                N/D
                              </option>
                            </select>
                          </div>
                        </div>

                        <div class="col-lg col-sm-6 col-12 ">
                          <div class="form-group">
                            <select class="select">
                              <option>
                                Price
                              </option>
                              <option>
                                150.00
                              </option>
                            </select>
                          </div>
                        </div>

                        <div class="col-lg-1 col-sm-6 col-12">
                          <div class="form-group">
                            <a class="btn btn-filters ms-auto">
                              <img src="assets/img/icons/search-whites.svg" alt="img">
                            </a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="table-responsive">
                <table class="table  datanew">
                  <thead>
                    <tr>
                      <th>
                        <label class="checkboxs">
                          <input type="checkbox" id="select-all">
                          <span class="checkmarks">
                          </span>
                        </label>
                      </th>
                      <th>
                        Product ID
                      </th>
                      <th>
                        Product Name
                      </th>
                      <th>
                        Status
                      </th>
                      <th>
                        Price
                      </th>
                      <th>
                        Quantity
                      </th>
                      <th>
                       Image
                      </th>

                      <th>
                        Action
                      </th>
                    </tr>
                  </thead>



                  <tbody>
                  <?php
      // Database configuration
      $dbHost = 'localhost';
      $dbUsername = 'root';
      $dbPassword = '';
      $dbName = 'furniture';

      // Establish database connection
      $conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

      // Check connection
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }

      // Fetch data from the database
      $sql = "SELECT * FROM products";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          // Output data of each row
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
                      <a href="edit_product.php?id=' . $row["product_id"] . '">Edit</a>
                      <a href="delete_product.php?id=' . $row["product_id"] . '">Delete</a>
                    </td>';
              echo '</tr>';
          }
      } else {
          echo "<tr><td colspan='8'>0 results</td></tr>";
      }

      // Close database connection
      $conn->close();
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
    <script src="assets/plugins/select2/js/select2.min.js">
    </script>
    <script src="assets/plugins/sweetalert/sweetalert2.all.min.js">
    </script>
    <script src="assets/plugins/sweetalert/sweetalerts.min.js">
    </script>
    <script src="assets/js/script.js">
    </script>
  </body>

</html>
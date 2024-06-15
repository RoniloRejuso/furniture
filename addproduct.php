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
  <?php include 'header.php';?>
      <div class="page-wrapper">
        <div class="content">
          <div class="page-header">
            <div class="page-title">
              <h4>Product Add New</h4>
              <h6>Create new product</h6>
            </div>
          </div>
          <form action="add_prod.php" method="POST" enctype="multipart/form-data">
          <div class="card">
            <div class="card-body">
              <div class="row">
              <div class="col-lg-3 col-sm-6 col-12">
                <div class="form-group">
                  <label for="productName">Product Name</label>
                  <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name" maxlength="100">
                </div>
              </div>
                <script>
                  document.getElementById('productName').addEventListener('input', function() {
                    var userInput = this.value.toLowerCase();
                    if (userInput.includes('sofa')) {
                      this.value = 'Our Home ' + userInput;
                    }
                  });
                </script>             

                                  <div class="col-lg-3 col-sm-6 col-12">
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select class="select" id="status" name="status">
                      
                      <option >Available</option>
                      <option >Not available</option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" name="price" placeholder="Enter price" onkeypress="return isNumberKey(event)" maxlength="9">
                        <small id="priceHelpBlock" class="form-text text-muted"></small>
                    </div>
                </div>
                  <script>
                      function isNumberKey(evt) {
                          var charCode = (evt.which) ? evt.which : event.keyCode;
                          if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                              return false;
                          }
                          return true;
                      }
                  </script>
                  <div class="col-lg-3 col-sm-6 col-12">
                      <div class="form-group">
                          <label for="quantity">Quantity</label>
                          <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" onkeypress="return isNumberKey(event)" maxlength="9">
                          <small id="quantityHelpBlock" class="form-text text-muted"></small>
                      </div>
                  </div>

                  <script>
                      function isNumberKey(evt) {
                          var charCode = (evt.which) ? evt.which : event.keyCode;
                          if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
                              return false;
                          }
                          return true;
                      }
                  </script>
                  <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="select" id="category" name="category">
                            <option value="living_room">Living Room</option>
                            <option value="dining_room">Dining Room</option>
                            <option value="bedroom">Bedroom</option>
                            <option value="home_office">Home Office</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                        <label for="color">Color</label>
                        <input type="text" class="form-control" id="color" name="color" placeholder="Enter color" maxlength="50" onkeypress="return onlyAlphabetic(event)">
                        <small id="colorHelpBlock" class="form-text text-muted"></small>
                    </div>
                </div>
                <script>
                    function onlyAlphabetic(evt) {
                        var charCode = (evt.which) ? evt.which : event.keyCode;
                        if ((charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122)) {
                            return false;
                        }
                        return true;
                    }
                </script>
                  <div class="col-lg-3 col-sm-6 col-12">
                      <div class="form-group">
                          <label for="size">Size</label>
                          <input type="text" class="form-control" id="size" name="size" placeholder="Enter size" maxlength="50">
                      </div>
                  </div>
                  <div class="col-lg-3 col-sm-6 col-12">
                      <div class="form-group">
                          <label for="weight_capacity">Weight Capacity</label>
                          <input type="text" class="form-control" id="weight_capacity" name="weight_capacity" placeholder="Enter weight capacity" maxlength="50"> 
                      </div>
                  </div>
                  <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="product-image">Product Image</label>
                      <input type="file" id="product-image" name="product-image" style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px;">
                    </div>
                  </div>  
                  <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="glb-file">Product Model</label>
                      <input type="file" id="glb-file" name="glb-file" style="border: 1px solid #ced4da; border-radius: 4px; padding: 6px 12px;">
                    </div>
                  </div>

                  <div class="col-lg-3 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="description">Product Description</label>
                      <textarea class="form-control" id="description" name="description" placeholder="Enter product description" rows="4"></textarea>
                    </div>
                  </div>        
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-submit me-2" name="submit">Submit</button>
                    <a href="productlist.html" class="btn btn-cancel">Cancel</a>
                  </div>
                </form>
              </div>
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

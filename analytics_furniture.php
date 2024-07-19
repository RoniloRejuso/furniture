<!DOCTYPE html>
<html lang="en">
  
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>
      Our Home
    </title>
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
     
     include 'header.php'; // This will include the content of header.php
          
     ?>


      <div class="page-wrapper">
        <div class="content">
          <div class="row">
            <div class="col-lg-4 col-sm-6 col-12">
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

            <div class="col-lg-4 col-sm-6 col-12">
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
                      $4,385.00
                    </span>
                  </h5>

                </div>
              </div>
            </div>

            <div class="col-lg-4 col-sm-6 col-12">
              <div class="dash-widget dash2">
                <div class="dash-widgetimg">
                  <span>
                    <img src="assets/img/icons/dash3.svg" alt="img">
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
                  <div id="s-line">
                  </div>
                </div>
              </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var sLineElement = document.getElementById("s-line");
        if (sLineElement !== null) {
            var sline = {
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'straight'
                },
                series: [{
                    name: "Desktops",
                    data: [10, 41, 35, 51, 49, 62, 69, 91, 148]
                }],
                title: {
                    text: 'Product Trends by Month',
                    align: 'left'
                },
                grid: {
                    row: {
                        colors: ['#f1f2f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep'],
                }
            }
            var chart = new ApexCharts(sLineElement, sline);
            chart.render();
        }
    });
</script>

<div class="col-lg-5 col-sm-12 col-12 d-flex">
              <div class="card flex-fill">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                  <h4 class="card-title mb-0">
                    Recently Added Products
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
                    <table class="table datatable ">
                      <thead>
                        <tr>
                          <th>
                            Sno
                          </th>
                          <th>
                            Products
                          </th>
                          <th>
                            Price
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            1
                          </td>
                          <td class="productimgname">
                            <a href="productlist.html" class="product-img">
                              <img src="assets/img/product/product22.jpg" alt="product">
                            </a>
                            <a href="productlist.html">
                              Apple Earpods
                            </a>
                          </td>
                          <td>
                            $891.2
                          </td>
                        </tr>
                        <tr>
                          <td>
                            2
                          </td>
                          <td class="productimgname">
                            <a href="productlist.html" class="product-img">
                              <img src="assets/img/product/product23.jpg" alt="product">
                            </a>
                            <a href="productlist.html">
                              iPhone 11
                            </a>
                          </td>
                          <td>
                            $668.51
                          </td>
                        </tr>
                        <tr>
                          <td>
                            3
                          </td>
                          <td class="productimgname">
                            <a href="productlist.html" class="product-img">
                              <img src="assets/img/product/product24.jpg" alt="product">
                            </a>
                            <a href="productlist.html">
                              samsung
                            </a>
                          </td>
                          <td>
                            $522.29
                          </td>
                        </tr>
                        <tr>
                          <td>
                            4
                          </td>
                          <td class="productimgname">
                            <a href="productlist.html" class="product-img">
                              <img src="assets/img/product/product6.jpg" alt="product">
                            </a>
                            <a href="productlist.html">
                              Macbook Pro
                            </a>
                          </td>
                          <td>
                            $291.01
                          </td>
                        </tr>
                      </tbody>
                    </table>
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
                  <div id="s-line-area">
                  </div>
                </div>
              </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (document.getElementById('s-line-area')) {
      var sLineArea = {
        chart: {
          height: 350,
          type: 'area',
          toolbar: {
            show: false
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          curve: 'smooth'
        },
        series: [{
            name: 'series1',
            data: [31, 40, 28, 51, 42, 109, 100]
          },
          {
            name: 'series2',
            data: [11, 32, 45, 32, 34, 52, 41]
          }
        ],
        xaxis: {
          type: 'datetime',
          categories: ["2018-09-19T00:00:00", "2018-09-19T01:30:00", "2018-09-19T02:30:00", "2018-09-19T03:30:00", "2018-09-19T04:30:00", "2018-09-19T05:30:00", "2018-09-19T06:30:00"]
        },
        tooltip: {
          x: {
            format: 'dd/MM/yy HH:mm'
          }
        }
      };

      var chart = new ApexCharts(document.getElementById('s-line-area'), sLineArea);
      chart.render();
    }
  });
</script>

<div class="col-lg-5 col-sm-12 col-12 d-flex">
              <div class="card flex-fill">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                  <h4 class="card-title mb-0">
                    Recently Added Products
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
                    <table class="table datatable ">
                      <thead>
                        <tr>
                          <th>
                            Sno
                          </th>
                          <th>
                            Products
                          </th>
                          <th>
                            Price
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            1
                          </td>
                          <td class="productimgname">
                            <a href="productlist.html" class="product-img">
                              <img src="assets/img/product/product22.jpg" alt="product">
                            </a>
                            <a href="productlist.html">
                              Apple Earpods
                            </a>
                          </td>
                          <td>
                            $891.2
                          </td>
                        </tr>
                        <tr>
                          <td>
                            2
                          </td>
                          <td class="productimgname">
                            <a href="productlist.html" class="product-img">
                              <img src="assets/img/product/product23.jpg" alt="product">
                            </a>
                            <a href="productlist.html">
                              iPhone 11
                            </a>
                          </td>
                          <td>
                            $668.51
                          </td>
                        </tr>
                        <tr>
                          <td>
                            3
                          </td>
                          <td class="productimgname">
                            <a href="productlist.html" class="product-img">
                              <img src="assets/img/product/product24.jpg" alt="product">
                            </a>
                            <a href="productlist.html">
                              samsung
                            </a>
                          </td>
                          <td>
                            $522.29
                          </td>
                        </tr>
                        <tr>
                          <td>
                            4
                          </td>
                          <td class="productimgname">
                            <a href="productlist.html" class="product-img">
                              <img src="assets/img/product/product6.jpg" alt="product">
                            </a>
                            <a href="productlist.html">
                              Macbook Pro
                            </a>
                          </td>
                          <td>
                            $291.01
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="card mb-0">
            <div class="card-body">
              <h4 class="card-title">
                Expired Products
              </h4>
              <div class="table-responsive dataview">
                <table class="table datatable ">
                  <thead>
                    <tr>
                      <th>
                        SNo
                      </th>
                      <th>
                        Product Code
                      </th>
                      <th>
                        Product Name
                      </th>
                      <th>
                        Brand Name
                      </th>
                      <th>
                        Category Name
                      </th>
                      <th>
                        Expiry Date
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        1
                      </td>
                      <td>
                        <a href="javascript:void(0);">
                          IT0001
                        </a>
                      </td>
                      <td class="productimgname">
                        <a class="product-img" href="productlist.html">
                          <img src="assets/img/product/product2.jpg" alt="product">
                        </a>
                        <a href="productlist.html">
                          Orange
                        </a>
                      </td>
                      <td>
                        N/D
                      </td>
                      <td>
                        Fruits
                      </td>
                      <td>
                        12-12-2022
                      </td>
                    </tr>
                    <tr>
                      <td>
                        2
                      </td>
                      <td>
                        <a href="javascript:void(0);">
                          IT0002
                        </a>
                      </td>
                      <td class="productimgname">
                        <a class="product-img" href="productlist.html">
                          <img src="assets/img/product/product3.jpg" alt="product">
                        </a>
                        <a href="productlist.html">
                          Pineapple
                        </a>
                      </td>
                      <td>
                        N/D
                      </td>
                      <td>
                        Fruits
                      </td>
                      <td>
                        25-11-2022
                      </td>
                    </tr>
                    <tr>
                      <td>
                        3
                      </td>
                      <td>
                        <a href="javascript:void(0);">
                          IT0003
                        </a>
                      </td>
                      <td class="productimgname">
                        <a class="product-img" href="productlist.html">
                          <img src="assets/img/product/product4.jpg" alt="product">
                        </a>
                        <a href="productlist.html">
                          Stawberry
                        </a>
                      </td>
                      <td>
                        N/D
                      </td>
                      <td>
                        Fruits
                      </td>
                      <td>
                        19-11-2022
                      </td>
                    </tr>
                    <tr>
                      <td>
                        4
                      </td>
                      <td>
                        <a href="javascript:void(0);">
                          IT0004
                        </a>
                      </td>
                      <td class="productimgname">
                        <a class="product-img" href="productlist.html">
                          <img src="assets/img/product/product5.jpg" alt="product">
                        </a>
                        <a href="productlist.html">
                          Avocat
                        </a>
                      </td>
                      <td>
                        N/D
                      </td>
                      <td>
                        Fruits
                      </td>
                      <td>
                        20-11-2022
                      </td>
                    </tr>
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
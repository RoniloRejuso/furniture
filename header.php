  <?php   	
  session_start();
  ?>
    <div id="global-loader">
      <div class="whirly-loader">
      </div>
    </div>
    <div class="main-wrapper">
      <div class="header">
        <div class="header-left active">
          <a href="index.php" class="logo">
            <img src="assets/img/our home.png" alt="">
          </a>
          <a href="index.php" class="logo-small">
            <img src="assets/img/logo-small.png" alt="">
          </a>
          <a id="toggle_btn" href="javascript:void(0);">
          </a>
        </div>
        <a id="mobile_btn" class="mobile_btn" href="#sidebar">
          <span class="bar-icon">
            <span>
            </span>
            <span>
            </span>
            <span>
            </span>
          </span>
        </a>
        <ul class="nav user-menu">
          <li class="nav-item">
            <div class="top-nav-search">
              <a href="javascript:void(0);" class="responsive-search">
                <i class="fa fa-search">
                </i>
              </a>
            </div>
          </li>


          <li class="nav-item dropdown">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
              <img src="assets/img/icons/notification-bing.svg" alt="img">
              <span class="badge rounded-pill">
                4
              </span>
            </a>
            <div class="dropdown-menu notifications">
              <div class="topnav-dropdown-header">
                <span class="notification-title">
                  Notifications
                </span>
                <a href="javascript:void(0)" class="clear-noti">
                  Clear All
                </a>
              </div>
              <div class="noti-content">
                <ul class="notification-list">
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <img alt="" src="assets/img/profiles/avatar-02.jpg">
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details">
                            <span class="noti-title">
                              John Doe
                            </span>
                            added new task
                            <span class="noti-title">
                              Patient appointment booking
                            </span>
                          </p>
                          <p class="noti-time">
                            <span class="notification-time">
                              4 mins ago
                            </span>
                          </p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <img alt="" src="assets/img/profiles/avatar-03.jpg">
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details">
                            <span class="noti-title">
                              Tarah Shropshire
                            </span>
                            changed the task name
                            <span class="noti-title">
                              Appointment booking with payment gateway
                            </span>
                          </p>
                          <p class="noti-time">
                            <span class="notification-time">
                              6 mins ago
                            </span>
                          </p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <img alt="" src="assets/img/profiles/avatar-06.jpg">
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details">
                            <span class="noti-title">
                              Misty Tison
                            </span>
                            added
                            <span class="noti-title">
                              Domenic Houston
                            </span>
                            and
                            <span class="noti-title">
                              Claire Mapes
                            </span>
                            to project
                            <span class="noti-title">
                              Doctor available module
                            </span>
                          </p>
                          <p class="noti-time">
                            <span class="notification-time">
                              8 mins ago
                            </span>
                          </p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <img alt="" src="assets/img/profiles/avatar-17.jpg">
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details">
                            <span class="noti-title">
                              Rolland Webber
                            </span>
                            completed task
                            <span class="noti-title">
                              Patient and Doctor video conferencing
                            </span>
                          </p>
                          <p class="noti-time">
                            <span class="notification-time">
                              12 mins ago
                            </span>
                          </p>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li class="notification-message">
                    <a href="activities.html">
                      <div class="media d-flex">
                        <span class="avatar flex-shrink-0">
                          <img alt="" src="assets/img/profiles/avatar-13.jpg">
                        </span>
                        <div class="media-body flex-grow-1">
                          <p class="noti-details">
                            <span class="noti-title">
                              Bernardo Galaviz
                            </span>
                            added new task
                            <span class="noti-title">
                              Private chat module
                            </span>
                          </p>
                          <p class="noti-time">
                            <span class="notification-time">
                              2 days ago
                            </span>
                          </p>
                        </div>
                      </div>
                    </a>
                  </li>
                </ul>
              </div>
              <div class="topnav-dropdown-footer">
                <a href="activities.html">
                  View all Notifications
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset"
            data-bs-toggle="dropdown">
              <span class="user-img">
                <img src="assets/img/ourhome.jpg" alt="">
                <span class="status online">
                </span>
              </span>
            </a>

            <div class="dropdown-menu menu-drop-user">
              <div class="profilename">
                <div class="profileset">
                  <span class="user-img">
                    <img src="assets/img/profiles/ourhome.jpg" alt="">
                   
                  </span>

                  <div class="profilesets">
                    <h6 style="color:black">
                      Our Home
                    </h6>
                    <h5 style="color:black">
                      ADMIN
                    </h5>
                  </div>
                </div>
                <hr class="m-0">

                <hr class="m-0">
                <a class="dropdown-item logout pb-0" href="logout.php" onclick="disableBack()">
    <img src="assets/img/icons/log-out.svg" class="me-2" alt="img">
    Logout
</a>

              </div>
            </div>
          </li>
        </ul>
        <div class="dropdown mobile-user-menu">
          <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
          aria-expanded="false">
            <i class="fa fa-ellipsis-v">
            </i>
          </a>

            <a class="dropdown-item" href="login.php">
              Logout
            </a>
          </div>
        </div>
      </div>
     
      <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
          <div id="sidebar-menu" class="sidebar-menu">
            <ul>
              <li class="active">
                <a href="index.php">
                  <img src="assets/img/icons/dashboard.svg" alt="img">
                  <span>
                    Dashboard
                  </span>
                </a>
              </li>
              
              <li class="submenu">
                <a href="javascript:void(0);">
                  <img src="assets/img/icons/product.svg" alt="img">
                  <span>
                    Tracking
                  </span>
                  <span class="menu-arrow">
                  </span>
                </a>
                <ul>
                  <li>
                    <a href="productlist.php">
                      Product List
                    </a>
                  </li>
                  <li>
                    <a href="addproduct.php">
                      Add Product
                    </a>
                  </li>
                </ul>
              </li>


              
              <li class="submenu">
                <a href="javascript:void(0);">
                  <img src="assets/img/icons/purchase1.svg" alt="img">
                  <span>
                    Orders
                  </span>
                  <span class="menu-arrow">
                  </span>
                </a>
                <ul>
                  <li>
                    <a href="orders.php">
                      Orders
                    </a>
                  </li>
                </ul>
              </li>

              


                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "furniture");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$session_id = isset($_SESSION['session_id']) ? $_SESSION['session_id'] : null;
$row = null;

if ($session_id) {
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE admin_id='$session_id'") or die(mysqli_error($conn));
    if (mysqli_num_rows($query) > 0) {
        $row = mysqli_fetch_array($query);
    }
}

$queryTotalPendingNotifications = "SELECT COUNT(*) AS TotalNotification FROM orders";
$resultTotalPendingNotifications = mysqli_query($conn, $queryTotalPendingNotifications);
$totalPendingNotificationRow = $resultTotalPendingNotifications ? mysqli_fetch_assoc($resultTotalPendingNotifications) : null;
?>


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
              <span class="badge rounded-pill"><?php echo $totalPendingNotificationRow['Total Notification'];?></span>
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
              </div>
              <div class="topnav-dropdown-footer">
                <a href="orders.php">
                  View all Notifications.
                </a>
              </div>
            </div>
          </li>
          <li class="nav-item dropdown has-arrow main-drop">
            <a href="javascript:void(0);" class="dropdown-toggle nav-link userset"
            data-bs-toggle="dropdown">
              <span class="user-img">
                <img src="assets/img/profiles/avator1.jpg" alt="">
                <span class="status online">
                </span>
              </span>
            </a>

            <div class="dropdown-menu menu-drop-user">
    <div class="profilename">
        <div class="profileset">
            <span class="user-img">
                <img src="assets/img/profiles/avator1.jpg" alt="">
                <span class="status online"></span>
            </span>
            <div class="profilesets">
            <?php if ($row): ?>
                <h6><?php echo htmlspecialchars($row['username']); ?></h6>
                <h5>Admin</h5>
            <?php else: ?>
                <h6>Unknown User</h6>
                <h5>Unknown Role</h5>
            <?php endif; ?>
            </div>
        </div>
        <hr class="m-0">
        <a class="dropdown-item logout pb-0" href="logout.php">
            <img src="assets/img/icons/log-out.svg" class="me-2" alt="img">Logout
        </a>
    </div>
</div>


        <div class="dropdown mobile-user-menu">
          <a href="javascript:void(0);" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"
          aria-expanded="false">
            <i class="fa fa-ellipsis-v">
            </i>
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <a class="dropdown-item" href="profile.html">My Profile</a>
            <a class="dropdown-item" href="generalsettings.html">Settings</a>
            <a class="dropdown-item" href="login.php">Logout</a>
          </div>
        </div>
      </div>
      <div class="sidebar" id="sidebar">
        <div class="sidebar-inner slimscroll">
          <div id="sidebar-menu" class="sidebar-menu">
            <ul>
            <li>
              <a href="index.php">
                <img src="assets/img/icons/dashboard.svg" alt="img"><span>Dashboard</span>
              </a>
            </li>

              <li class="submenu">
                <a href="javascript:void(0);">
                  <img src="assets/img/icons/product.svg" alt="img"><span>Tracking</span>
                  <span class="menu-arrow">
                  </span>
                </a>
                <ul>
                  <li>
                    <a href="productlist.php">Product List</a>
                  </li>
                  <li>
                    <a href="addproduct.php">Add Product</a>
                  </li>
                </ul>
              </li>
              <li class="submenu">
                <a href="javascript:void(0);">
                  <img src="assets/img/icons/purchase1.svg" alt="img">
                  <span>Orders</span>
                  <span class="menu-arrow"></span>
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
            
          </div>
        </div>
      </div>
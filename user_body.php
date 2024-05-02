<div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-light bg-light justify-content-between">
               <div id="mySidenav" class="sidenav">
                  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                  <a href="user_new_products.php">New Products</a>
                  <a href="user_products_sale.php">Products on Sale</a>
                  <div class="dropdown">
                      <a href="#" class="dropdown-toggle" id="furnitureDropdown" onclick="toggleDropdown()" aria-haspopup="true" aria-expanded="false">
                          Furniture
                      </a>
                      <div class="dropdown-menu" id="furnitureMenu" aria-labelledby="furnitureDropdown">
                          <a class="dropdown-item" href="user_livingroom.php">Living Room</a>
                          <a class="dropdown-item" href="user_diningroom.php">Dining Room</a>
                          <a class="dropdown-item" href="user_bedroom.php">Bedroom</a>
                          <a class="dropdown-item" href="user_office.php">Home Office</a>
                          <a class="dropdown-item" href="user_product.php">All products</a>
                      </div>
                  </div>
                  <div class="login-signup">
                     <a href="user_login.php">Log in</a> | <a href="user_login.php">Sign up</a>
                  </div>
               </div>                          
               <span class="toggle_icon" onclick="openNav()"><img src="images/toggle-icon.png"></span>
               <a class="logo" href="user_index.php"><img src="images/logo.png" width="150px" height="50px"></a>
               <form class="form-inline ">
                     <div class="login_text">
                     </div>
               </form>
            </nav>
         </div>
      </div>

<div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-light bg-light justify-content-between">
               <div id="mySidenav" class="sidenav"><br><br><br>
                  <span href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</span>
                  <a class="user_products" href="user_new_products.php">New Products</a>
                  <div class="dropdown">
                      <a href="#" class="dropdown-toggle" id="furnitureDropdown" onclick="toggleDropdown()" aria-haspopup="true" aria-expanded="false">
                          Furniture
                      </a>
                      <div class="dropdown-menu" id="furnitureMenu" aria-labelledby="furnitureDropdown">
                          <a class="dropdown-item" href="user_livingroom.php">Living Room</a>
                          <a class="dropdown-item" href="user_diningroom.php">Dining Room</a>
                          <a class="dropdown-item" href="user_bedroom.php">Bedroom</a>
                          <a class="dropdown-item" href="user_office.php">Office</a>
                          <a class="dropdown-item" href="user_product.php">All products</a>
                      </div>
                  </div>
               </div>                          
               <span class="toggle_icon" onclick="openNav()"><img src="images/toggle-icon.png"></span>
               <a class="logo" href="user_home.php"><img src="images/logo.png" width="150px" height="50px"></a>
               <form class="form-inline ">
                     <div class="login_text">
                     </div>
               </form>
            </nav>
         </div>
      </div>
      <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "320px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function toggleDropdown() {
            var dropdownMenu = document.getElementById("furnitureMenu");
            if (dropdownMenu.style.display === "block") {
                dropdownMenu.style.display = "none";
            } else {
                dropdownMenu.style.display = "block";
            }
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }
    </script>

<style>
    .sidenav a{
        text-align:left;
    }
</style>
<div class="header_section">
         <div class="container-fluid">
            <nav class="navbar navbar-light bg-light justify-content-between">
               <div id="mySidenav" class="sidenav"><br><br><br>
               <span href="javascript:void(0)" class="closebtn" onclick="closeNav()" style="margin: 0 auto;">&times;</span>
                  <a class="user_products" href="user_new_products1.php">
                    <i style="margin-left:70px;" class="fas fa-box-open"></i>  New Products
                  </a>
                  <div class="dropdown">
                      <a href="#" class="dropdown-toggle" id="furnitureDropdown" onclick="toggleDropdown()" aria-haspopup="true" aria-expanded="false">
                        <i style="margin-left:80px;" class="fas fa-chair"></i>  Furniture
                      </a>
                      <div class="dropdown-menu" id="furnitureMenu" aria-labelledby="furnitureDropdown">
                        <a class="dropdown-item" href="user_livingroom1.php">
                            <i style="margin-left:70px;" class="fas fa-couch"></i>  Living Room
                        </a>
                        <a class="dropdown-item" href="user_diningroom1.php">
                            <i style="margin-left:70px;" class="fas fa-utensils"></i>  Dining Room
                        </a>
                        <a class="dropdown-item" href="user_bedroom1.php">
                            <i style="margin-left:70px;" class="fas fa-bed"></i>  Bedroom
                        </a>
                        <a class="dropdown-item" href="user_office1.php">
                            <i style="margin-left:70px;" class="fas fa-briefcase"></i>  Office
                        </a>
                        <a class="dropdown-item" href="user_prod.php">
                            <i style="margin-left:70px;" class="fas fa-th-list"></i>  All products
                        </a>
                    </div>
                  </div>
               </div>                           
               <span class="toggle_icon" onclick="openNav()"><img src="images/toggle-icon.png"></span>
               <a class="logo" href="index.php"><img src="images/logo.png" width="170px" height="50px"></a>
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
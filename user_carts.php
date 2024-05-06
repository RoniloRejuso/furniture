<?php

@include 'config.php';

if (isset($_POST['update_update_btn'])) {
    $update_value = mysqli_real_escape_string($conn, $_POST['update_quantity']);
    $update_id = mysqli_real_escape_string($conn, $_POST['update_quantity_id']);

    // Check if the new quantity is valid (greater than or equal to 0)
    if ($update_value >= 0) {
        $update_quantity_query = mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_value' WHERE id = '$update_id'");

        if ($update_quantity_query) {
            header('location: user_carta.php');
        } else {
            die('Failed to update cart quantity: ' . mysqli_error($conn));
        }
    } else {
        die('Invalid quantity value');
    }
}


if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'");
   header('location:user_carts.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart`");
   header('location:user_carts.php');
}

?>


<!DOCTYPE html>
<html lang="en">
   <head>
<?php
include 'user_header.php';
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<!-- custom css file link  -->
<link rel="stylesheet" href="cs/style.css">
  
 </head>
   <body>
   <?php
include 'user_body.php';
?>

</head>

<div class="product_section layout_padding">
   <div class="container">
      <div class="row">
         <div class="col-sm-12">
            <h1 class="product_taital">Our Products</h1>

         </div>
      </div>
      <div class="product_section_2 layout_padding">
         <div class="row">
</head>
<body>
   
<?php

if(isset($message)){
   foreach($message as $message){
      echo '<div class="message"><span>'.$message.'</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   };
};

?>

<div class="container">

<section class="shopping-cart">

   <h1 class="heading">shopping cart</h1>

   <table>
    <thead>
        <th>Product Name</th>
        <th>Image</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total Price</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
        $grand_total = 0;

        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                ?>
                <tr>
                    <td><?php echo $fetch_cart['product_name']; ?></td>

                    <td><img src="<?php echo $fetch_cart['product_image']; ?>" alt="Product Image"></td>


                    <td>$<?php echo number_format($fetch_cart['price'], 2); ?>/-</td>
                    <td>
                        <form action="" method="post">
                            <input type="hidden" name="update_quantity_id" value="<?php echo $fetch_cart['id']; ?>">
                            <input type="number" name="update_quantity" pattern="\d*" oninput="this.value = this.value.replace(/[^0-9]/g, '').substring(0, 9)" value="<?php echo $fetch_cart['quantity']; ?>">
                            <input type="submit" value="Update" name="update_update_btn">
                        </form>
                    </td>
                    <td>$<?php echo number_format($sub_total = $fetch_cart['price'] * $fetch_cart['quantity'], 2); ?>/-</td>
                    <td><a href="user_carts.php?remove=<?php echo $fetch_cart['id']; ?>" onclick="return confirm('Remove item from cart?')" class="delete-btn"> <i class="fas fa-trash"></i> Remove</a></td>
                </tr>
                <?php
                $grand_total += $sub_total;
            }
        } else {
            echo "<tr><td colspan='6'>No items in cart</td></tr>";
        }
        ?>

      
         <tr class="table-bottom">
            <td><a href="products.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td colspan="3">grand total</td>
            <td>$<?php echo $grand_total; ?>/-</td>
            <td><a href="cart.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
    <a href="user_checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" <?php echo ($grand_total <= 1) ? 'enabled' : ''; ?>>Proceed to checkout</a>
</div>

</section>

</div>



<script src="js/script.js"></script>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.bundle.min.js"></script>
      <script src="js/jquery-3.0.0.min.js"></script>
      <script src="js/plugin.js"></script>
      <!-- sidebar -->
      <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="js/custom.js"></script>
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>  
      <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>
      <script>
         function openNav() {
           document.getElementById("mySidenav").style.width = "100%";
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
      <script src="java/script.js"></script>
   </body>
</html>
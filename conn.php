<?php
include('config.php'); // Include your database connection file

if (isset($_POST['checkout']) && $_POST['checkout'] == 1) {
   // Process checkout

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");

   if (mysqli_num_rows($select_cart) > 0) {
      while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
         $new_quantity = $fetch_cart['quantity'] - 1; // Decrease quantity by 1

         // Update the quantity in the database
         mysqli_query($conn, "UPDATE `cart` SET `quantity` = $new_quantity WHERE `id` = {$fetch_cart['id']}");
      }
   }

   
   header('Location: thank_you.php');
   exit();
}
?>

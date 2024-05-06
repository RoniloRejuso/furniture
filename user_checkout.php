<?php
@include 'config.php';

if (isset($_POST['order_btn'])) {
    
    $amountPaid = $_POST['amount'];
    $change = $_POST['amount_change'];

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
    $price_total = 0;

    // Initialize product details array
    $product_details = array();

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            // Add product details to the array
            $product_details[] = array(
                'name' => $product_item['product_name'], // Use product_name instead of brand and flavor
                'quantity' => $product_item['quantity'],
                'price' => $product_item['price'] * $product_item['quantity']
            );

            $price_total += $product_item['price'] * $product_item['quantity'];


            $product_name = mysqli_real_escape_string($conn, $product_item['product_name']);
            $quantity = (int)$product_item['quantity'];


            $check_product_query = mysqli_query($conn, "SELECT * FROM `products` WHERE `product_name` = '$product_name'");
            if (mysqli_num_rows($check_product_query) > 0) {
                // Update product quantity in the products table
                $reduce_quantity_query = mysqli_query($conn, "UPDATE `products` SET `quantity` = `quantity` - $quantity WHERE `product_name` = '$product_name'");

                if (!$reduce_quantity_query) {
                    die('Failed to update product quantity in the database: ' . mysqli_error($conn));
                }
            } else {
                die('Product not found in the products table: ' . $product_name);
            }
        }

        $receipt_details = '';
        foreach ($product_details as $product) {
            $receipt_details .= $product['name'] . ' x' . $product['quantity'] . ', '; // Display only 
        }

        $receipt_details = rtrim($receipt_details, ', ');

        // Insert order details into the order table
        // Insert order details into the order table
$detail_query = mysqli_query($conn, "INSERT INTO `orders` (product_name, quantity, price, amount, amount_change) VALUES ('$receipt_details', '$quantity', '$price_total', '$amountPaid', '$change')") or die('Failed to insert order details into the database: ' . mysqli_error($conn));


        if (!$detail_query) {
            die('Failed to insert order details into the database: ' . mysqli_error($conn));
        }
    }

    // Clear the cart after updating the products table
    mysqli_query($conn, "DELETE FROM `cart`");

    echo "
    <div class='order-message-container'>
        <div class='message-container'>
            <h3>Thank you for shopping!</h3>
            <div class='order-detail'>
                <span>" . $receipt_details . "</span>
                <span class='total'> Total: ₱" . $price_total . "  </span>
                <span class='amount-paid'> Amount Paid: ₱" . $amountPaid . " </span>
                <span class='change'> Change: ₱" . $change . " </span>
            </div>
            <a href='user_prod.php' class='btn'>Keep Shopping</a>
            <a href='user_login.php' class='btn'>Exit</a>
        </div>
    </div>
    ";
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

<section class="checkout-form">

   <h1 class="heading">complete your order</h1>

   <form action="" method="post">

   <div class="display-order">
   <div class="display-order">
   <?php
$select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
$total = 0;
$grand_total = 0;

if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
        $grand_total += $total_price;
        echo '<span>' . $fetch_cart['product_name'] . ' (' . $fetch_cart['quantity'] . ')</span>'; // Display product_name instead of brand
    }
} else {
    echo "<div class='display-order'><span>Your cart is empty!</span></div>";
}
?>
<span class="grand-total"> grand total : ₱<?= number_format($grand_total, 2); ?>/- </span>



      <div class="flex">






<div class="inputBox">
    <span>Amount Paid</span>
    <input type="text" pattern="\d*" oninput="calculateChange()" placeholder="e.g. 123456" name="amount" id="amount" required>
</div>

<div class="inputBox">
    <span>Change</span>
    <input type="text" readonly placeholder="Change" name="amount_change" id="amount_change">
</div>


      <input type="submit" value="Pay now" name="order_btn" class="btn">
   </form>

</section>

</div>


<script src="js/script.js"></script>
  
  <script>
    function calculateChange() {
        var amountPaid = parseInt(document.getElementById('amount').value);
        var grandTotal = <?= $grand_total ?>;
        
        if (!isNaN(amountPaid)) {
            var change = amountPaid - grandTotal;
            document.getElementById('amount_change').value = (change >= 0) ? change.toFixed(2) : '';
        } else {
            document.getElementById('amount_change').value = '';
        }
    }
</script>





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
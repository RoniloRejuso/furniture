<?php
@include 'config.php';

if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $price = $_POST['price']; 
    $product_quantity = 1;
    // Fetch product image from the form
    $product_image = $_POST['product_image'];

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE product_name = '$product_name'");

    if(mysqli_num_rows($select_cart) > 0){
        $message[] = 'Product already added to cart';
    }else{

        // Insert product details including product image into cart table
        $insert_product = mysqli_query($conn, "INSERT INTO `cart`(product_name, price, quantity, product_image) VALUES('$product_name', '$price', '$product_quantity', '$product_image')");
        
        if($insert_product){
            $message[] = 'Product added to cart successfully';
        } else {
            $message[] = 'Failed to add product to cart';
        }
    }
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

<section class="products">


<div class="box-container">

    <?php

    $select_products = mysqli_query($conn, "SELECT * FROM `products`");
    if(mysqli_num_rows($select_products) > 0){
        while($fetch_product = mysqli_fetch_assoc($select_products)){
    ?>

<form action="" method="post">
    <div class="box">
        <img src="<?php echo $fetch_product['product_image']; ?>" class="image_1" alt="Product Image">
        <h3><?php echo $fetch_product['product_name']; ?></h3>
        <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
        <input type="hidden" name="product_name" value="<?php echo $fetch_product['product_name']; ?>">
        <input type="hidden" name="price" value="<?php echo $fetch_product['price']; ?>">
        <!-- Add hidden input field for product image -->
        <input type="hidden" name="product_image" value="<?php echo $fetch_product['product_image']; ?>">
        <input type="submit" class="btn" value="add to cart" name="add_to_cart">
    </div>
</form>




    <?php
        };
    };
    ?>

</div>


</section>

</div>


<?php
include 'user_footer.php';
?>




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
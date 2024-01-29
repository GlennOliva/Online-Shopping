<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

   <?php
      $total_pages = 0;
      if($user_id == ''){
         echo '<p class="empty">please login to see your orders</p>';
      }else{
         //pagination settings
         $results_per_page = 10;
         $total_results = $conn->query("SELECT COUNT(*) as count FROM `orders` WHERE user_id = $user_id")->fetch()['count'];
         $total_pages = ceil($total_results/$results_per_page);

         //determine current page
         if (!isset($_GET['page'])) {
            $page = 1;
         } else {
            $page = $_GET['page'];
         }

         //calculate the starting result for the current page
         $start = ($page-1) * $results_per_page;

         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? LIMIT $start, $results_per_page");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
         
   ?>

   <div class="box">
      <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>name : <span><?= $fetch_orders['name']; ?></span></p>
      <p>email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>number : <span><?= $fetch_orders['number']; ?></span></p>
      <p>address : <span><?= $fetch_orders['address']; ?></span></p>
      <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
      <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>total price: <span>₱<?= number_format($fetch_orders['total_price'], 2, '.', ','); ?></span></p>
      <p> payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'Pending'){ echo 'black'; }
      elseif($fetch_orders['payment_status'] == 'Cancelled_Order'){ echo 'red'; }elseif($fetch_orders['payment_status'] == 'on_delivery'){echo 'orange';}else{echo 'green';} ?>"><?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }

   }

   ?>

   </div>

   <?php
   //display pagination
   if ($total_pages > 1) {
      echo '<div class="pagination">';
      echo '<ul>';
      if ($page > 1) {
         echo '<li><a href="orders.php?page='.($page-1).'">Prev</a></li>';
      }
      for ($i = 1; $i <= $total_pages; $i++) {
         if ($i == $page) {
            echo '<li><a href="orders.php?page='.$i.'" class="active">'.$i.'</a></li>';
         } else {
            echo '<li><a href="orders.php?page='.$i.'">'.$i.'</a></li>';
         }
      }
      if ($page< $total_pages) {
         echo '<li><a href="orders.php?page='.($page+1).'">Next</a></li>';
         }
         echo '</ul>';
         echo '</div>';
         }
         ?>


</section>















<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
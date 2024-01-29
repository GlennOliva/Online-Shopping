<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = filter_var($payment_status, FILTER_SANITIZE_STRING);
   $update_payment = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_payment->execute([$payment_status, $order_id]);
   $message[] = 'payment status updated!';
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>



<section class="orders">

   <h1 class="heading">placed orders</h1>

   <div class="box-container">

      <?php
         $limit = 3; // set the number of results per page
         $page = isset($_GET['page']) ? $_GET['page'] : 1; // get the current page number
         $start = ($page - 1) * $limit; // calculate the starting point for the results

         $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY `id` DESC LIMIT $start, $limit");
         $select_orders->execute();
         $orders = $select_orders->fetchAll(PDO::FETCH_ASSOC);

         if(count($orders) > 0){
            foreach($orders as $order){
      ?>
            <div class="box">
               <p> placed on : <span><?= $order['placed_on']; ?></span> </p>
               <p> name : <span><?= $order['name']; ?></span> </p>
               <p> number : <span><?= $order['number']; ?></span> </p>
               <p> address : <span><?= $order['address']; ?></span> </p>
               <p> total products : <span><?= $order['total_products']; ?></span> </p>
               <p> total price : <span>₱<?= $order['total_price']; ?></span> </p>
               <p> payment method : <span><?= $order['method']; ?></span> </p>
               <form action="" method="post">
                  <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                  <select name="payment_status" class="select">
                     <option selected disabled><?= $order['payment_status']; ?></option>
                     <option value="Pending">pending</option>
                     <option value="on_delivery">On delivery</option>
                     <option value="Cancelled_Order">Cancelled Order</option>
                     <option value="Delivered">Completed Order</option>
                  </select>
                  <div class="flex-btn">
                     <input type="submit" value="update" class="option-btn" name="update_payment">
                     <a href="placed_orders.php?delete=<?= $order['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
                  </div>
               </form>
            </div>
<?php
      }
   } else {
      echo "<p>No orders found.</p>";
   }

   // Pagination links
   $select_count = $conn->prepare("SELECT COUNT(*) as count FROM `orders`");
   $select_count->execute();
   $result = $select_count->fetch(PDO::FETCH_ASSOC);
   $total_records = $result['count'];
   $total_pages = ceil($total_records / $limit);

   if($total_pages > 1){
      echo '<div class="pagination">';
      if($page > 1){
         echo '<a href="?page='.($page - 1).'" class="page-link">&laquo; Prev</a>';
      }
      for($i = 1; $i <= $total_pages; $i++){
         if($i == $page){
            echo '<a href="#" class="page-link active">'.$i.'</a>';
         }else{
            echo '<a href="?page='.$i.'" class="page-link">'.$i.'</a>';
         }
      }
      if($page != $total_pages){
         echo '<a href="?page='.($page + 1).'" class="page-link">Next &raquo;</a>';
      }
      echo '</div>';
   }
?>

</section>

</section>

<style>
.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  padding-left: 160%;
}

.pagination-container {
  margin-top: 20px;
  
}

.page-link {
   
   display: inline-block;
   padding: 10px 15px;
   margin-right: 5px;
   background-color: #f5f5f5;
   border: 1px solid #ccc;
   color: #333;
   text-decoration: none;
}
.page-link.active {
   background-color: #428bca;
   color: #fff;
   border-color: #428bca;
}
.page-link:hover {
   background-color: #ddd;
   border-color: #999;
   color: #333;
}

@media screen and (max-width: 768px) {
  .pagination {
    padding-left: 0;
  }
}
</style>











<script src="../js/admin_script.js"></script>
   
</body>
</html>
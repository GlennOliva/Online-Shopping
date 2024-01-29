<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_user = $conn->prepare("DELETE FROM `users` WHERE id = ?");
   $delete_user->execute([$delete_id]);
   $delete_orders = $conn->prepare("DELETE FROM `orders` WHERE user_id = ?");
   $delete_orders->execute([$delete_id]);
   $delete_messages = $conn->prepare("DELETE FROM `messages` WHERE user_id = ?");
   $delete_messages->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE user_id = ?");
   $delete_wishlist->execute([$delete_id]);
   header('location:users_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">user accounts</h1>

   <div class="box-container">

   <?php
      // Pagination variables
      $limit = 10;
      $page = isset($_GET['page']) ? $_GET['page'] : 1;
      $offset = ($page - 1) * $limit;

      // Get total number of accounts
      $select_count = $conn->prepare("SELECT COUNT(*) as count FROM `users`");
      $select_count->execute();
      $result = $select_count->fetch(PDO::FETCH_ASSOC);
      $total_records = $result['count'];
      $total_pages = ceil($total_records / $limit);

      // Get accounts for the current page
      $select_accounts = $conn->prepare("SELECT * FROM `users` LIMIT :limit OFFSET :offset");
      $select_accounts->bindParam(':limit', $limit, PDO::PARAM_INT);
      $select_accounts->bindParam(':offset', $offset, PDO::PARAM_INT);
      $select_accounts->execute();

      if($select_accounts->rowCount() > 0){
         while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){   
   ?>
   <div class="box">
      <p> user id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
   </div>
   <?php
         }

         // Pagination links
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

      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>













<script src="../js/admin_script.js"></script>
   
</body>
</html>
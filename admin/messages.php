<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_message = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
   $delete_message->execute([$delete_id]);
   header('location:messages.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>messages</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="contacts">

<h1 class="heading">messages</h1>

<form action="" method="post">
   <span class="sdate">Start-Date:</span>  <input type="datetime-local" name="start_date" class="form-input" placeholder="Start Date" step="1">
   <span class="sdate">End-Date:  </span> <input type="datetime-local" name="end_date" class="form-input" placeholder="End Date" step="1">
   <input type="submit" name="submit" class="form-button" value="Filter">
</form>

<style>

   .sdate{
      font-size: 14px;
      color: #333;

   }
    .filter-form {
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      
   }

   .form-input {
      padding: 8px 12px;
      border-radius: 5px;
      border: 1px solid #ccc;
      font-size: 16px;
      margin-right: 10px;
      margin-bottom: 20px;
      box-sizing: border-box;
   }

   .form-button {
      background-color: #4CAF50;
      color: white;
      padding: 8px 12px;
      border-radius: 5px;
      border: none;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 20px;
   }

   .form-button:hover {
      background-color: #3e8e41;
   }
</style>

<div class="box-container">

<?php
      if(isset($_POST['submit'])){
         $start_date = date('Y-m-d H:i:s', strtotime($_POST['start_date']));
         $end_date = date('Y-m-d H:i:s', strtotime($_POST['end_date']));
         $query = "SELECT * FROM `messages` WHERE `datetime` BETWEEN '$start_date' AND '$end_date'";
      }
      else{
         $query = "SELECT * FROM `messages`";
      }
      $select_messages = $conn->prepare($query);
      $select_messages->execute();
      if($select_messages->rowCount() > 0){
         while($fetch_message = $select_messages->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
   <p> user id : <span><?= $fetch_message['user_id']; ?></span></p>
   <p> name : <span><?= $fetch_message['name']; ?></span></p>
   <p> email : <span><?= $fetch_message['email']; ?></span></p>
   <p> number : <span><?= $fetch_message['number']; ?></span></p>
   <p> message : <span><?= $fetch_message['message']; ?></span></p>
   <p> date : <span><?= $fetch_message['datetime']; ?></span></p>
   <a href="messages.php?delete=<?= $fetch_message['id']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages</p>';
      }
   ?>

</div>


</section>













<script src="../js/admin_script.js"></script>
   
</body>
</html>
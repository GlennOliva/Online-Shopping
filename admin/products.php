<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $details = $_POST['details'];
   $details = filter_var($details, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $stock = $_POST['stock_quantity'];
   $stock = filter_var($stock, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(name, details, price, image_01, image_02, image_03, category, stock) VALUES(?,?,?,?,?,?,?,?)");
      $insert_products->execute([$name, $details, $price, $image_01, $image_02, $image_03,$category,$stock]);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'new product added!';
         }

      }

   }  

};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   $delete_wishlist = $conn->prepare("DELETE FROM `wishlist` WHERE pid = ?");
   $delete_wishlist->execute([$delete_id]);
   $_SESSION['product_deleted'] = true; // set the flag to true
   header('location:products.php');
}
else if(isset($_SESSION['product_deleted']) && $_SESSION['product_deleted']){
   $message[] = 'Product Sucessfully Deleted!';
   unset($_SESSION['product_deleted']); // unset the flag
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>product name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>product price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="price">
         </div>
        <div class="inputBox">
            <span>image 01 (required)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>image 02 (required)</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>image 03 (required)</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>product details (required)</span>
            <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>

         <div class="inputBox">
            <label for="category" style="font-size: 16px; ">Category:</label>
            <select id="category" name="category" required>
               <option value="" selected disabled>Select category</option>
               <option value="electronics">Electronics</option>
               <option value="homeapliances">Home Appliances</option>
               <option value="aparel">Apparel</option>
               <option value="kitchenware">Kitchenware</option>
               <option value="beautypersonalcare">Beauty & Personal Care</option>
               <option value="handtool">Hand Tools</option>
               <option value="drinkware">Drinkware</option>
               <option value="hairaces">Hair Accessories</option>
               <option value="petsup">Pet Supplies</option>
               <option value="foodbeve">Food & Beverage</option>
               <option value="sports">Sports</option>
               <option value="musical">Musical Instruments</option>
            </select>
         </div>

         <div class="inputBox">
            <span>stock quantity (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter stock quantity" onkeypress="if(this.value.length == 10) return false;" name="stock_quantity">
         </div>



      </div>
      
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>

</section>

<?php
   // set the page size
   $page_size = 15;

   // get the current page number from the URL parameter
   $page_number = isset($_GET['page']) ? $_GET['page'] : 1;

   // get the category filter from the URL parameter
   $category = isset($_GET['category']) ? $_GET['category'] : null;

   // calculate the offset for the SQL query
   $offset = ($page_number - 1) * $page_size;

   // construct the SQL query with the category filter and limit
   $sql = "SELECT * FROM `products`";
   if ($category) {
      $sql .= " WHERE `category` = :category";
   }
   $sql .= " LIMIT :page_size OFFSET :offset";

   $select_products = $conn->prepare($sql);
   if ($category) {
      $select_products->bindParam(':category', $category);
   }
   $select_products->bindParam(':page_size', $page_size, PDO::PARAM_INT);
   $select_products->bindParam(':offset', $offset, PDO::PARAM_INT);
   $select_products->execute();

   // count the total number of products
   $total_products = $conn->query("SELECT COUNT(*) FROM `products`")->fetchColumn();

   // calculate the total number of pages
   $total_pages = ceil($total_products / $page_size);
?>

<section class="show-products">

   <h1 class="heading">Products</h1>

   <div class="box-container">

   <?php
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price">₱<span><?= $fetch_products['price']; ?></span></div>
      <div class="details"><span><?= $fetch_products['details']; ?></span></div>
      <div class="category"><?= $fetch_products['category']; ?></div>
      <div class="stock_quantity">Stock Qty:<?= $fetch_products['stock']; ?></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>
   
   </div>

   <div class="pagination">
   <?php if ($total_pages > 1): ?>
      <?php if ($page_number > 1): ?>
         <a href="products.php?page=<?= $page_number - 1 ?><?php if ($category) { echo '&category='.$category; } ?>" class="page-link">&laquo; Prev</a>
      <?php endif; ?>

      <?php for ($i=1; $i<=$total_pages; $i++): ?>
         <?php if ($i == $page_number): ?>
            <a href="#" class="page-link active"><?= $i ?></a>
         <?php else: ?>
            <a href="products.php?page=<?= $i ?><?php if ($category) { echo '&category='.$category; } ?>" class="page-link"><?= $i ?></a>
         <?php endif; ?>
      <?php endfor; ?>

      <?php if ($page_number < $total_pages): ?>
         <a href="products.php?page=<?= $page_number + 1 ?><?php if ($category) { echo '&category='.$category; } ?>" class="page-link">Next &raquo;</a>
      <?php endif; ?>
   <?php endif; ?>
</div>









<script src="../js/admin_script.js"></script>
   
</body>
</html>
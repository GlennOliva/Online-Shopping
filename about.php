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
   <title>about</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="about">

   <div class="row">

      <div class="image">
         <img src="rev_pic/ecommerce-1.png" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>
         The most significant point to remember from this is that customers choose to purchase at an e-commerce platform based on a variety of variables, including product selection, cost, and availability. Product selection is vital to ensuring that customers have a diverse range of items available, yet pricing is a critical component that impacts a customer's decision to shop at the business. 
         Constantly assessing and adjusting prices can help the shop remain competitive and attract more customers.
         </p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">
   
   <h1 class="heading">client's reviews</h1>

   <div class="swiper reviews-slider">

   <div class="swiper-wrapper">

      <div class="swiper-slide slide">
         <img src="rev_pic/aj.png" alt="">
         <p>I recently made a purchase on this ecommerce site and I am blown away by the quality of their products. I would rate them a solid 8 out of 10, and would highly recommend.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Aj Calcena</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="rev_pic/bat.png" alt="">
         <p>If you're looking for a reliable ecommerce platform that offers great prices and fast shipping, this is the site for you. I would give them a rating of 9 out of 10 for their excellent.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>john Paolo Batoon</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="rev_pic/ber.png" alt="">
         <p>I was blown away by how amazing everything was! I couldn't believe how friendly and accommodating the staff was, and I left feeling truly happy and satisfied.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Bernard Maraon</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="rev_pic/eds.png" alt="">
         <p>From start to finish, my experience with this ecommerce platform was fantastic. The checkout process was quick and easy, and my order arrived earlier than expected.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Edda Mae Osorno</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="rev_pic/hanz.png" alt="">
         <p>I've used a lot of different ecommerce sites in the past, but this one stands out as one of the best. The customer service is top-notch, the products are high-quality.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Hanz Daryl Quezada</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="rev_pic/janley.png" alt="">
         <p>On a scale of 1-10, I would give this place an 8. While there were a few minor issues, my overall experience was fantastic and I would definitely recommend it to others.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>johnley Engyo</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="rev_pic/juswa.png" alt="">
         <p>I was thrilled by the complimentary glass of champagne and personalized note from the staff. It was such a lovely and unexpected touch!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Le Joshua Guzman</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="rev_pic/marie.png" alt="">
         <p>I have never had such a smooth and hassle-free ecommerce experience before. The checkout process was simple and straightforward and my order arrived on time and in perfect condition.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Marie Cris Alarilla</h3>
      </div>

      <div class="swiper-slide slide">
         <img src="rev_pic/raymond.png" alt="">
         <p>I recently purchased some clothes from this online store and I have to say, I'm impressed! The website was easy to navigate, the prices were competitive, and the shipping was fast.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Raymond Mapayo</h3>
      </div>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>









<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".reviews-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
        slidesPerView:1,
      },
      768: {
        slidesPerView: 2,
      },
      991: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>
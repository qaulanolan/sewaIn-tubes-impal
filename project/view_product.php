<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:home.php');
}

include 'components/save_send.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>View product</title>

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- view product section starts  -->

<section class="view-product">

   <h1 class="heading">detail produk</h1>

   <?php
      $select_properties = $conn->prepare("SELECT * FROM `product` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_properties->execute([$get_id]);
      if($select_properties->rowCount() > 0){
         while($fetch_product = $select_properties->fetch(PDO::FETCH_ASSOC)){

         $product_id = $fetch_product['id'];

         $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
         $select_user->execute([$fetch_product['user_id']]);
         $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

         $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE product_id = ? and user_id = ?");
         $select_saved->execute([$fetch_product['id'], $user_id]);
   ?>
   <div class="details">
     <div class="swiper images-container">
         <div class="swiper-wrapper">
            <img src="uploaded_files/<?= $fetch_product['image_01']; ?>" alt="" class="swiper-slide">
            <?php if(!empty($fetch_product['image_02'])){ ?>
            <img src="uploaded_files/<?= $fetch_product['image_02']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_product['image_03'])){ ?>
            <img src="uploaded_files/<?= $fetch_product['image_03']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_product['image_04'])){ ?>
            <img src="uploaded_files/<?= $fetch_product['image_04']; ?>" alt="" class="swiper-slide">
            <?php } ?>
            <?php if(!empty($fetch_product['image_05'])){ ?>
            <img src="uploaded_files/<?= $fetch_product['image_05']; ?>" alt="" class="swiper-slide">
            <?php } ?>
         </div>
         <div class="swiper-pagination"></div>
     </div>
      <h3 class="name"><?= $fetch_product['product_name']; ?></h3>
      <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_product['address']; ?></span></p>
      <div class="info">
         <p><i class="fas fa-rupiah-sign"></i><span><?= $fetch_product['price']; ?></span></p>
         <p><i class="fas fa-user"></i><span><?= $fetch_user['name']; ?></span></p>
         <p><i class="fas fa-phone"></i><a href="https://wa.me/62<?= substr($fetch_user['number'], 1); ?>"><?= $fetch_user['number']; ?></a></p>
         <p><i class="fas fa-layer-group"></i><span><?= $fetch_product['type']; ?></span></p>
         <!-- <p><i class="fas fa-layer-group"></i><span><?= $fetch_product['offer']; ?></span></p> -->
         <p><i class="fas fa-calendar"></i><span><?= $fetch_product['date']; ?></span></p>
      </div>
      <h3 class="title">description</h3>
      <p class="description"><?= $fetch_product['description']; ?></p>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="product_id" value="<?= $product_id; ?>">
         <?php
            if($select_saved->rowCount() > 0){
         ?>
         <button type="submit" name="save" class="save"><i class="fas fa-heart"></i><span>saved</span></button>
         <?php
            }else{ 
         ?>
         <button type="submit" name="save" class="save"><i class="far fa-heart"></i><span>save</span></button>
         <?php
            }
         ?>
         <input type="submit" value="pesan" name="send" class="btn">
      </form>
   </div>
   <?php
      }
   }else{
      echo '<p class="empty">product not found! <a href="post_product.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
   }
   ?>

</section>

<!-- view product section ends -->










<script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>

var swiper = new Swiper(".images-container", {
   effect: "coverflow",
   grabCursor: true,
   centeredSlides: true,
   slidesPerView: "auto",
   loop:true,
   coverflowEffect: {
      rotate: 0,
      stretch: 0,
      depth: 200,
      modifier: 3,
      slideShadows: true,
   },
   pagination: {
      el: ".swiper-pagination",
   },
});

</script>

</body>
</html>
<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>About Us</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- about section starts  -->

<section class="about">

   <div class="row">
      <div class="image">
         <img src="images/about-img.svg" alt="">
      </div>
      <div class="content">
         <h3>why choose us?</h3>
         <p>Kami adalah platform penyewaan terpercaya yang menyediakan layanan sewa properti, barang, dan kendaraan untuk memenuhi berbagai kebutuhan Kamu.</p>
         <a href="contact.php" class="inline-btn">contact us</a>
      </div>
   </div>

</section>

<!-- about section ends -->

<!-- steps section starts  -->

<section class="steps">

   <h1 class="heading">3 simple steps</h1>

   <div class="box-container">

      <div class="box">
         <a href="search.php">
         <img src="images/step-1.png" alt="">
         <h3>cari produk</h3>
         <p>Jelajahi berbagai pilihan produk, tempat, atau kendaraan yang tersedia sesuai kebutuhan Kamu.</p>
         </a>
      </div>

      <div class="box">
         <img src="images/step-2.png" alt="">
         <h3>hubungi lessor</h3>
         <p>Hubungi penyedia/lessor secara langsung untuk berdiskusi, menanyakan detail, atau melakukan negosiasi harga.</p>
      </div>

      <div class="box">
         <a href="listings.php">
         <img src="images/step-3.png" alt="">
         <h3>gunakan produk</h3>
         <p>Setelah kesepakatan tercapai, nikmati layanan atau produk yang Kamu sewa dengan mudah dan nyaman.</p>
         </a>
      </div>

   </div>

</section>

<!-- steps section ends -->


<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
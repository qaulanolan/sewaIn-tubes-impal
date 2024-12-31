<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search Page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- search filter section starts  -->

<section class="filters" style="padding-bottom: 0;">

   <form action="" method="post">
      <div id="close-filter"><i class="fas fa-times"></i></div>
      <h3>Filter Pencarian</h3>
         
         <div class="flex">
            <div class="box">
               <p>Nama Produk</p>
               <input type="text" name="product_name" maxlength="100" placeholder="Nama produk yang ingin dicari" class="input">
            </div>
            <div class="box">
               <p>Lokasi</p>
               <input type="text" name="location" maxlength="50" placeholder="Lokasi anda" class="input">
            </div>
            <div class="box">
               <p>Minimum Budget</p>
               <select name="min" class="input">
                  <option value="">Tidak Ada</option>
                  <option value="0">0</option>
                  <option value="50000">Rp 50.000</option>
                  <option value="100000">Rp 100.000</option>
                  <option value="150000">Rp 150.000</option>
                  <option value="200000">Rp 200.000</option>
                  <option value="250000">Rp 250.000</option>
               </select>
            </div>
            <div class="box">
               <p>Maximum Budget</p>
               <select name="max" class="input">
                  <option value="">Tidak Ada</option>
                  <option value="500000">Rp 500.000</option>
                  <option value="1000000">Rp 1.000.000</option>
                  <option value="5000000">Rp 5.000.000</option>
                  <option value="10000000">Rp 10.000.000</option>
                  <option value="100000000">Rp 100.000.000</option>
               </select>
            </div>
            <div class="box">
               <p>Kategori</p>
               <select name="type" class="input">
                  <option value="">Semua</option>
                  <option value="tempat">Tempat</option>
                  <option value="barang">Barang</option>
                  <option value="kendaraan">Kendaraan</option>
               </select>
            </div>
         </div>
         <input type="submit" value="Cari Produk" name="filter_search" class="btn">
   </form>

</section>

<!-- search filter section ends -->

<div id="filter-btn" class="fas fa-filter"></div>

<?php
$query = "SELECT * FROM `product` WHERE 1=1";
$params = [];

if(isset($_POST['filter_search'])){
   if(!empty($_POST['product_name'])) {
      $product_name = filter_var($_POST['product_name'], FILTER_SANITIZE_STRING);
      $query .= " AND product_name LIKE ?";
      $params[] = "%$product_name%";
   }

   if(!empty($_POST['location'])) {
      $location = filter_var($_POST['location'], FILTER_SANITIZE_STRING);
      $query .= " AND address LIKE ?";
      $params[] = "%$location%";
   }

   if(!empty($_POST['type'])) {
      $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
      $query .= " AND type = ?";
      $params[] = $type;
   }

   if(!empty($_POST['min'])) {
      $min = filter_var($_POST['min'], FILTER_SANITIZE_STRING);
      $query .= " AND price >= ?";
      $params[] = $min;
   }

   if(!empty($_POST['max'])) {
      $max = filter_var($_POST['max'], FILTER_SANITIZE_STRING);
      $query .= " AND price <= ?";
      $params[] = $max;
   }

   $query .= " ORDER BY date DESC";
} else {
   $query .= " ORDER BY date DESC LIMIT 6";
}

$select_properties = $conn->prepare($query);
$select_properties->execute($params);
?>

<!-- listings section starts  -->

<section class="listings">

   <?php 
      if(isset($_POST['filter_search'])){
         echo '<h1 class="heading">Hasil Pencarian</h1>';
      }else{
         echo '<h1 class="heading">Listing Terbaru</h1>';
      }
   ?>

   <div class="box-container">
      <?php
         if($select_properties->rowCount() > 0){
            while($fetch_product = $select_properties->fetch(PDO::FETCH_ASSOC)){
               $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_user->execute([$fetch_product['user_id']]);
               $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
      ?>
      <form action="" method="POST">
         <div class="box">
            <input type="hidden" name="product_id" value="<?= $fetch_product['id']; ?>">
            <?php
               $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE product_id = ? and user_id = ?");
               $select_saved->execute([$fetch_product['id'], $user_id]);
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
            <div class="thumb">
               <img src="uploaded_files/<?= $fetch_product['image_01']; ?>" alt="">
            </div>
            <div class="admin">
               <h3><?= substr($fetch_user['name'], 0, 1); ?></h3>
               <div>
                  <p><?= $fetch_user['name']; ?></p>
                  <span><?= $fetch_product['date']; ?></span>
               </div>
            </div>
         </div>
         <div class="box">
            <div class="price"><i class="fas fa-rupiah-sign"></i><span><?= $fetch_product['price']; ?></span></div>
            <h3 class="name"><?= $fetch_product['product_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_product['address']; ?></span></p>
            <div class="flex">
               <p><i class="fas fa-layer-group"></i><span><?= $fetch_product['type']; ?></span></p>
            </div>
            <div class="flex-btn">
               <a href="view_product.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Lihat Produk</a>
               <a href="tel:<?= $fetch_user['number']; ?>" class="btn">Hubungi Lessor</a>
               <input type="submit" value="Pesan" name="send" class="btn">
            </div>
         </div>
      </form>
      <?php
         }
      }else{
         echo '<p class="empty">Tidak ada hasil ditemukan!</p>';
      }
      ?>
   </div>

</section>

<!-- listings section ends -->











<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

<script>

document.querySelector('#filter-btn').onclick = () =>{
   document.querySelector('.filters').classList.add('active');
}

document.querySelector('#close-filter').onclick = () =>{
   document.querySelector('.filters').classList.remove('active');
}

</script>

</body>
</html>
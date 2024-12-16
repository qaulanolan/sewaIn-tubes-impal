<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:home.php');
}

if(isset($_POST['update'])){

   $update_id = $_POST['product_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $product_name = $_POST['product_name'];
   $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $type = $_POST['type'];
   $type = filter_var($type, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);

   if(isset($_POST['lift'])){
      $lift = $_POST['lift'];
      $lift = filter_var($lift, FILTER_SANITIZE_STRING);
   }else{
      $lift = 'no';
   }
   if(isset($_POST['security_guard'])){
      $security_guard = $_POST['security_guard'];
      $security_guard = filter_var($security_guard, FILTER_SANITIZE_STRING);
   }else{
      $security_guard = 'no';
   }
   if(isset($_POST['play_ground'])){
      $play_ground = $_POST['play_ground'];
      $play_ground = filter_var($play_ground, FILTER_SANITIZE_STRING);
   }else{
      $play_ground = 'no';
   }
   if(isset($_POST['garden'])){
      $garden = $_POST['garden'];
      $garden = filter_var($garden, FILTER_SANITIZE_STRING);
   }else{
      $garden = 'no';
   }
   if(isset($_POST['water_supply'])){
      $water_supply = $_POST['water_supply'];
      $water_supply = filter_var($water_supply, FILTER_SANITIZE_STRING);
   }else{
      $water_supply = 'no';
   }
   if(isset($_POST['power_backup'])){
      $power_backup = $_POST['power_backup'];
      $power_backup = filter_var($power_backup, FILTER_SANITIZE_STRING);
   }else{
      $power_backup = 'no';
   }
   if(isset($_POST['parking_area'])){
      $parking_area = $_POST['parking_area'];
      $parking_area = filter_var($parking_area, FILTER_SANITIZE_STRING);
   }else{
      $parking_area = 'no';
   }
   if(isset($_POST['gym'])){
      $gym = $_POST['gym'];
      $gym = filter_var($gym, FILTER_SANITIZE_STRING);
   }else{
      $gym = 'no';
   }
   if(isset($_POST['shopping_mall'])){
      $shopping_mall = $_POST['shopping_mall'];
      $shopping_mall = filter_var($shopping_mall, FILTER_SANITIZE_STRING);
   }else{
      $shopping_mall = 'no';
   }
   if(isset($_POST['hospital'])){
      $hospital = $_POST['hospital'];
      $hospital = filter_var($hospital, FILTER_SANITIZE_STRING);
   }else{
      $hospital = 'no';
   }
   if(isset($_POST['school'])){
      $school = $_POST['school'];
      $school = filter_var($school, FILTER_SANITIZE_STRING);
   }else{
      $school = 'no';
   }
   if(isset($_POST['market_area'])){
      $market_area = $_POST['market_area'];
      $market_area = filter_var($market_area, FILTER_SANITIZE_STRING);
   }else{
      $market_area = 'no';
   }

   $old_image_01 = $_POST['old_image_01'];
   $old_image_01 = filter_var($old_image_01, FILTER_SANITIZE_STRING);
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = 'uploaded_files/'.$rename_image_01;

   if(!empty($image_01)){
      if($image_01_size > 2000000){
         $warning_msg[] = 'image 05 size is too large!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `product` SET image_01 = ? WHERE id = ?");
         $update_image_01->execute([$rename_image_01, $update_id]);
         move_uploaded_file($image_01_tmp_name, $image_01_folder);
         if($old_image_01 != ''){
            unlink('uploaded_files/'.$old_image_01);
         }
      }
   }

   $old_image_02 = $_POST['old_image_02'];
   $old_image_02 = filter_var($old_image_02, FILTER_SANITIZE_STRING);
   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
   $rename_image_02 = create_unique_id().'.'.$image_02_ext;
   $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
   $image_02_size = $_FILES['image_02']['size'];
   $image_02_folder = 'uploaded_files/'.$rename_image_02;

   if(!empty($image_02)){
      if($image_02_size > 2000000){
         $warning_msg[] = 'image 05 size is too large!';
      }else{
         $update_image_02 = $conn->prepare("UPDATE `product` SET image_02 = ? WHERE id = ?");
         $update_image_02->execute([$rename_image_02, $update_id]);
         move_uploaded_file($image_02_tmp_name, $image_02_folder);
         if($old_image_02 != ''){
            unlink('uploaded_files/'.$old_image_02);
         }
      }
   }

   $old_image_03 = $_POST['old_image_03'];
   $old_image_03 = filter_var($old_image_03, FILTER_SANITIZE_STRING);
   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_03_ext = pathinfo($image_03, PATHINFO_EXTENSION);
   $rename_image_03 = create_unique_id().'.'.$image_03_ext;
   $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
   $image_03_size = $_FILES['image_03']['size'];
   $image_03_folder = 'uploaded_files/'.$rename_image_03;

   if(!empty($image_03)){
      if($image_03_size > 2000000){
         $warning_msg[] = 'image 05 size is too large!';
      }else{
         $update_image_03 = $conn->prepare("UPDATE `product` SET image_03 = ? WHERE id = ?");
         $update_image_03->execute([$rename_image_03, $update_id]);
         move_uploaded_file($image_03_tmp_name, $image_03_folder);
         if($old_image_03 != ''){
            unlink('uploaded_files/'.$old_image_03);
         }
      }
   }

   $old_image_04 = $_POST['old_image_04'];
   $old_image_04 = filter_var($old_image_04, FILTER_SANITIZE_STRING);
   $image_04 = $_FILES['image_04']['name'];
   $image_04 = filter_var($image_04, FILTER_SANITIZE_STRING);
   $image_04_ext = pathinfo($image_04, PATHINFO_EXTENSION);
   $rename_image_04 = create_unique_id().'.'.$image_04_ext;
   $image_04_tmp_name = $_FILES['image_04']['tmp_name'];
   $image_04_size = $_FILES['image_04']['size'];
   $image_04_folder = 'uploaded_files/'.$rename_image_04;

   if(!empty($image_04)){
      if($image_04_size > 2000000){
         $warning_msg[] = 'image 05 size is too large!';
      }else{
         $update_image_04 = $conn->prepare("UPDATE `product` SET image_04 = ? WHERE id = ?");
         $update_image_04->execute([$rename_image_04, $update_id]);
         move_uploaded_file($image_04_tmp_name, $image_04_folder);
         if($old_image_04 != ''){
            unlink('uploaded_files/'.$old_image_04);
         }
      }
   }

   $old_image_05 = $_POST['old_image_05'];
   $old_image_05 = filter_var($old_image_05, FILTER_SANITIZE_STRING);
   $image_05 = $_FILES['image_05']['name'];
   $image_05 = filter_var($image_05, FILTER_SANITIZE_STRING);
   $image_05_ext = pathinfo($image_05, PATHINFO_EXTENSION);
   $rename_image_05 = create_unique_id().'.'.$image_05_ext;
   $image_05_tmp_name = $_FILES['image_05']['tmp_name'];
   $image_05_size = $_FILES['image_05']['size'];
   $image_05_folder = 'uploaded_files/'.$rename_image_05;

   if(!empty($image_05)){
      if($image_05_size > 2000000){
         $warning_msg[] = 'image 05 size is too large!';
      }else{
         $update_image_05 = $conn->prepare("UPDATE `product` SET image_05 = ? WHERE id = ?");
         $update_image_05->execute([$rename_image_05, $update_id]);
         move_uploaded_file($image_05_tmp_name, $image_05_folder);
         if($old_image_05 != ''){
            unlink('uploaded_files/'.$old_image_05);
         }
      }
   }

   $update_listing = $conn->prepare("UPDATE `product` SET product_name = ?, address = ?, price = ?, type = ?,description = ? WHERE id = ?");   
   $update_listing->execute([$product_name, $address, $price, $type, $description, $update_id]);

   $success_msg[] = 'listing updated successfully!';

}

if(isset($_POST['delete_image_02'])){

   $old_image_02 = $_POST['old_image_02'];
   $old_image_02 = filter_var($old_image_02, FILTER_SANITIZE_STRING);
   $update_image_02 = $conn->prepare("UPDATE `product` SET image_02 = ? WHERE id = ?");
   $update_image_02->execute(['', $get_id]);
   if($old_image_02 != ''){
      unlink('uploaded_files/'.$old_image_02);
      $success_msg[] = 'image 02 deleted!';
   }

}

if(isset($_POST['delete_image_03'])){

   $old_image_03 = $_POST['old_image_03'];
   $old_image_03 = filter_var($old_image_03, FILTER_SANITIZE_STRING);
   $update_image_03 = $conn->prepare("UPDATE `product` SET image_03 = ? WHERE id = ?");
   $update_image_03->execute(['', $get_id]);
   if($old_image_03 != ''){
      unlink('uploaded_files/'.$old_image_03);
      $success_msg[] = 'image 03 deleted!';
   }

}

if(isset($_POST['delete_image_04'])){

   $old_image_04 = $_POST['old_image_04'];
   $old_image_04 = filter_var($old_image_04, FILTER_SANITIZE_STRING);
   $update_image_04 = $conn->prepare("UPDATE `product` SET image_04 = ? WHERE id = ?");
   $update_image_04->execute(['', $get_id]);
   if($old_image_04 != ''){
      unlink('uploaded_files/'.$old_image_04);
      $success_msg[] = 'image 04 deleted!';
   }

}

if(isset($_POST['delete_image_05'])){

   $old_image_05 = $_POST['old_image_05'];
   $old_image_05 = filter_var($old_image_05, FILTER_SANITIZE_STRING);
   $update_image_05 = $conn->prepare("UPDATE `product` SET image_05 = ? WHERE id = ?");
   $update_image_05->execute(['', $get_id]);
   if($old_image_05 != ''){
      unlink('uploaded_files/'.$old_image_05);
      $success_msg[] = 'image 05 deleted!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="product-form">

   <?php
      $select_properties = $conn->prepare("SELECT * FROM `product` WHERE id = ? ORDER BY date DESC LIMIT 1");
      $select_properties->execute([$get_id]);
      if($select_properties->rowCount() > 0){
         while($fetch_product = $select_properties->fetch(PDO::FETCH_ASSOC)){
         $product_id = $fetch_product['id'];
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="product_id" value="<?= $product_id; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_product['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_product['image_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_product['image_03']; ?>">
      <input type="hidden" name="old_image_04" value="<?= $fetch_product['image_04']; ?>">
      <input type="hidden" name="old_image_05" value="<?= $fetch_product['image_05']; ?>">
      <h3>product details</h3>
      <div class="box">
         <p>product name <span>*</span></p>
         <input type="text" name="product_name" required maxlength="50" placeholder="enter product name" value="<?= $fetch_product['product_name']; ?>" class="input">
      </div>
      <div class="flex">
         <div class="box">
            <p>product price <span>*</span></p>
            <input type="number" name="price" required min="0" max="9999999999" maxlength="10" value="<?= $fetch_product['price']; ?>" placeholder="enter product price" class="input">
         </div>
         <div class="box">
            <p>product address <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="enter product full address" class="input" value="<?= $fetch_product['address']; ?>">
         </div>
         <div class="box">
            <p>product type <span>*</span></p>
            <select name="type" required class="input">
               <option value="<?= $fetch_product['type']; ?>" selected><?= $fetch_product['type']; ?></option>
               <option value="properti">properti</option>
               <option value="barang">barang</option>
               <option value="kendaraan">kendaraan</option>
            </select>
         </div>
      </div>
      <div class="box">
         <p>product description <span>*</span></p>
         <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="write about product..." ><?= $fetch_product['description']; ?></textarea>
      </div>
      <div class="box">
         <img src="uploaded_files/<?= $fetch_product['image_01']; ?>" class="image" alt="">
         <p>update image 01</p>
         <input type="file" name="image_01" class="input" accept="image/*">
      </div>
      <div class="flex"> 
         <div class="box">
            <?php if(!empty($fetch_product['image_02'])){ ?>
            <img src="uploaded_files/<?= $fetch_product['image_02']; ?>" class="image" alt="">
            <input type="submit" value="delete image 02" name="delete_image_02" class="inline-btn" onclick="return confirm('delete image 02');">
            <?php } ?>
            <p>update image 02</p>
            <input type="file" name="image_02" class="input" accept="image/*">
         </div>
         <div class="box">
            <?php if(!empty($fetch_product['image_03'])){ ?>
            <img src="uploaded_files/<?= $fetch_product['image_03']; ?>" class="image" alt="">
            <input type="submit" value="delete image 03" name="delete_image_03" class="inline-btn" onclick="return confirm('delete image 03');">
            <?php } ?>
            <p>update image 03</p>
            <input type="file" name="image_03" class="input" accept="image/*">
         </div>
         <div class="box">
            <?php if(!empty($fetch_product['image_04'])){ ?>
            <img src="uploaded_files/<?= $fetch_product['image_04']; ?>" class="image" alt="">
            <input type="submit" value="delete image 04" name="delete_image_04" class="inline-btn" onclick="return confirm('delete image 04');">
            <?php } ?>
            <p>update image 04</p>
            <input type="file" name="image_04" class="input" accept="image/*">
         </div>
         <div class="box">
            <?php if(!empty($fetch_product['image_05'])){ ?>
            <img src="uploaded_files/<?= $fetch_product['image_05']; ?>" class="image" alt="">
            <input type="submit" value="delete image 05" name="delete_image_05" class="inline-btn" onclick="return confirm('delete image 05');">
            <?php } ?>
            <p>update image 05</p>
            <input type="file" name="image_05" class="input" accept="image/*">
         </div>   
      </div>
      <input type="submit" value="update product" class="btn" name="update">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty">product not found! <a href="post_product.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
   }
   ?>

</section>






<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>
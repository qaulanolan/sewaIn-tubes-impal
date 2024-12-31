<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
}

if(isset($_POST['post'])){

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

   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $sub_category = $_POST['sub_category'];
   $sub_category = filter_var($sub_category, FILTER_SANITIZE_STRING);
   $specific_category = $_POST['specific_category'];
   $specific_category = filter_var($specific_category, FILTER_SANITIZE_STRING);

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_02_ext = pathinfo($image_02, PATHINFO_EXTENSION);
   $rename_image_02 = create_unique_id().'.'.$image_02_ext;
   $image_02_tmp_name = $_FILES['image_02']['tmp_name'];
   $image_02_size = $_FILES['image_02']['size'];
   $image_02_folder = 'uploaded_files/'.$rename_image_02;

   if(!empty($image_02)){
      if($image_02_size > 2000000){
         $warning_msg[] = 'image 02 size is too large!';
      }else{
         move_uploaded_file($image_02_tmp_name, $image_02_folder);
      }
   }else{
      $rename_image_02 = '';
   }

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_03_ext = pathinfo($image_03, PATHINFO_EXTENSION);
   $rename_image_03 = create_unique_id().'.'.$image_03_ext;
   $image_03_tmp_name = $_FILES['image_03']['tmp_name'];
   $image_03_size = $_FILES['image_03']['size'];
   $image_03_folder = 'uploaded_files/'.$rename_image_03;

   if(!empty($image_03)){
      if($image_03_size > 2000000){
         $warning_msg[] = 'image 03 size is too large!';
      }else{
         move_uploaded_file($image_03_tmp_name, $image_03_folder);
      }
   }else{
      $rename_image_03 = '';
   }

   $image_04 = $_FILES['image_04']['name'];
   $image_04 = filter_var($image_04, FILTER_SANITIZE_STRING);
   $image_04_ext = pathinfo($image_04, PATHINFO_EXTENSION);
   $rename_image_04 = create_unique_id().'.'.$image_04_ext;
   $image_04_tmp_name = $_FILES['image_04']['tmp_name'];
   $image_04_size = $_FILES['image_04']['size'];
   $image_04_folder = 'uploaded_files/'.$rename_image_04;

   if(!empty($image_04)){
      if($image_04_size > 2000000){
         $warning_msg[] = 'image 04 size is too large!';
      }else{
         move_uploaded_file($image_04_tmp_name, $image_04_folder);
      }
   }else{
      $rename_image_04 = '';
   }

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
         move_uploaded_file($image_05_tmp_name, $image_05_folder);
      }
   }else{
      $rename_image_05 = '';
   }

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_01_ext = pathinfo($image_01, PATHINFO_EXTENSION);
   $rename_image_01 = create_unique_id().'.'.$image_01_ext;
   $image_01_tmp_name = $_FILES['image_01']['tmp_name'];
   $image_01_size = $_FILES['image_01']['size'];
   $image_01_folder = 'uploaded_files/'.$rename_image_01;

   if($image_01_size > 2000000){
      $warning_msg[] = 'image 01 size too large!';
   }else{
      $insert_product = $conn->prepare("INSERT INTO `product`(user_id, product_name, address, price, type, category, sub_category, specific_category, image_01, image_02, image_03, image_04, image_05, description) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)"); 
      $insert_product->execute([$user_id, $product_name, $address, $price, $type, $category, $sub_category, $specific_category, $rename_image_01, $rename_image_02, $rename_image_03, $rename_image_04, $rename_image_05, $description]);
      move_uploaded_file($image_01_tmp_name, $image_01_folder);
      $success_msg[] = 'product posted successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>post product</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="product-form">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>detail produk</h3>
      <div class="box">
         <p>nama produk <span>*</span></p>
         <input type="text" name="product_name" required maxlength="50" placeholder="nama produkmu" class="input">
      </div>
      <div class="flex">
         <div class="box">
            <p>harga produk <span>*</span></p>
            <input type="number" name="price" required min="0" max="9999999999" maxlength="10" placeholder="harga produk e.g. 100000" class="input">
         </div>
         <div class="box">
            <p>lokasi <span>*</span></p>
            <input type="text" name="address" required maxlength="100" placeholder="lokasi produkmu" class="input">
         </div>
         <div class="box">
            <p>tipe <span>*</span></p>
            <select name="type" id="type" required class="input" onchange="updateCategory()">
               <option value="" disabled>Pilih kategori</option>
               <option value="tempat">tempat</option>
               <option value="barang">barang</option>
               <option value="kendaraan">kendaraan</option>
            </select>
         </div>

         <div class="box">
            <p>kategori <span>*</span></p>
            <select name="category" id="category" required class="input" onchange="updateSubCategory()">
               <option value="lainnya">lainnya</option>
            </select>
         </div>

         <div class="box">
            <p>sub kategori <span>*</span></p>
            <select name="sub_category" id="sub_category" required class="input" onchange="updateSpecificCategory()">
            <option value="lainnya">lainnya</option>
            </select>
         </div>

         <div class="box">
            <p>kategori spesifik <span>*</span></p>
            <select name="specific_category" id="specific_category" required class="input">
            <option value="lainnya">lainnya</option>
            </select>
         </div>

      </div> 
      <div class="box">
         <p>description <span>*</span></p>
         <textarea name="description" maxlength="1000" class="input" required cols="30" rows="10" placeholder="deskripsikan produkmu"></textarea>
      </div>

      <div class="box">
         <p>image 01 <span>*</span></p>
         <input type="file" name="image_01" class="input" accept="image/*" required>
      </div>
      <div class="flex"> 
         <div class="box">
            <p>image 02</p>
            <input type="file" name="image_02" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>image 03</p>
            <input type="file" name="image_03" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>image 04</p>
            <input type="file" name="image_04" class="input" accept="image/*">
         </div>
         <div class="box">
            <p>image 05</p>
            <input type="file" name="image_05" class="input" accept="image/*">
         </div>   
      </div>
      <input type="submit" value="post produk" class="btn" name="post">
   </form>

</section>


<script>

function updateCategory() {
   const type = document.getElementById("type").value;
   const category = document.getElementById("category");

   category.innerHTML = '<option value="" disabled>Pilih Kategori</option>';

   const arr_category = {
      tempat: ["Tempat Tinggal", "Tempat Acara", "Tempat Lainnya"],
      barang: ["Elektronik", "Alat Rumah Tangga", "Alat Tidur dan Furnitur"],
      kendaraan: ["Kendaraan roda dua", "Kendaraan roda empat", "Kendaraan konstruksi"]
   };

   arr_category[type].forEach(sub => {
      const option = document.createElement("option");
      option.value = sub.toLowerCase();
      option.textContent = sub;
      category.appendChild(option);
   });
}

function updateSubCategory() {
   const category = document.getElementById("category").value;
   const sub_category = document.getElementById("sub_category");

   // Clear existing options
   sub_category.innerHTML = '<option value="" disabled>Pilih Sub Kategori</option>';

   // Define sub-categories for each category
   const arr_sub_category = {
      "kendaraan roda dua": ["motor", "sepeda"],
      "kendaraan roda empat": ["mobil"],
      "kendaraan kontruksi": ["truk", "alat berat"], 
      elektronik: ["laptop", "kamera", "drone", "sound system", "peralatan proyektor", "power bank", "webcam", "lainnya"],
      "alat rumah tangga": ["peralatan dapur", "peralatan pembersih"],
      "alat tidur dan furnitur": ["kasur inflable", "tempat tidur lipat", "set meja dan kursi portable", "kipas angin", "karpet", "lainnya"],
      "tempat tinggal": ["kost", "rumah", "apartemen"],
      "tempat acara": ["ruang pertemuan", "ruang seminar dan pelatihan", "tempat event dan pesta", "studio kreatif"],
      "tempat lainnya": ["lahan parkir", "tempat outdoor", "gudang", "lainnya"]
   };

   arr_sub_category[category].forEach(sub => {
      const option = document.createElement("option");
      option.value = sub.toLowerCase();
      option.textContent = sub;
      sub_category.appendChild(option);
   });
}

function updateSpecificCategory() {
   const sub_category = document.getElementById("sub_category").value;
   const specific_category = document.getElementById("specific_category");

   // Clear existing options
   specific_category.innerHTML = '<option value="" disabled>Pilih Kategori Spesifik</option>';

   // Define sub-categories for each category
   const arr_specific_category = {
      motor: ["motor manual", "motor matic", "motor kopling", "motor listrik", "lainnya"],
      sepeda: ["sepeda gunung", "sepeda listrik", "sepeda lipat", "sepeda fixie", "lainnya"],
      mobil: ["suv", "listrik", "sport & convertible", "van & mpv", "lainnya"],
      truk: ["pickup", "box", "flatbed", "dump", "crane", "lainnya"],
      "alat berat": ["excavator", "bulldozer", "wheel loader", "forklift", "skid steer", "grader", "dumper", "lainnya"],
      "peralatan dapur": ["blender", "mikser", "microwave", "lainnya"],
      "peralatan pembersih": ["vacuum cleaner", "sapu", "alat pel", "lainnya"],
      "kost": ["harian", "mingguan", "bulanan", "tahunan", "lainnya"],
      "ruang pertemuan": ["ruang rapat kecil", "ruang konferensi"],
      "ruang seminar dan pelatihan": ["ruang seminar","ruang pelatihan"],
      "tempat event dan pesta": ["gedung pernikahan", "event hall", "kafe dan ruang makan untuk acara"],
      "studio kreatif": ["studio musik", "studio foto/video","studio seni dan lukis", "lainnya"],
      "lahan parkir" : ["parkir kendaraan kecil", "parkir kendaraan besar", "lainnya"],
      "tempat outdoor" : ["lahan camping", "lapangan futsal", "lapangan tenis", "lapangan badminton", "lainnya"]
   };


   if (arr_specific_category[sub_category]) {
      arr_specific_category[sub_category].forEach(sub => {
         const option = document.createElement("option");
         option.value = sub.toLowerCase();
         option.textContent = sub;
         specific_category.appendChild(option);
      });
   } else{
      const option = document.createElement("option");
      option.value = "";
      option.textContent = "Tidak ada kategori spesifik";
      specific_category.appendChild(option);
   }
}
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>
<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['send'])){

   $msg_id = create_unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $message = $_POST['message'];
   $message = filter_var($message, FILTER_SANITIZE_STRING);

   $verify_contact = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $verify_contact->execute([$name, $email, $number, $message]);

   if($verify_contact->rowCount() > 0){
      $warning_msg[] = 'message sent already!';
   }else{
      $send_message = $conn->prepare("INSERT INTO `messages`(id, name, email, number, message) VALUES(?,?,?,?,?)");
      $send_message->execute([$msg_id, $name, $email, $number, $message]);
      $success_msg[] = 'message send successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact Us</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">
      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>
      <form action="" method="post">
         <h3>get in touch</h3>
         <input type="text" name="name" required maxlength="50" placeholder="enter your name" class="box">
         <input type="email" name="email" required maxlength="50" placeholder="enter your email" class="box">
         <input type="number" name="number" required maxlength="13" max="9999999999999" min="080000000000" placeholder="enter your number" class="box">
         <textarea name="message" placeholder="enter your message" required maxlength="1000" cols="30" rows="10" class="box"></textarea>
         <input type="submit" value="send message" name="send" class="btn">
      </form>
   </div>

</section>

<!-- contact section ends -->

<!-- faq section starts  -->

<section class="faq" id="faq">

   <h1 class="heading">FAQ</h1>

   <div class="box-container">

      <div class="box active">
         <h3><span>Apa itu SewaIn?</span><i class="fas fa-angle-down"></i></h3>
         <p>SewaIn adalah platform berbasis web yang menyediakan layanan penyewaan produk dalam tiga kategori: barang, properti, dan kendaraan. Pengguna dapat menyewakan produk mereka kepada orang lain atau menyewa produk yang tersedia di platform ini dengan mudah.</p>
      </div>

      <div class="box active">
         <h3><span>Bagaimana cara mendaftar di SewaIn?</span><i class="fas fa-angle-down"></i></h3>
         <p>Untuk mendaftar di SewaIn, Anda perlu:
            <li>1. Klik tombol Sign Up di halaman utama.</li>
            <li>2. Isi informasi pendaftaran, seperti nama, email, dan kata sandi.</li>
            <li>3. Verifikasi akun melalui email yang dikirimkan.</li>
            <li>4. Setelah verifikasi, Anda dapat masuk ke akun dan mulai menggunakan fitur SewaIn.</li>
         </p>
      </div>

      <div class="box">
         <h3><span>Bagaimana cara menyewakan produk di SewaIn?</span><i class="fas fa-angle-down"></i></h3>
         <p>Untuk menyewakan produk Anda:
            <li>1. Masuk ke akun SewaIn Anda.</li>
            <li>2. Klik menu SewaIn Produk.</li>
            <li>3. Isi informasi produk, seperti nama, harga, lokasi, kategori, deskripsi, dan tambahkan foto.</li>
            <li>4. Setelah semua informasi lengkap, klik tombol Post Produk.</li>
            <li>5. Produk Anda akan muncul di platform SewaIn dan siap disewa oleh pengguna lain.</li>
         </p>
      </div>

      <div class="box">
         <h3><span>Bagaimana cara menyewa produk di SewaIn?</span><i class="fas fa-angle-down"></i></h3>
         <p>Untuk menyewa produk:
            <li>1. Cari produk yang Anda butuhkan menggunakan fitur filter search.</li>
            <li>2. Klik 'Lihat Produk' untuk melihat detailnya.</li>
            <li>3. Hubungi lessor dengan klik 'Hubungi Lessor' atau melalui nomor yang sudah tertera untuk mengatur proses penyewaan.</li>
            <li>4. Diskusikan harga, durasi sewa, dan pengambilan atau pengiriman produk langsung dengan pemilik.</li>
         </p>
      </div>

      <div class="box">
         <h3><span>Apakah pembayaran dilakukan melalui platform SewaIn?</span><i class="fas fa-angle-down"></i></h3>
         <p>Tidak, SewaIn tidak menyediakan layanan pembayaran langsung di platform. Semua pembayaran dan kesepakatan dilakukan secara langsung antara penyewa dan pemilik produk. Platform ini hanya memfasilitasi penyewaan melalui fitur pencarian dan komunikasi.</p>
      </div>

      <div class="box">
         <h3><span>Bagaimana cara menghubungi pemilik produk?</span><i class="fas fa-angle-down"></i></h3>
         <p>Anda dapat menghubungi pemilik produk dengan klik 'Hubungi Lessor' atau melalui nomor pemilik yang tersedia di halaman detail produk. Fitur ini memungkinkan Anda untuk berdiskusi langsung dengan pemilik mengenai harga, durasi sewa, dan rincian lainnya.
            Jika ada pertanyaan lain, silakan hubungi tim dukungan kami melalui halaman Contact Us!
         </p>
      </div>

   </div>

</section>

<!-- faq section ends -->










<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<?php include 'components/message.php'; ?>

</body>
</html>
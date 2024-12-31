<?php  

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

require 'vendor/autoload.php';
use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$subscriptionKey = $_ENV['AZURE_SUBSCRIPTION_KEY'];
$endpoint = 'https://tagproduk.cognitiveservices.azure.com/vision/v3.2/analyze';
$visualFeatures = 'Categories,Tags,Objects';

$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

$detectedCategory = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($_FILES['image']['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
            try {
                $client = new Client();
                $response = $client->post($endpoint, [
                    'headers' => [
                        'Ocp-Apim-Subscription-Key' => $subscriptionKey,
                        'Content-Type' => 'application/octet-stream',
                    ],
                    'query' => [
                        'visualFeatures' => $visualFeatures,
                    ],
                    'body' => fopen($filePath, 'r'),
                ]);

                $result = json_decode($response->getBody(), true);

                $categories = $result['categories'] ?? [];
                $tags = $result['tags'] ?? [];
                $objects = $result['objects'] ?? [];

                // Mapping ke tiga kategori utama
                $categoryMapping = [
                    'kendaraan' => ['car', 'motorcycle', 'vehicle', 'bike', 'truck'],
                    'barang' => ['furniture', 'tool', 'device', 'gadget'],
                    'tempat' => ['outdoor', 'room', 'building', 'landscape', 'park'],
                ];

                $detectedCategory = 'Tidak Diketahui';

                // Prioritas 1: Categories
                foreach ($categories as $cat) {
                    foreach ($categoryMapping as $key => $keywords) {
                        if (in_array($cat['name'], $keywords) && $cat['score'] > 0.5) {
                            $detectedCategory = $key;
                            break 2;
                        }
                    }
                }

                // Prioritas 2: Tags
                if ($detectedCategory === 'Tidak Diketahui') {
                    foreach ($tags as $tag) {
                        foreach ($categoryMapping as $key => $keywords) {
                            if (in_array($tag['name'], $keywords) && $tag['confidence'] > 0.5) {
                                $detectedCategory = $key;
                                break 2;
                            }
                        }
                    }
                }

                // Prioritas 3: Objects
                if ($detectedCategory === 'Tidak Diketahui') {
                    foreach ($objects as $obj) {
                        foreach ($categoryMapping as $key => $keywords) {
                            if (in_array($obj['object'], $keywords) && $obj['confidence'] > 0.5) {
                                $detectedCategory = $key;
                                break 2;
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                echo '<p>Error: ' . $e->getMessage() . '</p>';
            }
        }
    }
}

$query = "SELECT * FROM `product` WHERE 1=1";
$params = [];

if (!empty($detectedCategory)) {
    $query .= " AND type = ?";
    $params[] = $detectedCategory;
}

$query .= " ORDER BY date DESC";
$select_properties = $conn->prepare($query);
$select_properties->execute($params);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search by Image</title>

   <!-- font awesome cdn link -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<!-- search image section starts -->

<section class="filters" style="padding-bottom: 0;">
   <form action="" method="post" enctype="multipart/form-data">
      <h3>Upload Gambar untuk Pencarian</h3>
      <input type="file" name="image" accept="image/*" class="input" required>
      <input type="submit" value="Cari dengan Gambar" class="btn">
   </form>
</section>

<!-- search image section ends -->

<!-- listings section starts -->
<section class="listings">

   <?php 
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         echo '<h1 class="heading">Hasil Pencarian</h1>';
      } else {
         echo '<h1 class="heading">Listing Terbaru</h1>';
      }
   ?>

   <div class="box-container">
      <?php
         if ($select_properties->rowCount() > 0) {
            while ($fetch_product = $select_properties->fetch(PDO::FETCH_ASSOC)) {
               $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_user->execute([$fetch_product['user_id']]);
               $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);
      ?>
      <form action="" method="POST">
         <div class="box">
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
            <div class="price"><i class="fas fa-rupiah-sign"></i><span><?= $fetch_product['price']; ?></span></div>
            <h3 class="name"><?= $fetch_product['product_name']; ?></h3>
            <p class="location"><i class="fas fa-map-marker-alt"></i><span><?= $fetch_product['address']; ?></span></p>
            <a href="view_product.php?get_id=<?= $fetch_product['id']; ?>" class="btn">Lihat Produk</a>
         </div>
      </form>
      <?php
         }
      } else {
         echo '<p class="empty">Tidak ada hasil ditemukan!</p>';
      }
      ?>
   </div>

</section>
<!-- listings section ends -->

<?php include 'components/footer.php'; ?>

<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>

<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

include 'components/save_send.php';

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
$message = '';

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

                $detectedCategory = 'barang'; // Default ke barang jika tidak terdeteksi kendaraan atau tempat

                // Prioritas 1: Categories
                foreach ($categories as $cat) {
                    foreach (['kendaraan', 'tempat'] as $key) {
                        if (in_array($cat['name'], $categoryMapping[$key]) && $cat['score'] > 0.5) {
                            $detectedCategory = $key;
                            break 2;
                        }
                    }
                }

                // Prioritas 2: Tags
                if ($detectedCategory === 'barang') {
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
                if ($detectedCategory === 'barang') {
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

$query = "SELECT * FROM product WHERE 1=1";
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

    <!-- sweetalert cdn link -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- show messages -->
<?php if ($message === 'success'): ?>
<script>
    setTimeout(() => {
        swal({
            title: "Success!",
            text: "Request sent successfully!",
            icon: "success",
            button: "OK"
        });
    }, 100);
</script>
<?php elseif ($message === 'already'): ?>
<script>
    setTimeout(() => {
        swal({
            title: "Oops!",
            text: "Request sent already!",
            icon: "warning",
            button: "OK"
        });
    }, 100);
</script>
<?php endif; ?>

<!-- search image section starts -->

<section class="filters" style="padding-bottom: 0; text-align: center;">
    <form action="" method="post" enctype="multipart/form-data" style="display: inline-block; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background-color: #faf3e0;">
        <h3 style="margin-bottom: 20px; font-size: 24px;">Upload Gambar untuk Pencarian</h3>
        <div style="margin-bottom: 20px;">
            <label id="image-label" for="image-upload" style="display: inline-block; cursor: pointer; padding: 10px 20px; border: 2px dashed #ccc; border-radius: 8px; background-color: #fff;">
                <i class="fas fa-upload"></i> Pilih Gambar
            </label>
            <input id="image-upload" type="file" name="image" accept="image/*" style="display: none;">
        </div>
        <input type="hidden" name="filter_search" value="1">
        <button type="submit" class="btn" id="search-btn" style="padding: 10px 20px; font-size: 16px; background-color: #b71c1c; color: #fff; border: none; border-radius: 5px; display: block; margin: 0 auto;" disabled>Cari</button>
    </form>
</section>

<script>
// Update the label with the selected file name and enable the search button
const imageInput = document.getElementById('image-upload');
const imageLabel = document.getElementById('image-label');
const searchBtn = document.getElementById('search-btn');

imageInput.addEventListener('change', function() {
    if (this.files && this.files.length > 0) {
        imageLabel.textContent = this.files[0].name;
        searchBtn.disabled = false;
    } else {
        imageLabel.textContent = "Pilih Gambar";
        searchBtn.disabled = true;
    }
});
</script>

<!-- search image section ends -->

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link -->
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

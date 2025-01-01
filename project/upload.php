<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$subscriptionKey = $_ENV['AZURE_SUBSCRIPTION_KEY'];
$endpoint = $_ENV['AZURE_ENDPOINT'];
$visualFeatures = 'Categories,Tags,Objects';

$uploadDir = 'uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
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

                // Kategori Mapping
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

                // Cek Categories
                foreach ($categories as $cat) {
                    foreach ($categoryMapping as $key => $keywords) {
                        if (in_array($cat['name'], $keywords) && $cat['score'] > 0.5) {
                            $detectedCategory = $key;
                            break 2; // Keluar dari dua loop
                        }
                    }
                }

                // Cek Tags jika kategori belum ditemukan
                if ($detectedCategory === 'Tidak Diketahui') {
                    foreach ($tags as $tag) {
                        foreach ($categoryMapping as $key => $keywords) {
                            if (in_array($tag['name'], $keywords) && $tag['confidence'] > 0.5) {
                                $detectedCategory = $key;
                                break 2; // Keluar dari dua loop
                            }
                        }
                    }
                }

                // Cek Objects jika kategori masih belum ditemukan
                if ($detectedCategory === 'Tidak Diketahui') {
                    foreach ($objects as $obj) {
                        foreach ($categoryMapping as $key => $keywords) {
                            if (in_array($obj['object'], $keywords) && $obj['confidence'] > 0.5) {
                                $detectedCategory = $key;
                                break 2; // Keluar dari dua loop
                            }
                        }
                    }
                }

                // Tampilkan hasil
                echo '<h2>Hasil Analisis</h2>';
                echo '<p>Kategori Terdeteksi: ' . ucfirst($detectedCategory) . '</p>';
                echo '<h3>Detail:</h3>';
                echo '<pre>' . json_encode($result, JSON_PRETTY_PRINT) . '</pre>';
            } catch (Exception $e) {
                echo '<p>Error: ' . $e->getMessage() . '</p>';
            }
        } else {
            echo '<p>Error uploading file.</p>';
        }
    } else {
        echo '<p>No file uploaded or file upload error.</p>';
    }
} else {
    echo '<p>Invalid request.</p>';
}
?>

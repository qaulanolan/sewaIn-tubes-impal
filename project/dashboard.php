<?php  
include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
   header('location:login.php');
   exit();
}

// Initialize $fetch_profile to prevent undefined variable warning
$fetch_profile = null;

// Fetch user profile
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ? LIMIT 1");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

// Handle profile picture upload
if(isset($_POST['upload_profile_pic']) && $fetch_profile) {
   $old_image = $fetch_profile['profile_pic'] ?? '';
   
   if(isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
      $image = $_FILES['profile_pic']['name'];
      $image_tmp_name = $_FILES['profile_pic']['tmp_name'];
      $image_folder = 'uploaded_images/';

      // Ensure the upload directory exists
      if (!file_exists($image_folder)) {
         mkdir($image_folder, 0777, true);
      }

      $image_size = $_FILES['profile_pic']['size'];

      if($image_size > 2000000){
         $message[] = 'Image size is too large!';
      } else {
         $update_image = $conn->prepare("UPDATE `users` SET profile_pic = ? WHERE id = ?");
         $image_path = uniqid() . '_' . $image;
         
         if(move_uploaded_file($image_tmp_name, $image_folder . $image_path)) {
            $update_image->execute([$image_path, $user_id]);
            
            // Remove old image if it exists
            if(!empty($old_image) && file_exists($image_folder . $old_image)) {
               unlink($image_folder . $old_image);
            }
            
            // Refresh the profile data
            $select_profile->execute([$user_id]);
            $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         } else {
            $message[] = 'Failed to upload image';
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="dashboard">
   <div class="dashboard-container">
      <?php if($fetch_profile): ?>
         <div class="profile-section">
            <div class="profile-header">
               <div class="profile-image-container">
                  <form action="" method="post" enctype="multipart/form-data" class="profile-pic-form">
                     <input type="file" name="profile_pic" id="profile_pic" accept="image/*" class="hidden-input">
                     <label for="profile_pic" class="profile-image-wrapper">
                        <?php 
                        $profile_pic = !empty($fetch_profile['profile_pic']) 
                           ? 'uploaded_images/' . $fetch_profile['profile_pic'] 
                           : 'images/default-avatar.png'; 
                        ?>
                        <img src="<?= htmlspecialchars($profile_pic); ?>" alt="Profile Picture" class="profile-image">
                        <div class="edit-overlay">
                           <i class="fas fa-camera"></i>
                        </div>
                     </label>
                     <input type="submit" name="upload_profile_pic" value="Upload" class="hidden-submit">
                  </form>
               </div>
               <div class="profile-info">
                  <h2><?= htmlspecialchars($fetch_profile['name']); ?></h2>
                  <p><?= htmlspecialchars($fetch_profile['email']); ?></p>
               </div>
            </div>

            <div class="dashboard-stats">
               <div class="stat-card">
                  <div class="stat-icon"><i class="fas fa-home"></i></div>
                  <div class="stat-content">
                     <?php
                     $count_properties = $conn->prepare("SELECT * FROM `product` WHERE user_id = ?");
                     $count_properties->execute([$user_id]);
                     $total_properties = $count_properties->rowCount();
                     ?>
                     <h3><?= $total_properties; ?></h3>
                     <p>Products Listed</p>
                  </div>
                  <a href="my_listings.php" class="stat-link">View Listings</a>
               </div>

               <div class="stat-card">
                  <div class="stat-icon"><i class="fas fa-envelope"></i></div>
                  <div class="stat-content">
                     <?php
                     $count_requests_received = $conn->prepare("SELECT * FROM `requests` WHERE receiver = ?");
                     $count_requests_received->execute([$user_id]);
                     $total_requests_received = $count_requests_received->rowCount();
                     ?>
                     <h3><?= $total_requests_received; ?></h3>
                     <p>Requests Received</p>
                  </div>
                  <a href="requests.php" class="stat-link">View Requests</a>
               </div>

               <div class="stat-card">
                  <div class="stat-icon"><i class="fas fa-heart"></i></div>
                  <div class="stat-content">
                     <?php
                     $count_saved_properties = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
                     $count_saved_properties->execute([$user_id]);
                     $total_saved_properties = $count_saved_properties->rowCount();
                     ?>
                     <h3><?= $total_saved_properties; ?></h3>
                     <p>Saved Products</p>
                  </div>
                  <a href="saved.php" class="stat-link">View Saved</a>
               </div>
            </div>

            <div class="profile-actions">
               <a href="update.php" class="btn btn-primary">
                  <i class="fas fa-edit"></i> Update Profile
               </a>
            </div>
         </div>
      <?php else: ?>
         <div class="error-message">
            <p>User profile not found. Please login again.</p>
         </div>
      <?php endif; ?>
   </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<?php include 'components/footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
   const profilePicInput = document.getElementById('profile_pic');
   const profilePicForm = document.querySelector('.profile-pic-form');
   
   profilePicInput.addEventListener('change', function() {
      profilePicForm.querySelector('.hidden-submit').click();
   });
});
</script>

<?php include 'components/message.php'; ?>
</body>
</html>
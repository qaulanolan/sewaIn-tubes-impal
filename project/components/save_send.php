<?php

if(isset($_POST['save'])){
   if($user_id != ''){

      $save_id = create_unique_id();
      $product_id = $_POST['product_id'];
      $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

      $verify_saved = $conn->prepare("SELECT * FROM `saved` WHERE product_id = ? and user_id = ?");
      $verify_saved->execute([$product_id, $user_id]);

      if($verify_saved->rowCount() > 0){
         $remove_saved = $conn->prepare("DELETE FROM `saved` WHERE product_id = ? AND user_id = ?");
         $remove_saved->execute([$product_id, $user_id]);
         $success_msg[] = 'removed from saved!';
      }else{
         $insert_saved = $conn->prepare("INSERT INTO`saved`(id, product_id, user_id) VALUES(?,?,?)");
         $insert_saved->execute([$save_id, $product_id, $user_id]);
         $success_msg[] = 'listing saved!';
      }

   }else{
      $warning_msg[] = 'please login first!';
   }
}

if(isset($_POST['send'])){
   if($user_id != ''){

      $request_id = create_unique_id();
      $product_id = $_POST['product_id'];
      $product_id = filter_var($product_id, FILTER_SANITIZE_STRING);

      $select_receiver = $conn->prepare("SELECT user_id FROM `product` WHERE id = ? LIMIT 1");
      $select_receiver->execute([$product_id]);
      $fetch_receiver = $select_receiver->fetch(PDO::FETCH_ASSOC);
      $receiver = $fetch_receiver['user_id'];

      $verify_request = $conn->prepare("SELECT * FROM `requests` WHERE product_id = ? AND sender = ? AND receiver = ?");
      $verify_request->execute([$product_id, $user_id, $receiver]);

      if(($verify_request->rowCount() > 0)){
         $warning_msg[] = 'request sent already!';
      }else{
         $send_request = $conn->prepare("INSERT INTO `requests`(id, product_id, sender, receiver) VALUES(?,?,?,?)");
         $send_request->execute([$request_id, $product_id, $user_id, $receiver]);
         $success_msg[] = 'request sent successfully!';
      }

   }else{
      $warning_msg[] = 'please login first!';
   }
}

?>
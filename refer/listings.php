<?php

include '../components/connect.php';

if (isset($_COOKIE['admin_id'])) {
   $admin_id = $_COOKIE['admin_id'];
} else {
   $admin_id = '';
   header('location:login.php');
}

if (isset($_POST['delete'])) {

   $delete_id = $_POST['delete_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_delete = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
   $verify_delete->execute([$delete_id]);

   if ($verify_delete->rowCount() > 0) {
      $select_images = $conn->prepare("SELECT * FROM `property` WHERE id = ?");
      $select_images->execute([$delete_id]);
      while ($fetch_images = $select_images->fetch(PDO::FETCH_ASSOC)) {
         $image_01 = $fetch_images['image_01'];
         $image_02 = $fetch_images['image_02'];
         $image_03 = $fetch_images['image_03'];
         $image_04 = $fetch_images['image_04'];
         $image_05 = $fetch_images['image_05'];
         unlink('../uploaded_files/' . $image_01);
         if (!empty($image_02)) {
            unlink('../uploaded_files/' . $image_02);
         }
         if (!empty($image_03)) {
            unlink('../uploaded_files/' . $image_03);
         }
         if (!empty($image_04)) {
            unlink('../uploaded_files/' . $image_04);
         }
         if (!empty($image_05)) {
            unlink('../uploaded_files/' . $image_05);
         }
      }
      $delete_listings = $conn->prepare("DELETE FROM `property` WHERE id = ?");
      $delete_listings->execute([$delete_id]);
      $success_msg[] = 'Listing deleted!';
   } else {
      $warning_msg[] = 'Listing deleted already!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Listings</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">



</head>

<body>

   <!-- header section starts  -->
   <?php include '../components/admin_header.php'; ?>
   <!-- header section ends -->

   <section class="listings">

      <h1 class="heading">all listings</h1>

      <div class="box-container">
         <?php
         $total_images = 0;
         $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC");
         $select_properties->execute();
         if ($select_properties->rowCount() > 0) {
            while ($fetch_property = $select_properties->fetch(PDO::FETCH_ASSOC)) {

               $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_user->execute([$fetch_property['user_id']]);
               $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

               if (!empty($fetch_property['image_02'])) {
                  $image_coutn_02 = 1;
               } else {
                  $image_coutn_02 = 0;
               }
               if (!empty($fetch_property['image_03'])) {
                  $image_coutn_03 = 1;
               } else {
                  $image_coutn_03 = 0;
               }
               if (!empty($fetch_property['image_04'])) {
                  $image_coutn_04 = 1;
               } else {
                  $image_coutn_04 = 0;
               }
               if (!empty($fetch_property['image_05'])) {
                  $image_coutn_05 = 1;
               } else {
                  $image_coutn_05 = 0;
               }

               $total_images = (1 + $image_coutn_02 + $image_coutn_03 + $image_coutn_04 + $image_coutn_05);

               ?>
               <form action="" method="POST">
                  <div class="box">
                     <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">

                     <div class="thumb">
                        <p class="total-images"><i class="far fa-image"></i><span>
                              <?= $total_images; ?>
                           </span></p>

                        <img src="../uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
                     </div>
                     <div class="admin">
                        <?php if (isset($fetch_user['name'])): ?>
                           <h3>
                              <?php echo $fetch_user['name']; ?>
                           </h3>
                           <div>
                              <p>
                                 <?php echo $fetch_user['name']; ?>
                              </p>
                              <span>
                                 <?= $fetch_property['date']; ?>
                              </span>
                           </div>
                        <?php endif; ?>
                     </div>
                  </div>
                  <div class="box">
                     <div class="price"><i class="fas fa-indian-rupee-sign"></i><span>
                           <?= $fetch_property['price']; ?>
                        </span></div>
                     <h3 class="name">
                        <?= $fetch_property['property_name']; ?>
                     </h3>
                     <p class="location"><i class="fas fa-map-marker-alt"></i><span>
                           <?= $fetch_property['address']; ?>
                        </span></p>
                     <div class="flex">
                        <p><i class="fas fa-house"></i><span>
                              <?= $fetch_property['type']; ?>
                           </span></p>
                        <p><i class="fas fa-tag"></i><span>
                              <?= $fetch_property['offer']; ?>
                           </span></p>
                        <p><i class="fas fa-bed"></i><span>
                              <?= $fetch_property['bhk']; ?> BHK
                           </span></p>
                        <p><i class="fas fa-trowel"></i><span>
                              <?= $fetch_property['status']; ?>
                           </span></p>
                        <p><i class="fas fa-couch"></i><span>
                              <?= $fetch_property['furnished']; ?>
                           </span></p>
                        <p><i class="fas fa-maximize"></i><span>
                              <?= $fetch_property['carpet']; ?>sqft
                           </span></p>
                     </div>

                     <div class="flex-btn">
                        <a href="update_property.php?get_id=<?= $property_id; ?>" class="btn">update</a>
                        <input type="submit" name="delete" value="delete" class="btn"
                           onclick="return confirm('delete this listing?');">
                     </div>

                  </div>

               </form>
               <?php
            }
         } else {
            echo '<p class="empty">no properties added yet! <a href="post_property.php" style="margin-top:1.5rem;" class="btn">add new</a></p>';
         }
         ?>


      </div>
      <div class="flex-btn">
         <a href="../admin/post_property.php" class="btn">Add new property</a>
      </div>

   </section>



















   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <!-- custom js file link  -->
   <script src="../js/admin_script.js"></script>

   <?php include '../components/message.php'; ?>

</body>

</html>
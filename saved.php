<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
   header('location:login.php');
}

include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>saved</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="listings">

      <h1 class="heading">saved listings</h1>

      <div class="box-container">
         <?php
         $total_images = 0;
         $select_saved_property = $conn->prepare("SELECT * FROM `saved` WHERE user_id = ?");
         $select_saved_property->execute([$user_id]);
         if ($select_saved_property->rowCount() > 0) {
            while ($fetch_saved = $select_saved_property->fetch(PDO::FETCH_ASSOC)) {
               $select_properties = $conn->prepare("SELECT * FROM `property` WHERE id = ? ORDER BY date DESC");
               $select_properties->execute([$fetch_saved['property_id']]);
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

                     $select_saved = $conn->prepare("SELECT * FROM `saved` WHERE property_id = ? and user_id = ?");
                     $select_saved->execute([$fetch_property['id'], $user_id]);

                     ?>
                     <form action="" method="POST">
                        <div class="box">
                           <input type="hidden" name="property_id" value="<?= $fetch_property['id']; ?>">
                           
                           <div class="thumb">
                              <p class="total-images"><i class="far fa-image"></i><span>
                                    <?= $total_images; ?>
                                 </span></p>
                              <img src="uploaded_files/<?= $fetch_property['image_01']; ?>" alt="">
                           </div>
                           <div class="admin">
                              
                                 <span>
                                    <?= $fetch_property['date']; ?>
                                 </span>
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

                           <!-- css for above flex  -->
                           <style>
                              .box .flex {
                                 display: flex;
                                 flex-wrap: wrap;
                                 justify-content: space-between;
                                 align-items: center;
                                 margin: 10px;
                              }

                              .flex p {
                                 width: 45%;
                                 padding: 10px;
                                 border: 2px solid #333;
                                 border-radius: 10px;
                                 box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.3);
                              }

                              .flex p span {
                                 font-weight: bold;
                              }

                              .flex p i {
                                 margin-right: 5px;
                              }

                              .flex p:hover {
                                 transform: scale(1.1);
                                 transition: all 0.3s ease-in-out;
                              }
                           </style>
                           <div class="flex-btn">
                              <a href="view_property.php?get_id=<?= $fetch_property['id']; ?>" class="btn">view property</a>
                              <input type="submit" value="send enquiry" name="send" class="btn">
                           </div>
                           <?php
                           if ($select_saved->rowCount() > 0) {
                              ?>
                              <button type="submit" name="save" class="btn"><i class="fas fa-heart"></i><span>remove from
                                    saved</span></button>
                              <?php
                           } else {
                              ?>
                              <button type="submit" name="save" class="btn"><i class="far fa-heart"></i><span>save</span></button>
                              <?php
                           }
                           ?>
                        </div>
                     </form>
                     <?php
                  }
               }
            }
         } else {
            echo '<p class="empty">no properties saved yet! <a href="listings.php" style="margin-top:1.5rem;" class="btn">discover more</a></p>';
         }
         ?>

      </div>

   </section>


   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>



   <!-- custom js file link  -->
   <script src="js/script.js"></script>
   <?php include 'components/message.php'; ?>


</body>
<?php include 'components/footer.php'; ?>

</html>







<style>
   .listings .box-container .box {
      border-radius: .5rem;
      background-color: var(--white);
      box-shadow: var(--box-shadow);
      border: var(--border);
      padding: 2rem;
      overflow-x: hidden;
   }


   .listings .box-container .box .thumb {
      position: relative;
      height: 20rem;
      margin-bottom: 1.5rem;
   }

   .listings .box-container .box .thumb p {
      position: absolute;
      top: 1rem;
      left: 1rem;
      background-color: rgba(0, 0, 0, .5);
      color: var(--white);
      border-radius: .5rem;
      padding: .7rem 1rem;
      font-size: 1.8rem;
   }

   .listings .box-container .box .thumb p i {
      margin-right: 1rem
   }

   .listings .box-container .box .thumb img {
      height: 100%;
      width: 100%;
      object-fit: cover;
      border-radius: .5rem;
   }

   .listings .box-container .box .price {
      font-size: 1.8rem;
      color: var(--red);
   }

   .listings .box-container .box .price i {
      margin-right: .8rem;
   }

   .listings .box-container .box .name {
      font-size: 2rem;
      color: var(--black);
      padding: .7rem 0;
      text-overflow: ellipsis;
   }

   .listings .box-container .box .location {
      color: var(--light-color);
      font-size: 1.7rem;
      padding: .5rem 0;
      text-overflow: ellipsis;
   }

   .listings .box-container .box .location i {
      margin-right: 1rem;
      color: var(--red);
   }

   .view-property .details {
      background-color: var(--white);
      box-shadow: var(--box-shadow);
      border: var(--border);
      padding: 2rem;
      border-radius: .5rem;
      overflow-x: hidden;
   }

   .view-property .details .images-container img {
      height: 40rem;
      object-fit: cover;
      width: 60rem;
      margin-bottom: 3rem;
   }

   .swiper-pagination-bullets.swiper-pagination-horizontal {
      bottom: 0;
   }

   .swiper-pagination-bullet {
      background-color: var(--black);
   }

   .swiper-pagination-bullet-active {
      background-color: var(--main-color);
   }

   .view-property .details .name {
      font-size: 2rem;
      text-overflow: ellipsis;
      overflow-x: hidden;
      margin-bottom: .5rem;
      padding-top: 1rem;
   }

   .view-property .details .location {
      padding-top: 1rem;
      font-size: 1.6rem;
      color: var(--light-color);
   }

   .view-property .details .location i {
      margin-right: 1rem;
      color: var(--red);
   }

   .view-property .details .info {
      display: flex;
      background-color: var(--light-bg);
      padding: 1.5rem;
      margin: 1.5rem 0;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      gap: 2rem;
      border-radius: .5rem;
   }

   .view-property .details .info p {
      font-size: 1.7rem;
   }

   .view-property .details .info p span,
   .view-property .details .info p a {
      color: var(--light-color);
   }

   .view-property .details .info p a:hover {
      text-decoration: underline;
   }

   .view-property .details .info p i {
      margin-right: 1.5rem;
      color: var(--main-color);
   }

   .view-property .details .title {
      font-size: 2rem;
      color: var(--black);
      padding-bottom: 1.5rem;
      border-bottom: var(--border);
   }

   .view-property .details .flex {
      margin: 1.5rem 0;
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap;
   }

   .view-property .details .flex .box {
      flex: 1 1 40rem;
   }

   .view-property .details .flex .box p {
      padding: .5rem 0;
      font-size: 1.6rem;
      color: var(--light-color);
   }

   .view-property .details .flex .box i {
      color: var(--main-color);
      margin-right: 1.5rem;
   }

   .view-property .details .flex .box .fa-times {
      color: var(--red);
   }

   .view-property .details .description {
      padding-top: 1rem;
      margin: .5rem 0;
      margin-top: .5rem;
      font-size: 1.6rem;
      color: var(--light-color);
      line-height: 2;
   }

   .view-property .details .save {
      width: 100%;
      background-color: var(--light-bg);
      cursor: pointer;
      padding: 1rem 3rem;
      font-size: 1.8rem;
      color: var(--light-color);
   }

   .view-property .details .save:hover {
      background-color: var(--main-color);
      color: var(--white);
   }

   .view-property .details .save i {
      margin-right: 1rem;
      color: var(--black);
   }

   .view-property .details .save:hover i {
      color: var(--white);
   }
</style>
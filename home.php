<?php

include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
   $user_id = $_COOKIE['user_id'];
} else {
   $user_id = '';
}

include 'components/save_send.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>


   <!-- home section starts  -->

   <div class="home">

   <div class="grid-container">
    <div class="intro-section">
        <div class="intro-text">
            <h1>Welcome to RentHome Hub 🏠</h1>
            <br>
            <p>🏡 Finding your dream home has never been easier! RentHome Hub is your ultimate destination for seamless
                home rentals. Whether you're looking for an apartment, villa, or townhouse, we've got a wide range of
                rental options to suit your needs and preferences. Discover comfortable living spaces in prime
                locations, backed by our dedicated team to ensure a hassle-free experience. Your perfect home is just a
                click away! 💼</p>
            <br><br>
            <a href="home.php#listings" class="cta-button" style="text-decoration:none; color: white;">Browse Listings</a>
        </div>
    </div>

    <div class="image">
        <img src="images/introbg.jpg" alt="Home Rental">
    </div>
</div>
   </div>

<style>
   /* intro */
   :root{
   --primary: var(--main-color);
  --secondary: var(--light-color);}

.grid-container {
  display: grid;
  grid-template-columns: .5fr .5fr;
  gap: 20px;
  align-items: center;
  padding: 40px;
  margin: 40px;
}

.intro-section {
  padding-left: 40px;
  padding-right: 40px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
border: 1px solid white;
  padding-top: 60px;
  padding-bottom: 60px;
}

.intro-text {
  color: white;
  opacity: 0;
  font-size: 15px;
  transform: translateX(-20px);
  animation: slide-fade 1s forwards;
}

@keyframes slide-fade {
  to {
    opacity: 1;
    transform: translateX(0);
  }
}

.cta-button {
  background-color: var(--primary);
  color: var(--secondary);
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.cta-button:hover {
  background-color: #0b2154;
}

.image img {
  max-width: 100%;
  height: auto;
  border-radius: 10px;
  animation: slide-out 1s ease-out;
}

.about-image img {
  animation: slide-in 1s ease-out;
}

@keyframes slide-in {
  0% {
    transform: translateX(-100%);
  }
  100% {
    transform: translateX(0);
  }
}

@keyframes slide-out {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(0);
  }
}
/* intro end */
</style>

   <!-- home section ends -->

   <!-- services section starts  -->

   <section class="services">

      <h1 class="heading">our services</h1>

      <div class="box-container">

         <div class="box">
            <img src="images/icon-1.png" alt="">
            <h3>buy house</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
         </div>

         <div class="box">
            <img src="images/icon-2.png" alt="">
            <h3>rent house</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
         </div>

         <div class="box">
            <img src="images/icon-3.png" alt="">
            <h3>sell house</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
         </div>

         <div class="box">
            <img src="images/icon-4.png" alt="">
            <h3>flats and buildings</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
         </div>

         <div class="box">
            <img src="images/icon-5.png" alt="">
            <h3>shops and malls</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
         </div>

         <div class="box">
            <img src="images/icon-6.png" alt="">
            <h3>24/7 service</h3>
            <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Doloremque, incidunt.</p>
         </div>

      </div>

   </section>

   <!-- services section ends -->

   <!-- listings section starts  -->

   <section id="listings" class="listings">

      <h1 class="heading">latest listings</h1>

      <div class="box-container">
         <?php
         $total_images = 0;
         $select_properties = $conn->prepare("SELECT * FROM `property` ORDER BY date DESC LIMIT 6");
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
                  </div>
               </form>
               <?php
            }
         }
         ?>

      </div>

      <div style="margin-top: 2rem; text-align:center;">
         <a href="listings.php" class="inline-btn">view all</a>
      </div>

   </section>

   <!-- listings section ends -->








   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

   <?php include 'components/footer.php'; ?>

   <!-- custom js file link  -->
   <script src="js/script.js"></script>

   <?php include 'components/message.php'; ?>

   <script>

      let range = document.querySelector("#range");
      range.oninput = () => {
         document.querySelector('#output').innerHTML = range.value;
      }

   </script>

</body>

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
</style>
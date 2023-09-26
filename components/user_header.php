<!-- header section starts  -->

<header class="header">

   <nav class="navbar nav-1">
      <section class="flex">
         <a href="home.php" class="logo"><i class="fas fa-house"></i>MyHome</a>

      </section>
   </nav>

   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>

         <div class="menu">
            <ul>
               <li><a href="home.php">Home</a>
               <li><a href="about.php">About Us</a></i></li>
               <li><a href="contact.php">Contact us</a></i></li>
               <li><a href="contact.php#faq">FAQ</a></i></li>
            </ul>
         </div>

         <ul>
            <li><a href="saved.php">Saved <i class="far fa-heart"></i></a></li>
            <li><a href="#">Account <i class="fas fa-angle-down"></i></a>
               <ul>
                  <li><a href="login.php">Login</a></li>
                  <li><a href="register.php">Register</a></li>
                  <li><a href="admin/login.php">Admin Login</a></li>
                  <?php if ($user_id != '') { ?>
                     <li><a href="update.php">Update Profile</a></li>
                     <li><a href="components/user_logout.php"
                           onclick="return confirm('logout from this website?');">Logout</a>
                     <?php } ?>
                  </li>
               </ul>
            </li>
         </ul>
      </section>
   </nav>

</header>

<!-- header section ends -->
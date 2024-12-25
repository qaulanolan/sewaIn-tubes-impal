<!-- header section starts  -->

<header class="header">

   <nav class="navbar nav-1">
      
      <section class="flex">
         <a href="home.php"><img src="images/logo.png" alt="logo" class="logo" width="170px"></a>

         <!-- <input type="text" name="" required maxlength="100" placeholder="cari produk" class="input">
         <input type="submit" value="search" name="" class="btn"> -->
         
         <ul>
            <li><a href="post_product.php">sewaIn produk<i class="fas fa-paper-plane"></i></a></li>
         </ul>
      </section>
   </nav>

   <nav class="navbar nav-2">
      <section class="flex">
         <div id="menu-btn" class="fas fa-bars"></div>

         <div class="menu">
            <ul>
               <li><a href="#">profile<i class="fas"></i></a>
                  <ul>
                     <li><a href="dashboard.php">dashboard</a></li>
                     <li><a href="post_product.php">sewaIn produk</a></li>
                     <li><a href="my_listings.php">my listings</a></li>
                  </ul>
               </li>
               <li><a href="#">produk<i class="fas"></i></a>
                  <ul>
                     <li><a href="search.php">filter search</a></li>
                     <li><a href="listings.php">semua produk</a></li>
                  </ul>
               </li>
               <li><a href="#">bantuan<i class="fas"></i></a>
                  <ul>
                     <li><a href="about.php">tentang kami</a></i></li>
                     <li><a href="contact.php">hubungi kami</a></i></li>
                     <li><a href="contact.php#faq">FAQ</a></i></li>
                  </ul>
               </li>
            </ul>
         </div>

         <ul>
            <li><a href="saved.php">saved <i class="far fa-heart"></i></a></li>
            <li><a href="#">account <i class="fas"></i></a>
               <ul>
                  <?php if($user_id == '') { ?>
                  <li><a href="login.php">login</a></li>
                  <li><a href="register.php">register new</a></li>
                  <?php }else{ ?>
                  <li><a href="update.php">update profile</a></li>
                  <li><a href="components/user_logout.php" onclick="return confirm('logout from this website?');">logout</a>
                  <?php } ?></li>
               </ul>
            </li>
         </ul>
      </section>
   </nav>

</header>

<!-- header section ends -->
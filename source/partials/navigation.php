<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!-- navigation -->
<header class="sticky-top bg-white border-bottom border-default">
   <div class="container">

      <nav class="navbar navbar-expand-lg navbar-white">
         <a class="navbar-brand" href="index.html">
            <img class="img-fluid" width="150px" src="../images/logo.png" alt="LogBook">
         </a>
         <button class="navbar-toggler border-0" type="button" data-toggle="collapse" data-target="#navigation">
            <i class="ti-menu"></i>
         </button>

         <div class="collapse navbar-collapse text-center" id="navigation">
            <ul class="navbar-nav ml-auto">
               <li class="nav-item dropdown">
                  <a class="nav-link" href="index.php" role="button"  aria-haspopup="true"
                     aria-expanded="false">
                     home 
                  </a>
                  
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="about.php">About</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="contact.php">Contact</a>
               </li>
               <?php 
                  
                  // Check if user is logged in
                  if (isset($_SESSION['user_id'])): ?>
                     <!-- If user is logged in, show their name and sign-out option -->
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           Welcome, <?php echo $_SESSION['user_name']; ?>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="mydashboard.php">Write</a>
                        <a class="dropdown-item" href="logout.php">Sign Out</a>
                     </div>
                     </li>
                  <?php else: ?>
                     <!-- If user is not logged in, show sign-in option -->
                     <li class="nav-item">
                        <a class="nav-link" href="signin.php">Sign In</a>
                     </li>
                  <?php endif; ?>
            </ul>
            

            <!-- search -->
            <div class="search px-4">
               <button id="searchOpen" class="search-btn"><i class="ti-search"></i></button>
               <div class="search-wrapper">
                  <form action="javascript:void(0)" class="h-100">
                     <input class="search-box pl-4" id="search-query" name="s" type="search" placeholder="Type &amp; Hit Enter...">
                  </form>
                  <button id="searchClose" class="search-close"><i class="ti-close text-dark"></i></button>
               </div>
            </div>

         </div>
      </nav>
   </div>
</header>


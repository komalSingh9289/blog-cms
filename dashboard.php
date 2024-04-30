<?php session_start();
  
  if (!isset($_SESSION['id'])) {     
  header('location: authentication-login.php');
  }
?>

<?php include 'header.php'; ?>

  <body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >
     
      <!-- Topbar header  -->
     
       <?php include 'top-header.php'; ?> 


      <!-- Left Sidebar  -->
      <?php include 'sidebar.php'; ?>

      <div class="page-wrapper">
       
        <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title">Dashboard</h4>
              <div class="ms-auto text-end">
                
              </div>
            </div>
          </div>
        </div>
       
        <div class="container-fluid">
          <div class="row">
            <!-- Column -->
            <div class="col-md-3 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-cyan text-center">
                  <h1 class="font-light text-white">
                    <i class="mdi mdi-account"></i>
                  </h1>
                  <h6 class="text-white">users</h6>
                   <?php
                  require 'connection.php';
                  $stmt = $pdo->prepare("SELECT COUNT(*) as user_count FROM users");
                  $stmt->execute();
                  $user_count = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];
                  ?>
                  <h6 class="text-white"><?php echo $user_count; ?></h6>

                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-4 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-success text-center">
                  <h1 class="font-light text-white">
                    <i class="mdi mdi-file"></i>
                  </h1>
                  <h6 class="text-white">Posts</h6>
                  <?php
                  $stmt = $pdo->prepare("SELECT COUNT(*) as post_count FROM posts");
                  $stmt->execute();
                  $post_count = $stmt->fetch(PDO::FETCH_ASSOC)['post_count'];
                  ?>
                  <h6 class="text-white"><?php echo $post_count; ?></h6>
                </div>
              </div>
            </div>

            <div class="col-md-3 col-lg-3 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-warning text-center">
                  <h1 class="font-light text-white">
                    <i class="mdi mdi-view-list"></i>
                  </h1>
                  <h6 class="text-white">Categories</h6>
                   <?php
                  $stmt = $pdo->prepare("SELECT COUNT(*) as category_count FROM category");
                  $stmt->execute();
                  $category_count = $stmt->fetch(PDO::FETCH_ASSOC)['category_count'];
                  ?>
                  <h6 class="text-white"><?php echo $category_count; ?></h6>

                </div>
              </div>
            </div>


            <div class="col-md-6 col-lg-2 col-xlg-3">
              <div class="card card-hover">
                <div class="box bg-danger text-center">
                  <h1 class="font-light text-white">
                    <i class="mdi mdi-comment"></i>
                  </h1>
                  <h6 class="text-white">Comments</h6>
                   <?php
                  $stmt = $pdo->prepare("SELECT COUNT(*) as comment_count FROM comments");
                  $stmt->execute();
                  $comment_count = $stmt->fetch(PDO::FETCH_ASSOC)['comment_count'];
                  ?>
                  <h6 class="text-white"><?php echo  $comment_count; ?></h6>
                </div>
              </div>
            </div>
          </div>

          <div class="container justify-content-center">
              <canvas id="userChart"></canvas>
          </div>


        <footer class="footer text-center">
          All Rights Reserved by LogBook. 
          
        </footer>
              </div>
      
    </div>

    <?php
// Connect to your database
require 'connection.php';

// Query to fetch user count
$stmt = $pdo->prepare("SELECT COUNT(*) as user_count FROM users");
$stmt->execute();
$user_count = $stmt->fetch(PDO::FETCH_ASSOC)['user_count'];
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>
    // Get the canvas element
    var ctx = document.getElementById('userChart').getContext('2d');
    
    // Define data for the chart
    var data = {
        labels: ["Users"],
        datasets: [{
            label: 'Number of Users',
            data: [<?php echo $user_count; ?>], // Provide the user count retrieved from PHP
            backgroundColor: 'rgba(255, 99, 132, 0.2)', // Bar color
            borderColor: 'rgba(255, 99, 132, 1)', // Border color
            borderWidth: 1
        }]
    };
    
    // Define options for the chart
    var options = {
        scales: {
            y: {
                beginAtZero: true // Start y-axis at 0
            }
        }
    };
    
    // Create the chart
    var userChart = new Chart(ctx, {
        type: 'bar', // Type of chart
        data: data,
        options: options
    });

</script>


<?php include 'footer.php'; ?> 

<?php
    session_start();
   

   include 'header.php';
 ?>

<body>
	<div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>



<div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >

        <?php include 'top-header.php'; ?>
    <?php include 'sidebar.php'; ?>


    <!----------user table------------------>

<div class="page-wrapper vh-100">
    <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title"> Add User</h4>
              <div class="ms-auto text-end">
                
              </div>
            </div>
          </div>
        </div>

        <div class="container-fluid">
    		    <form id="adduserform" class="form-horizontal" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    
                    <div class="form-group row">
                      <label
                        for="name"
                        class="col-sm-3 text-end control-label col-form-label"
                        > Name</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="name"
                          name ="name"
                          placeholder="Full Name Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="email"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Email</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="email"
                          name="email"
                          placeholder="Email address"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="password"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Password</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="password"
                          class="form-control"
                          id="password"
                          name ="password"
                          placeholder="Password Here"
                        />
                      </div>
                    </div>

                    <div class="form-group row">
                      <label
                        for="profile"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Profile Img</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="file"
                          class="form-control"
                          id="img"
                          name ="img"
                          accept="image/*"
                        />
                      </div>
                    </div>

                   
                    <div class="form-group row">
                      <label
                        for="bio"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Bio</label
                      >
                      <div class="col-sm-9">
                        <textarea class="form-control" name="bio"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" id="addUser" name="addUser" class="btn btn-primary">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
        </div>	
    </div>

	
</div>

<!------------form handling------------------->
<?php
// Establish database connection
require 'connection.php';

// Check if form is submitted
if (isset($_POST['addUser'])) {

    // Retrieve form data

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $bio= $_POST['bio'];
    
   

    // File upload handling
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);

    // Prepare SQL statement to insert data
    $sql = "INSERT INTO users (username, profile_img, email,password, bio) VALUES (:username, :profile_img, :email,:password, :bio)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters to statement
    $stmt->bindParam(':username', $name);
    $stmt->bindParam(':profile_img', $target_file);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $hashed_password);
    $stmt->bindParam(':bio', $bio);

    

    // Execute statement
    try {
         $stmt->execute();
        // Check if the execution was successful
        if($stmt->rowCount() > 0) {
            echo "<script> alert('user added successfully.'); window.location.href = 'users.php'; </script>";
            exit(); 
        } else {
            echo "<script> alert('Error: Something went wrong with the execution.'); </script>";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>


<?php include 'footer.php'; ?>

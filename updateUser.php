 
<?php
  include 'header.php'; 
  session_start();

$id = isset($_GET['id']) ? $_GET['id'] : null;

// Check if $id is set
if(isset($id)) {

  require 'connection.php';
   try {
        // Prepare and execute query to fetch post data
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Populate form fields with post data
        $username = $user['username'];
        $email = $user['email'];
        $bio = $user['bio'];
       $image = $user['profile_img'];
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    



} else {
    echo "ID not found in the URL";
}




// update query....................

if (isset($_POST['updateUser'])) {
        $name = $_POST['username'];
        $email = $_POST['email'];
        $bio= $_POST['bio'];

    
   

    // File upload handling
    $target_dir = "../../uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

       try {
            require 'connection.php';
             $sql = "UPDATE users SET username = :name, profile_img = :profile_img, email = :email, bio = :bio WHERE id = :id";
           $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':profile_img', $target_file);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':bio', $bio);
            $stmt->bindParam(':id', $id);

            $stmt->execute();
        // Check if the execution was successful
        if($stmt->rowCount() > 0) {
            echo "<script> alert('user updated successfully.');
                  window.location.href = 'users.php'; </script>  ";
            
        } else {
            echo "<script> alert('Error: Something went wrong with the execution.'); </script>";
        }



       } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



?>

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
                          name ="username"
                           value = "<?php echo $username; ?> "
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
                           value = "<?php echo $email; ?> "
                          placeholder="Email address"
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
                          name ="image"
                           value = "<?php echo $target_file; ?> "
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
                        <textarea class="form-control" name="bio"><?php echo $bio; ?></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" id="updateUser" name="updateUser" class="btn btn-primary">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
      </div>
     








<?php include 'connection.php'?>
<?php
try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $name = isset($_POST['name']) ? $_POST['name'] : '';
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : '';
$role = isset($_POST['role']) ? $_POST['role'] : '';
$bio = isset($_POST['bio']) ? $_POST['bio'] : '';

// Handle file upload
$profile_img = '';
if(isset($_FILES["img"]) && $_FILES["img"]["error"] == 0) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["img"]["name"]);
    if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
        $profile_img = $target_file;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


    // Prepare SQL statement to insert data into users table
    $stmt = $conn->prepare("INSERT INTO users (username, profile_img, email, password, role, bio) VALUES (:name, :profile_img, :email, :password, :role, :bio)");

    // Bind parameters
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':profile_img', $profile_img);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':bio', $bio);



    // Execute SQL statement
    $stmt->execute();

 
    $stmt->closeCursor();

    // Redirect to a success page or do any other desired action
    
    exit();
}
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>

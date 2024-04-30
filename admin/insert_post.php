<?php
session_start();
include 'connection.php';

try {

    error_reporting(E_ALL);
ini_set('display_errors', 1);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Retrieve form data
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $slug = isset($_POST['slug']) ? $_POST['slug'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        $category = isset($_POST['category']) ? $_POST['category'] : '';
        $content = isset($_POST['content']) ? $_POST['content'] : ''; 

        $author_id = $_SESSION['id'] ;

        // Handle file upload

        if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $filename = $_FILES["image"]["name"];
        $tempname = $_FILES["image"]["tmp_name"];
        $folder = "postImgs/" . $filename;

    // Move uploaded file to destination folder
        if (move_uploaded_file($tempname, $folder)) {
            echo "<div class='alert alert-success' role='alert'>
                    File uploaded successfully.
                  </div>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>
                    Error while moving the uploaded file.
                  </div>";
        }
    } else {
        echo "<div class='alert alert-info' role='alert'>
                Something went wrong while uploading.
              </div>" . var_dump($_FILES['image']);
    }



        // Prepare SQL statement to insert data into posts table
        $stmt = $conn->prepare("INSERT INTO posts (title, description, image, slug, author_id, content, category_id) VALUES (:title, :description, :image, :slug, :author_id, :content, :category_id)");

        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $folder);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':author_id', $author_id);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':category_id', $category);


        // Execute SQL statement
        if (!$stmt->execute()) {
             print_r($stmt->errorInfo());
            } 
} 
 }catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    
}
?>

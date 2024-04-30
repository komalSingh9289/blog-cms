<?php
// deletePost.php

// Check if the post ID is provided in the URL
if (isset($_GET['id'])) {
    // Get the post ID from the URL parameter
    $id = $_GET['id'];

    try {
        require 'connection.php';
        
        // Prepare and execute delete query
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

        // Check if the deletion was successful
        if($stmt->rowCount() > 0) {
            echo "<script> alert('user removed successfully.'); window.location.href = 'users.php'; </script>";
            exit();
        } else {
            echo "<script> alert('Error: Something went wrong with the deletion.'); </script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Post ID not provided.";
}
?>

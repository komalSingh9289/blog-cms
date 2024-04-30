<?php
// upload_image_handler.php

// Define the upload directory
$uploadDir = '../../uploads/';

// Check if the file was uploaded without errors
if ($_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Get the temporary file location
    $tmpName = $_FILES['file']['tmp_name'];
    
    // Generate a unique filename
    $filename = uniqid() . '_' . $_FILES['file']['name'];
    
    // Move the uploaded file to the desired location
    if (move_uploaded_file($tmpName, $uploadDir . $filename)) {
        // File was uploaded successfully
        $url = '../../uploads/' . $filename; // Change this to the URL of your uploaded image
        
        // Return the URL of the uploaded image
        echo json_encode(['location' => $url]);
    } else {
        // Error moving the file
        header("HTTP/1.1 500 Internal Server Error");
        echo json_encode(['error' => 'Error moving the file']);
    }
} else {
    // Error uploading the file
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(['error' => 'Error uploading the file']);
}
?>

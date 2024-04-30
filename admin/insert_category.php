<?php
// Include the database connection file
include 'connection.php';

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $title = isset($_POST['title']) ? $_POST['title'] : '';
        $slug = isset($_POST['slug']) ? $_POST['slug'] : '';

        // Prepare SQL statement to insert data into the category table
        $stmt = $conn->prepare("INSERT INTO category (title, slug) VALUES (:title, :slug)");

        // Bind parameters
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':slug', $slug);

        // Execute SQL statement
        $stmt->execute();

        // Close cursor
        $stmt->closeCursor();

        // Respond with success message
        echo "Category added successfully.";
    }
} catch (PDOException $e) {
    // Handle any errors that occur during the insertion process
    echo "Error: " . $e->getMessage();
}
?>

<?php
// Step 1: Establish database connection
$host = 'localhost';
$dbname = 'blog_platform_cms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Step 2: Write a query to fetch categories
$query = "SELECT * FROM category";

// Step 3: Execute the query
try {
    $statement = $pdo->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?>

<!-- Step 4: Display categories dynamically -->

  <?php foreach ($categories as $category) : ?>
        <li >
            <a href="./category-post.php?id=<?php echo $category['id']; ?>" class="d-flex"><?php echo $category['title']; ?></a>
        </li>
    <?php endforeach; ?>


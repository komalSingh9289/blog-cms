<?php 
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

// Step 2:  query to fetch posts
$query = "SELECT p.*, u.username AS author_name, c.title AS category_name 
          FROM posts p 
          JOIN users u ON p.author_id = u.id 
          JOIN category c ON p.category_id = c.id
          ORDER BY p.posted_at DESC"; 

try {
    $statement = $pdo->prepare($query);
    $statement->execute();
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}


foreach ($posts as $post) {

 // Get the timestamp of the post
    $timestamp = strtotime($post['posted_at']);

    // Create a DateTime object for the post's timestamp
    $postDateTime = new DateTime("@$timestamp");

    // Get the current date and time
    $currentDateTime = new DateTime();
     // Calculate the difference between the current time and the post's time
    $interval = $currentDateTime->diff($postDateTime);

    // Format the date based on the time difference
    if ($interval->days == 0) {
        if ($interval->h == 0 && $interval->i < 5) {
            $postedAt = "Just now";
        } elseif ($interval->h == 0) {
            $postedAt = $interval->i . " minutes ago";
        } else {
            $postedAt = $interval->h . " hours ago";
        }
    } elseif ($interval->days == 1) {
        $postedAt = "Yesterday";
    } else {
        $postedAt = $interval->days . " days ago";
    }


$tags = str_replace(',', ' ', $post['tag']);


?>
<article class="row mb-5">
    <div class="col-12">
        <div class="post-slider">
            <img loading="lazy" src="../../admin/html/<?php echo $post['image']; ?>" class="img-fluid" alt="post-thumb">
        </div>
    </div>
    <div class="col-12 mx-auto">
        <h3><a class="post-title" href="post-detail.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h3>
        <ul class="list-inline post-meta mb-4">
            <li class="list-inline-item"><i class="ti-user mr-2"></i><a href="author.html"><?php echo $post['author_name']; ?></a></li>
            <li class="list-inline-item">Date : <?php echo $postedAt; ?></li>
            <li class="list-inline-item">Category : <a href="#!" class="ml-1"><?php echo $post['category_name']; ?></a></li>
            <li class="list-inline-item">Tags : <?php echo $tags; ?></li>
        </ul>
        <p><?php echo $post['description']; ?></p>
        <a href="post-detail.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary">Continue Reading</a>
    </div>
</article>
<?php
}
?>

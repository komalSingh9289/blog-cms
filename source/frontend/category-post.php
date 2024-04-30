<?php

include '../partials/header.php';
include '../partials/navigation.php';
include 'connection.php';

// Check if the ID is provided in the URL

if(isset($_GET['id'])) {

    // Sanitize the ID to prevent SQL injection

    $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

     $query = "SELECT c.title AS category_title
              FROM category c
              WHERE c.id = :category_id";
    try {
        $statement = $pdo->prepare($query);
        $statement->execute(array(':category_id' => $category_id)); // Bind the parameter value
        $category = $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
	?>
    <section class="section-sm">
	<div class="container">
		<div class="row">
			<div class="col-12">
    <div class="title-bordered mb-5 d-flex align-items-center">
		<h1 class="h4"><?php echo $category['category_title'];?> </h1>
	</div>
	<article class="row mb-5">
<?php
    

    // Prepare and execute the query to fetch the post details with user and category information
    $query = "SELECT p.*, u.username AS author, c.title AS category
			FROM posts p
			LEFT JOIN users u ON p.author_id = u.id
			LEFT JOIN category c ON p.category_id = c.id
			WHERE p.category_id = :category_id";
   try {
    $statement = $pdo->prepare($query);
    $statement->execute(array(':category_id' => $category_id)); // Bind the parameter value
    $posts = $statement->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
	    die("Error: " . $e->getMessage());
	}

	?>


	<?php


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
	<div class="col-4">
    <div class="col-12">
        <div class="post-slider">
            <img loading="lazy" src="../../admin/html/<?php echo $post['image']; ?>" class="img-fluid" alt="post-thumb">
        </div>
    </div>
    <div class="col-12 mx-auto">
        <h5><a class="post-title" href="post-detail.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a></h5>
        <h6>
        <ul class="list-inline post-meta mb-4">
            <li class="list-inline-item"><i class="ti-user mr-2"></i><a href="author.html"><?php echo $post['author']; ?></a></li>
            <li class="list-inline-item">Date : <?php echo $postedAt; ?></li>
        </ul>
        </h6>
        <p><?php echo substr($post['description'], 0, 100) . (strlen($post['description']) > 100 ? '...' : ''); ?></p>

        <a href="post-detail.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-primary">Continue Reading</a>
    </div>
    </div>

<?php 
}
?>
</article>
	</div>
	</div>
	</div>
</section>
<?php
}
include '../partials/footer.php'; 

?>

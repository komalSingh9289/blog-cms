

<?php 	
include 'connection.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['user_id'];

 $query = "SELECT d.*, u.username AS author, c.title AS category
			FROM drafts d
			LEFT JOIN users u ON d.author_id = u.id
			LEFT JOIN category c ON d.category_id = c.id
			WHERE d.author_id = :userId";
   try {
    $statement = $pdo->prepare($query);
    $statement->execute(array(':userId' => $userId)); // Bind the parameter value
    $drafts = $statement->fetchAll(PDO::FETCH_ASSOC);
	} catch (PDOException $e) {
	    die("Error: " . $e->getMessage());
	}

	foreach ($drafts as $draft) {

 // Check if the posted_at field is not empty and is a valid timestamp
    if (!empty($draft['posted_at']) && strtotime($draft['posted_at']) !== false) {
        // Get the timestamp of the post
        $timestamp = strtotime($draft['posted_at']);

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

        // Rest of your code
    } else {
        // Handle invalid or empty timestamp here
        $postedAt = "Unknown";
    }


$tags = str_replace(',', ' ', $draft['tag']);

 ?>
		
		<div class="col-4">
    <div class="col-12">
        <div class="post-slider">
            <img loading="lazy" src="../../admin/html/<?php echo $draft['image']; ?>" class="img-fluid" alt="post-thumb">
        </div>
    </div>
    <div class="col-12 mx-auto">
        <h5><a class="post-title" href="edit-draft.php?id=<?php echo $draft['id'];  ?>"><?php echo $draft['title']; ?></a></h5>
        <h6>
        <ul class="list-inline post-meta mb-4">
            <li class="list-inline-item"><i class="ti-user mr-2"></i><a href="author.html"><?php echo $draft['author']; ?></a></li>
            <li class="list-inline-item">Date : <?php echo $postedAt; ?></li>
        </ul>
        </h6>
        <p><?php echo substr($draft['description'], 0, 100) . (strlen($draft['description']) > 100 ? '...' : ''); ?></p>

        <a href="edit-draft.php?id=<?php echo $draft['id']; ?>" class="btn btn-outline-primary">Continue Editing</a>
    </div>
    </div>
					
<?php 
}
?>	

			
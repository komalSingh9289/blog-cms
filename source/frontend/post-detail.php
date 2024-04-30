<!-- INCLUDE header and navigation panel -->

<?php


include '../partials/header.php';
include '../partials/navigation.php';

 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';
// Check if the ID is provided in the URL

if(isset($_GET['id'])) {

    // Sanitize the ID to prevent SQL injection

    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

    // Prepare and execute the query to fetch the post details with user and category information
    $query = "SELECT p.*, u.username AS author, c.title AS category
              FROM posts p
              LEFT JOIN users u ON p.author_id = u.id
              LEFT JOIN category c ON p.category_id = c.id
              WHERE p.id = :post_id";
    $statement = $pdo->prepare($query);
    $statement->bindParam(':post_id', $post_id, PDO::PARAM_INT);
    $statement->execute();

    // Fetch the post details
    $post = $statement->fetch(PDO::FETCH_ASSOC);

     
}
?>

<!-- Display the post details -->
<section class="section">
<div class="container">

<article class="row mb-2">
    <?php if(isset($post)) {
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
        <div class="col-lg-10 mx-auto mb-4">
            <h1 class="h2 mb-3"><?php echo $post['title']; ?></h1>
            <ul class="list-inline post-meta mb-3">
                <li class="list-inline-item"><i class="ti-user mr-2"></i><a href="author.php"><?php echo $post['author']; ?></a></li>
                <li class="list-inline-item">Date: <?php echo $postedAt; ?></li>
                <li class="list-inline-item">Categories: <a href="#!" class="ml-1"><?php echo $post['category']; ?></a></li>
                <li class="list-inline-item">Tags: <?php echo $tags; ?></li>
            </ul>
        </div>
        <div class="col-12 mb-3">
            <div class="post-slider">
                <img  src="../../admin/html/<?= $post['image']; ?>" alt="Image" class="img-fluid" alt="post-thumb">
            </div>
        </div>
        <div class="col-lg-10 mx-auto">
            <div class="content">
                <?php echo $post['content']; ?>
            </div>
        </div>
    <?php } else { ?>
        <div class="col-lg-10 mx-auto">
            <p>No post found with the provided ID.</p>
        </div>
    <?php } ?>
</article>
</div>
</section>

      <!-- show comments section -->
<section class="section">
    <div class="container" id="commentSection">
        <article class="row mb-4">
            <!-- show comments -->
            <div class="be-comment-block">
                <?php
                // Fetch comments related to the post
                $query_comments = "SELECT c.*
                                  FROM comments c
                                  WHERE c.post_id = :post_id";
                $statement_comments = $pdo->prepare($query_comments);
                $statement_comments->bindParam(':post_id', $post_id, PDO::PARAM_INT);
                $statement_comments->execute();
                $comments = $statement_comments->fetchAll(PDO::FETCH_ASSOC);

                // Check if there are any comments
                if (count($comments) > 0) {
                    echo '<h1 class="comments-title">Comments (' . count($comments) . ')</h1>';

                    // Loop through each comment
                    foreach ($comments as $comment) {
                        $commentPostedAt = date('M d, Y \a\t h:ia', strtotime($comment['added-at']));
                        ?>

                        <div class="be-comment">
                            <div class="be-img-comment">
                                <a href="#">
                                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="be-ava-comment">
                                </a>
                            </div>
                            <div class="be-comment-content">
                                <span class="be-comment-name">
                                    <a href="#"><?php echo $comment['username']; ?></a>
                                </span>
                                <span class="be-comment-time">
                                    <i class="fa fa-clock-o"></i>
                                    <?php echo $commentPostedAt; ?>
                                </span>
                                <p class="be-comment-text"><?php echo $comment['comment']; ?></p>
                            </div>
                        </div>

                    <?php }
                } else {
                    // No comments found
                    echo '<h1 class="comments-title">No Comments Yet</h1>';
                }
                ?>
            </div>
        </article>
    </div>
</section>
<?php

  if (isset( $_SESSION['user_id'])) {
 ?>
<section class="section">
    <div class="container">
        <article class="row mb-2">
            <!-- post comment -->
            <form class="form-block mx-auto mt-5" id="commentForm" method="post"> 
                <div class="row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="form-group fl_icon">
                            <div class="icon"><i class="ti-user"></i></div>
                            <input class="form-input" name="username" type="text" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-lg-12 mx-auto">                                 
                        <div class="form-group">
                            <textarea class="form-input" required="" placeholder="Leave a comment..." name="comment" required></textarea>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <button type="submit" name="postComment" class="btn btn-primary">Send</button>
                    </div>
                </div>
            </form>
        </article>
    </div>
</section>
 <?php
  }else{
 ?>
    <section class="section text-center">
  <div class="container">
    <?php include 'comment.php'; ?>
      <h1 class="h4 mt-2">Sign in to leave a comment..</h1>
  </div>
   </section>
 <?php   
  }
 ?>


<?php
if(isset($_POST['postComment'])) {

    // Get the input values from the form
    $comment = $_POST['comment']; 
    $name = $_POST['username']; 
     $userId = $_SESSION['user_id'];
    // Ensure user_id session variable is set
    $postId = isset($_GET['id']) ? $_GET['id'] : null;

    // Sanitize input values to prevent SQL injection
    $userId = filter_var($userId, FILTER_SANITIZE_NUMBER_INT);
    $comment = filter_var($comment, FILTER_SANITIZE_STRING);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $postId = filter_var($postId, FILTER_SANITIZE_NUMBER_INT);



    // Prepare the query to insert a new comment into the database
    $query = "INSERT INTO comments (userId, username, comment, post_id) VALUES (:userId, :name, :comment, :postId)"; 

    $statement = $pdo->prepare($query);

    // Bind parameters and execute the query
    $statement->bindParam(':userId', $userId, PDO::PARAM_INT);
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->bindParam(':comment', $comment, PDO::PARAM_STR);
    $statement->bindParam(':postId', $postId, PDO::PARAM_INT);

    // Execute the query
    if($statement->execute()) {
        echo "<script> alert('comment added'); <script> ";
        
    } else {
        echo "Error submitting comment.";
    }
}
?>


<?php

  include '../partials/footer.php';
?>









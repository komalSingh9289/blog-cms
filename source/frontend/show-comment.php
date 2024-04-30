
<?php

include 'connection.php';

// Fetch comments related to the post and return the updated comment section HTML
        $query_comments = "SELECT c.*
                           FROM comments c
                           WHERE c.post_id = :postId";
        $statement_comments = $pdo->prepare($query_comments);
        $statement_comments->bindParam(':postId', $postId, PDO::PARAM_INT);
        $statement_comments->execute();
        $comments = $statement_comments->fetchAll(PDO::FETCH_ASSOC);

        // Prepare HTML for updated comment section
        ob_start(); // Start output buffering
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
            <?php
        }
        $commentSectionHTML = ob_get_clean(); // Get the output buffer contents and clear it

        echo $commentSectionHTML; // Output the updated comment section HTML
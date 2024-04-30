<?php
    include 'connection.php';


    try {
         $query = "SELECT tag FROM posts";
    $statement = $pdo->query($query);

      $encounteredTags = array();

    // Display the posts and their tags
    $tags = $statement->fetchAll(PDO::FETCH_ASSOC);



    foreach ($tags as $tag) {

        $tagArray = explode(',', $tag['tag']);
        foreach ($tagArray as $individualTag) {

           $individualTag = trim($individualTag);
            $individualTag = str_replace('#', '', $individualTag);

            if (!in_array($individualTag, $encounteredTags)) {
    
 ?>
    <li class="list-inline-item">
        <a href="#!"><?php echo $individualTag; ?> </a>
    </li>


<?php

        $encounteredTags[] = $individualTag;
 }
  }
    }
        
    } catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

 ?>



              
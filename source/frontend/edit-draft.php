<?php
include 'connection.php';
include '../partials/header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(isset($_GET['id'])) {
   
    $draftId = $_GET['id'];

    // Fetch draft details from the database based on the ID
    $query = "SELECT * FROM drafts WHERE id = :draftId";
    $statement = $pdo->prepare($query);
    $statement->execute(array(':draftId' => $draftId));
    $draft = $statement->fetch(PDO::FETCH_ASSOC);

    // Check if draft exists
    if($draft) {
        // Populate form fields with draft details
        $title = $draft['title'];
        $description = $draft['description'];
        $image = $draft['image'];
        $slug = $draft['slug'];
        $content = $draft['content'];
        $category_id = $draft['category_id'];
        $posted_at = $draft['posted_at'];
        $tag = $draft['tag'];
    

        
?>


    <section class="section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        
        <article class="row mb-5">

        <div class="container-fluid">
        <!-- Your HTML form goes here -->
         <form class="form-horizontal" method="post" id="updateDraft" enctype="multipart/form-data">
                  <div class="card-body">

                     

                    <div class="form-group row">
                      <label
                        for="title"
                        class="col-sm-3 text-end control-label col-form-label"
                        > Title</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="title"
                          name="title"
                          value="<?php echo htmlspecialchars($title); ?>"
                          placeholder="Title Here"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="slug"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Slug</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="slug"
                          name="slug"
                          value="<?php echo htmlspecialchars($slug); ?>"
                          placeholder="Url Name"
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="short-des"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Short Desciption</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="description"
                          name="description"
                          value="<?php echo htmlspecialchars($description); ?>"
                          placeholder="Little Bit about Your Post.."
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="image"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Featured Image</label
                      >
                      <div class="col-sm-9">
                        <!-- Display current image -->
                            <?php if (!empty($image)): ?>
                            <img  src="../../admin/html/<?= $image; ?>" class="img-fluid" alt="post-thumb" style="max-width: 50%; height: auto;">
                            <?php endif; ?>

                            <!-- File input field for uploading a new image -->
                            <input type="file" class="form-control" id="image" name="image"  />

                        
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="category"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Choose Category</label
                      >
                      <div class="col-sm-9">

                        <!----------category select-------------->
                        <?php include 'connection.php'; ?>
                        <?php
                        try {

                            // Fetch categories from the database
                            $stmt = $pdo->prepare("SELECT * FROM category");
                            $stmt->execute();
                            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        } catch(PDOException $e) {
                            echo "error: " . $e->getMessage();
                        }
                        ?>

                        <select class="form-select form-control" id="category" name="category">
                            <option selected disabled>Choose Category</option>
                            <?php foreach ($categories as $category): ?>
                                <?php if ($category['id'] == $category_id): ?>
                                    <option value="<?php echo $category['id']; ?>" selected><?php echo $category['title']; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="tag"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Tag</label
                      >
                      <div class="col-sm-9">
                        <input
                          type="text"
                          class="form-control"
                          id="tag"
                          name="tag"
                          value="<?php echo htmlspecialchars($tag); ?>"
                          placeholder="tag separated by comma"
                        />
                      </div>
                    </div>
                   
                    <div class="form-group row">
                      <label
                        for="tinycontent"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Content</label
                      >
                      <div class="col-sm-9">
                        <textarea class="form-control" id="tinycontent" name="content"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary" id="update" name="update">
                        Save Changes
                      </button>
                      <button type="submit" class="btn btn-primary" id="publish" name="publish">
                       Publish
                      </button>
                    </div>
                  </div>
                </form>
        </div>
    </article>
    </div>
    </div>
    </div>
</section>
<script>

  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    images_upload_url: 'upload_image_handler.php', // server-side image upload handler
     setup: function(editor) {
    editor.on('init', function() {
        try {
            // Retrieve content from PHP
            var content = <?php echo json_encode($content); ?>;
            
            // Set content only if it's not empty
            if (content.trim() !== '') {
                editor.setContent(content);
            }
        } catch (error) {
            console.error('Error setting content:', error);
        }
    });
}
  });
</script>



<?php
    } else {
        echo "Draft not found!";
    }
} else {
    echo "Draft ID not provided!";
}


// to save post in draft

if (isset($_POST['update'])) {
    // Retrieve form data
    // Assuming you have a hidden input field for draft ID in your form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tag = $_POST['tag'];
    $slug = $_POST['slug'];
    $category_id = $_POST['category'];
    $content = $_POST['content'];


    // File upload handling
    $target_dir = "postImgs/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Prepare SQL statement to update data
    $sql = "UPDATE drafts SET title = :title, description = :description, image = :image, slug = :slug, content = :content, category_id = :category_id, tag = :tag WHERE id = :draftId";
    $stmt = $pdo->prepare($sql);

    // Bind parameters to statement
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $target_file);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':tag', $tag);
    $stmt->bindParam(':draftId', $draftId);

    // Execute statement
    try {
        $stmt->execute();
        // Check if the execution was successful
        if($stmt->rowCount() > 0) {
            echo "<script> alert('Post updated successfully.'); window.location.href = 'mydashboard.php'; </script>";
            exit(); 
        } else {
            echo "<script> alert('Error: Something went wrong with the execution.'); </script>";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}



// to publish

if (isset($_POST['publish'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tag = $_POST['tag'];
    $slug = $_POST['slug'];
    $category_id = $_POST['category'];
    $content = $_POST['content'];

    $author_id = $_SESSION['user_id'];

    $currentImage = $_POST['category'];
    // File upload handling
 if ($_FILES["image"]["error"] !== UPLOAD_ERR_NO_FILE) {
    $target_dir = "postImgs/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
} else {
    // If no file was uploaded, set $target_file to NULL or to the current image path in the database, depending on your logic
    $target_file = NULL; // or $target_file = $image; depending on your requirement
}

    // Prepare SQL statement to insert data
    $sql = "INSERT INTO posts (title, description, image,slug,author_id, content,category_id,  tag) VALUES (:title, :description, :image, :slug, :author_id, :content, :category_id,  :tag)";
    $stmt = $pdo->prepare($sql);

    // Bind parameters to statement
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':image', $target_file);
    $stmt->bindParam(':slug', $slug);
    $stmt->bindParam(':author_id', $author_id);
    $stmt->bindParam(':content', $content);
    $stmt->bindParam(':category_id', $category_id);
    $stmt->bindParam(':tag', $tag);
    

    // Execute statement
    try {
         $stmt->execute();
        // Check if the execution was successful
        if($stmt->rowCount() > 0) {
             echo "<script> alert('Post updated successfully.'); window.location.href = 'mydashboard.php'; </script>";

             // Delete the draft from the drafts table
        $deleteQuery = "DELETE FROM drafts WHERE id = :draftId";
        $deleteStmt = $pdo->prepare($deleteQuery);
        $deleteStmt->bindParam(':draftId', $draftId);
        
        try {
            $deleteStmt->execute();
            // Check if the deletion was successful
            if($deleteStmt->rowCount() > 0) {
                // Draft deleted successfully
            } else {
                // Handle deletion error if necessary
            }
        } catch (PDOException $e) {
            // Handle deletion error if necessary
            echo "Error: " . $e->getMessage();
        }
            exit(); 
        } else {
            echo "<script> alert('Error: Something went wrong with the execution.'); </script>";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>





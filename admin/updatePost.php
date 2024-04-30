 
<?php
  include 'header.php'; 
  session_start();

$id = isset($_GET['id']) ? $_GET['id'] : null;

// Check if $id is set
if(isset($id)) {

  require 'connection.php';
   try {
        // Prepare and execute query to fetch post data
        $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
        $stmt->execute([$id]);
        $post = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Populate form fields with post data
        $title = $post['title'];
        $slug = $post['slug'];
        $description = $post['description'];
        $category_id = $post['category_id'];
        $tag = $post['tag'];
        $content = $post['content'];
       $image = $post['image'];
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    



} else {
    echo "ID not found in the URL";
}




// update query....................

if (isset($_POST['updatePost'])) {
        $title = $_POST['title'];
        $slug = $_POST['slug'];
        $description = $_POST['description'];
        $category_id = $_POST['category'];
        $tag = $_POST['tag'];
        $content =$_POST['content'];

        $author_id = $_SESSION['id'];

       if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "postImgs/";
      $target_file = $target_dir . basename($_FILES["image"]["name"]);
      move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

       try {
            require 'connection.php';
             $sql = "UPDATE posts SET title = :title, description = :description, image = :image, slug = :slug, author_id = :author_id, content = :content, category_id = :category_id, tag = :tag WHERE id = :id";
           $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $target_file);
            $stmt->bindParam(':slug', $slug);
            $stmt->bindParam(':author_id', $author_id);
            $stmt->bindParam(':content', $content);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':tag', $tag);
            $stmt->bindParam(':id', $id);

            $stmt->execute();
        // Check if the execution was successful
        if($stmt->rowCount() > 0) {
            echo "<script> alert('Post updated successfully.'); window.location.href = 'posts.php'; </script>";
            exit(); 
        } else {
            echo "<script> alert('Error: Something went wrong with the execution.'); </script>";
        }



       } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
}


?>

  <div class="container-fluid">
        <form class="form-horizontal" method="post" id="addpostform" enctype="multipart/form-data">
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
                          value = "<?php echo $title; ?> "
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
                          value = "<?php echo $slug; ?> "
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
                          value = "<?php echo $description; ?> "
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
                        <input
                          type="file"
                          class="form-control"
                          id="image"
                          value = "<?php echo $image; ?> "
                          name="image"
                          
                        />
                      </div>
                    </div>
                    <div class="form-group row">
                      <label
                        for="content"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Choose Category</label
                      >
                      <div class="col-sm-9">

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
                          value = "<?php echo $tag; ?> "
                          placeholder="tag separated by comma"
                        />
                      </div>
                    </div>
                   
                    <div class="form-group row">
                      <label
                        for="content"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Content</label
                      >
                      <div class="col-sm-9">
                        <textarea class="form-control" id="content" name="content"
                        ></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary" id="updatePost" name="updatePost">
                        Update
                      </button>
                    </div>
                  </div>
                </form>
      </div>
     


<script src="https://cdn.tiny.cloud/1/fcr4hjyb4u0wfsxs4584yedjicu6r6p6ngntn3t0w8vezms6/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>


<!-- tinymce script -->
<script>
  tinymce.init({
    selector: '#content',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
     images_upload_url: 'upload_image_handler.php',
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









<?php 
 if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<?php include '../partials/header.php'; ?>

	

<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="title-bordered mb-5 d-flex align-items-center">
          <h1 class="h4">"Hey, blogger! What's your next masterpiece?"</h1>
        </div>
        <article class="row mb-5">

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
                        <input type="file" class="form-control" id="image" name="image"/>
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
                          <option selected>choose</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?>
                            
                                </option>
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
                      <button type="submit" class="btn btn-primary" id="addpost" name="addpost">
                        Publish
                      </button>
                      <button type="submit" class="btn btn-primary" id="addInDraft" name="addInDraft">
                        Draft
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
  });
</script>


</script>

<?php
// Establish database connection
require 'connection.php';

// to publish

if (isset($_POST['addpost'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tag = $_POST['tag'];
    $slug = $_POST['slug'];
    $category_id = $_POST['category'];
    
    $content = $_POST['content'];

    $author_id = $_SESSION['user_id'];

    // File upload handling
    $target_dir = "postImgs/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

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
            echo "alert('post added successfully.')";
            exit(); 
        } else {
            echo "Error: Something went wrong with the execution.";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// to save post in draft

if (isset($_POST['addInDraft'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tag = $_POST['tag'];
    $slug = $_POST['slug'];
    $category_id = $_POST['category'];
    
    $content = $_POST['content'];

    $author_id = $_SESSION['user_id'];

    // File upload handling
    $target_dir = "postImgs/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);

    // Prepare SQL statement to insert data
    $sql = "INSERT INTO drafts (title, description, image,slug,author_id, content,category_id,  tag) VALUES (:title, :description, :image, :slug, :author_id, :content, :category_id,  :tag)";
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
            echo "<script> alert('post added successfully.'); </script>";

            exit(); 
        } else {
            echo "<script> alert('Error: Something went wrong with the execution.'); </script>";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>




<?php 
  session_start();
  include 'header.php'; 

?>

<body>
	<div class="preloader">
      <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
      </div>
    </div>



<div
      id="main-wrapper"
      data-layout="vertical"
      data-navbarbg="skin5"
      data-sidebartype="full"
      data-sidebar-position="absolute"
      data-header-position="absolute"
      data-boxed-layout="full"
    >

        <?php include 'top-header.php'; ?>
    <?php include 'sidebar.php'; ?>


    <!----------user table------------------>

<div class="page-wrapper">
    <div class="page-breadcrumb">
          <div class="row">
            <div class="col-12 d-flex no-block align-items-center">
              <h4 class="page-title"> Add post</h4>
              <div class="ms-auto text-end">
                
              </div>
            </div>
          </div>
        </div>

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
                        <input
                          type="file"
                          class="form-control"
                          id="image"
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

                        <select class="form-select" id="category" name="category">
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
                        for="content"
                        class="col-sm-3 text-end control-label col-form-label"
                        >Content</label
                      >
                      <div class="col-sm-9">
                        <textarea class="form-control" id="content" name="content"></textarea>
                      </div>
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="submit" class="btn btn-primary" id="addpost" name="addpost">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
        </div>	
    </div>

	
</div>

<script src="https://cdn.tiny.cloud/1/fcr4hjyb4u0wfsxs4584yedjicu6r6p6ngntn3t0w8vezms6/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>


<script>
  
  tinymce.init({
    selector: 'textarea',
    plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount linkchecker',
    toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
    images_upload_url: 'upload_image_handler.php', // server-side image upload handler
  });

</script>


<?php
// Establish database connection
require 'connection.php';

// Check if form is submitted
if (isset($_POST['addpost'])) {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tag = $_POST['tag'];
    $slug = $_POST['slug'];
    $category_id = $_POST['category'];
    
    $content = $_POST['content'];

    $author_id = $_SESSION['id'];

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
            echo "<script> alert('post added successfully.'); window.location.href = 'posts.php'; </script>";
            exit();
        } else {
           echo "<script> alert('Error: Something went wrong.'); </script>";
        }
        
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>


<?php include 'footer.php'; ?>

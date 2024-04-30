<?php include 'header.php'; ?>

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
        <div class="page-wrapper vh-100">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <button class=" btn btn-primary" data-bs-toggle="modal" data-bs-target="#categorymodal">New Category</button>
                        <div class="ms-auto text-end"></div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <?php include 'connection.php'?>
                <?php
                try {
                   

                    // Number of records per page
                    $recordsPerPage = 5;

                    // Get current page number from URL, default is page 1
                    $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;

                    // Calculate offset for pagination
                    $offset = ($pageNumber - 1) * $recordsPerPage;

                    // SQL query to fetch users with pagination
                    $sql = "SELECT * FROM category LIMIT :offset, :recordsPerPage";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
                    $stmt->execute();
                    $category = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Count total number of records
                    $totalRecords = $pdo->query("SELECT COUNT(*) FROM category")->fetchColumn();

                    // Calculate total number of pages
                    $totalPages = ceil($totalRecords / $recordsPerPage);
                } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Created At</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($category as $cat): ?>

                        <tr>
                            <th scope="row"><?php echo $cat['id']; ?></th>
                            <td><?php echo $cat['title']; ?></td>
                            <td><?php echo $cat['slug']; ?></td>
                            <td><?php echo $cat['created_at']; ?></td>
                            <td>
                                <a href="deleteCategory.php?id=<?php echo $cat['id']; ?>" 
                                class="btn btn-danger" >
                                Delete
                            </a>

                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <nav aria-label="...">
                    <ul class="pagination pagination-sm">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo ($pageNumber == $i) ? 'active' : ''; ?>"
                            aria-current="page">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                        <?php endfor; ?>
                    </ul>
                </nav>

            </div>


        </div>


    </div>


    <!------------ Add new category modal --------------->

    <div class="modal fade" id="categorymodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="categorymodallabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="categorymodallabel">Add New Category</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" id="addcategoryform">
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
                        >
                    </div>
                  </div>
                  <div class="border-top">
                    <div class="card-body">
                      <button type="button" class="btn btn-primary" id="addcategory" name="addcategory">
                        Submit
                      </button>
                    </div>
                  </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    $(document).ready(function () {

        // On button click, send form data via AJAX
        $("#addcategory").click(function () {
            // Serialize form data
            var formData = $("#addcategoryform").serialize();

            // Send AJAX request
            $.ajax({
                type: "POST",
                url: "insert_category.php",
                data: formData,
                success: function (response) {
                    alert("Category added successfully.");
                    $("#addcategoryform")[0].reset(); // Clear the form
                    window.location.href = "categories.php";
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                    alert("Error adding category. Please try again.");
                }
            });
        });
    });
</script>




    <?php include 'footer.php'; ?>


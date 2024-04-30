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

        <!----------comment table------------------>
        <div class="page-wrapper vh-100">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Comments</h4>
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
                    $sql = "SELECT * FROM comments LIMIT :offset, :recordsPerPage";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                    $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
                    $stmt->execute();
                    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
                            <th scope="col">user-id</th>
                            <th scope="col">comment</th>
                            <th scope="col">post-id</th>
                            <th scope="col">Posted At</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($comments as $comment): ?>

                        <tr>
                            <th scope="row"><?php echo $comment['id']; ?></th>
                            <td><?php echo $comment['userId']; ?></td>
                            <td><?php echo $comment['comment']; ?></td>
                            <td><?php echo $comment['post_id']; ?></td>
                            <td><?php echo $comment['added-at']; ?></td>
                            <td>
                                <a href="deleteComment.php?id=<?php echo $comment['id']; ?>" 
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


    <?php include 'footer.php'; ?>


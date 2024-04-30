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

        <!----------POSTS table------------------>
        <div class="page-wrapper">
            <div class="page-breadcrumb">
                <div class="row">
                    <div class="col-12 d-flex no-block align-items-center">
                        <h4 class="page-title">Posts</h4>
                        <div class="ms-auto text-end"></div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <?php

                    require 'connection.php';
                $recordsPerPage = 5;

                // Get current page number from URL, default is page 1
                $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;

                // Calculate offset for pagination
                $offset = ($pageNumber - 1) * $recordsPerPage;

                // SQL query to fetch users with pagination
                $sql = "SELECT * FROM posts LIMIT :offset, :recordsPerPage";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
                $stmt->execute();
                $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Count total number of records
                $totalRecords = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();

                // Calculate total number of pages
                $totalPages = ceil($totalRecords / $recordsPerPage);
                
                ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Author-id</th>
                            <th scope="col">Category-id</th>
                            <th scope="col">Posted at</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($posts as $post): ?>
                        <tr>
                            <th scope="row"><?php echo $post['id']; ?></th>
                            <td><?php echo $post['title']; ?></td>
                            <td><?php echo $post['slug']; ?></td>
                            <td><?php echo $post['author_id']; ?></td>
                            <td><?php echo $post['category_id']; ?></td>
                            <td><?php echo $post['posted_at']; ?></td>
                            <td>
                                <a href="deletePost.php?id=<?php echo $post['id']; ?>" 
                                class="btn btn-danger" >
                                Delete
                            </a>

                                 <a href="updatePost.php?id=<?php echo $post['id']; ?>" 
                                class="btn btn-warning" >
                                Update
                            </a>
                            </td>
                        </tr>

                        <?php 
                    endforeach; ?>
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





   
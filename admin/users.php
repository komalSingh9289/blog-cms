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
                        <h4 class="page-title">Users</h4>
                        <div class="ms-auto text-end"></div>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "blog_platform_cms";

                try {
                    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }

                // Number of records per page
                $recordsPerPage = 5;

                // Get current page number from URL, default is page 1
                $pageNumber = isset($_GET['page']) ? $_GET['page'] : 1;

                // Calculate offset for pagination
                $offset = ($pageNumber - 1) * $recordsPerPage;

                // SQL query to fetch users with pagination
                $sql = "SELECT * FROM users LIMIT :offset, :recordsPerPage";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
                $stmt->bindParam(':recordsPerPage', $recordsPerPage, PDO::PARAM_INT);
                $stmt->execute();
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Count total number of records
                $totalRecords = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();

                // Calculate total number of pages
                $totalPages = ceil($totalRecords / $recordsPerPage);
                ?>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Profile Image</th>
                            <th scope="col">Email</th>
                            <th scope="col">Bio</th>
                            <th scope="col">Added At</th>
                            <th scope="col">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>

                        <tr>
                            <th scope="row"><?php echo $user['id']; ?></th>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['profile_img']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['bio']; ?></td>
                            <td><?php echo $user['added_at']; ?></td>
                            <td>
                                <a href="deleteUser.php?id=<?php echo $user['id']; ?>" 
                                class="btn btn-danger" >
                                Delete
                            </a>
                                <a href="updateUser.php?id=<?php echo $user['id']; ?>" 
                                class="btn btn-warning" >
                                Update
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

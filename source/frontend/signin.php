<?php 
session_start();
// Include your database configuration file if not already included
include 'connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get username/email and password from the form
    $usernameOrEmail = $_POST['name'];
    $password = $_POST['password'];

    try {

        // Prepare SQL statement to select user by username or email
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :usernameOrEmail OR email = :usernameOrEmail");
        // Bind parameters
        $stmt->bindParam(':usernameOrEmail', $usernameOrEmail);
        // Execute the query
        $stmt->execute();
        // Fetch the result
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if user exists and password is correct
        if ($user && password_verify($password, $user['password'])) {
            // User exists and password is correct, do something (e.g., set session, redirect to dashboard)
            // For example:
           
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['username'];
            // Redirect to dashboard or any other page
            header("Location: index.php");
            exit();
        } else {
            // User does not exist or password is incorrect
            echo "Invalid username/email or password";
        }
    } catch(PDOException $e) {
        // Handle database connection errors
        echo "Error: " . $e->getMessage();
    }

    // Close database connection
    unset($pdo);
}
?>
<!-- INCLUDE header and navigation panel -->

<?php include '../partials/header.php'; ?>
<?php include '../partials/navigation.php'; ?>


<!-- MAIN SECTION -->

<section class="section-sm">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="title-bordered mb-5 d-flex align-items-center">
                    <h1 class="h4">"Connect, Create, Contribute"</h1>
                    <ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
                        <li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="ti-linkedin"></i></a>
                        </li>
                        <li class="list-inline-item"><a href="#"><i class="ti-github"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <div class="content mb-5">
                    <h1 id="ask-us-anything-br-or-just-say-hi">Welcome back!</h1>
                    <p>Ready to continue your journey with us?</p>
                    <h4 class="mt-5">Don't have an account ? </h4>
                    <p><a href="Signup.php">Sign up</a>
                    </p>
                </div>
            </div>
            <div class="col-md-6">

                <!-- SIGNIN FORM -->

                <form method="POST" action="#">
                    <div class="form-group">
                        <label for="name">Username or email</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>  
        </div>
    </div>
</section>

<!-- INCLUDE FOOTER SECTION -->

<?php include '../partials/footer.php'; ?>

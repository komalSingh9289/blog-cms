<?php

//include necessary files

include('connection.php');
include('header.php');

// Start session
session_start();

if (isset($_POST['login'])) {
		$email = $_POST['email'];
		$password = $_POST['password'];

		// Prepare SQL statement
		$sql = $pdo->prepare("SELECT * FROM `users` WHERE `email` = ?");
		
		if ($sql !== false) {
				// Bind parameters
				$sql->bindParam(1, $email);

				// Execute query
				if ($sql->execute()) {
						// Fetch data
						$user = $sql->fetch(PDO::FETCH_ASSOC);
						
						if ($user) {
								// Verify password
								if (password_verify($password, $user['password'])) {
										if ($user['role'] == 'admin') {
												// Set session variables
												$_SESSION['id'] = $user['id'];
												$_SESSION['username'] = $user['username'];
												$_SESSION['email'] = $user['email'];

												// Redirect to dashboard
												header('Location: dashboard.php');
												exit();
										} else {
												echo "<div class='alert alert-info' role='alert'>
															Access denied!
														</div>";
										}
								} else {
										echo "<div class='alert alert-info' role='alert'>
														 Invalid email or password
														</div>";
								}
						} else {
								echo "<div class='alert alert-info' role='alert'>
														 Invalid email or password
														</div>";
						}
				} else {
						echo "Something went wrong with the query execution.";
				}
		} else {
				echo "Something went wrong with preparing the SQL statement.";
		}
}
?>


<!DOCTYPE html>
<html dir="ltr">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<!-- Tell the browser to be responsive to screen width -->
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta
			name="keywords"
			content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template"
		/>
		<meta
			name="description"
			content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework"
		/>
		<meta name="robots" content="noindex,nofollow" />
		<title>	LogBook-Dashboard/Login</title>
		<!-- Favicon icon -->
		<link
			rel="icon"
			type="image/png"
			sizes="16x16"
			href="../assets/images/favicon.png"
		/>
		<!-- Custom CSS -->
		<link href="../dist/css/style.min.css" rel="stylesheet" />
		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>

	<body>
		<div class=" container main-wrapper vh-100">
			<!-- ============================================================== -->
			<!-- Preloader - style you can find in spinners.css -->
			<!-- ============================================================== -->
			<div class="preloader">
				<div class="lds-ripple">
					<div class="lds-pos"></div>
					<div class="lds-pos"></div>
				</div>
			</div>
			<div class=" auth-wrapper d-flex no-block justify-content-center align-items-center bg-light " >

				<div class="p-5 auth-box bg-light border-top border-secondary">
					<div id="loginform">
						<div class="text-center pt-5 mt-3 pb-3">
							<span class="db"
								><img src="../assets/images/logo.png" alt="logo"
							/></span>
						</div>
						<!-- Form -->
						<form class="form-horizontal mt-3" id="loginform" action="" method="post"
						>
							<div class="row pb-4">
								<div class="col-12">
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span
												class="input-group-text bg-success text-white h-100"
												id="basic-addon1"
												><i class="mdi mdi-account fs-4"></i
											></span>
										</div>
										<input
											type="text"
											id="email"
											name ="email"
											class="form-control form-control-lg"
											placeholder="email"
											aria-label="email"
											aria-describedby="basic-addon1"
											required=""
										/>
									</div>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span
												class="input-group-text bg-warning text-white h-100"
												id="basic-addon2"
												><i class="mdi mdi-lock fs-4"></i
											></span>
										</div>
										<input
											type="password"
											class="form-control form-control-lg"
											placeholder="Password"
											id="password"
											name ="password"
											aria-label="Password"
											aria-describedby="basic-addon1"
											required=""
										/>
									</div>
								</div>
							</div>
							<div class="row border-top border-secondary">
								<div class="col-12">
									<div class="form-group">
										<div class="pt-3">
											<button
												class="btn btn-info"
												id="to-recover"
												type="button"
											>
												<i class="mdi mdi-lock fs-4 me-1"></i> Lost password?
											</button>
											<button
												class="btn btn-success float-end text-white"
												type="submit" id="login" name="login"
											>
												Login
											</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>

					<!--- email recovery --->
					
					<div id="recoverform">
						<div class="text-center">
							<span class="text-dark"
								>Enter your e-mail address below and we will send you
								instructions how to recover a password.</span
							>
						</div>
						<div class="row mt-3">
							<!-- Form -->
							<form class="col-12" action="" method="post">
								<!-- email -->
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<span
											class="input-group-text bg-danger text-white h-100"
											id="basic-addon1"
											><i class="mdi mdi-email fs-4"></i
										></span>
									</div>
									<input
										type="password"
										class="form-control form-control-lg"
										placeholder="Email Address"
										aria-label="Username"
										aria-describedby="basic-addon1"
									/>
								</div>
								<!-- pwd -->
								<div class="row mt-3 pt-3 border-top border-secondary">
									<div class="col-12">
										<a
											class="btn btn-success text-white"
											href="#"
											id="to-login"
											name="action"
											>Back To Login</a
										>
										<button
											class="btn btn-info float-end"
											type="button"
											name="action"
										>
											Recover
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		
		</div>

		<!-- ============================================================== -->
		<!-- All Required js -->
		<!-- ============================================================== -->
		<script src="../assets/libs/jquery/dist/jquery.min.js"></script>
		<!-- Bootstrap tether Core JavaScript -->
		<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
		<!-- ============================================================== -->
		<!-- This page plugin js -->
		<!-- ============================================================== -->
		<script>
			$("#recoverform").hide();
			$(".preloader").fadeOut();
			// ==============================================================
			// Login and Recover Password
			// ==============================================================
			$("#to-recover").on("click", function () {
				$("#loginform").slideUp();
				$("#recoverform").fadeIn();
			});
			$("#to-login").click(function () {
				$("#recoverform").hide();
				$("#loginform").fadeIn();
			});




		</script>






<!-- INCLUDE header and navigation panel -->

<?php include '../partials/header.php'; ?>
<?php include '../partials/navigation.php'; ?>

<!-- MAIN SECTION -->

<section class="section-sm">
	<div class="container">
		<div class="col-12">
				<div class="title-bordered mb-5 d-flex align-items-center">
					<h1 class="h4">Unlock your creative potential :)</h1>
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

			<div class="col-md-12">

				<!-- SIGNUP FORM -->

				<form method="POST" action="#">
					<div class="row">
						<div class="form-group col-md-3">
							<label for="name">Name</label>
							<input type="text" name="name" id="name" class="form-control" required>
						</div>
						<div class="form-group col-md-3">
							<label for="email">Email</label>
							<input type="email" name="email" id="email" class="form-control" required>
						</div>	
						<div class="form-group col-md-3">
							<label for="password">Password</label>
							<input type="password" name="password" id="password" class="form-control" required>
						</div>
						<div class="form-group col-md-3">
							<label for="password">Confirm Password</label>
							<input type="password" name="password" id="password" class="form-control" required>
						</div>
						<div class="form-group col-md-3">
							<label for="profile">Profile</label>
							<input type="file" name="profile" id="profile" class="form-control-file" required>
						</div>
						<div class="form-group col-md-6">
							<label for="bio">Little bit About Yourself.</label>
							<textarea name="password" id="password" class="form-control" required></textarea>
						</div>
						<div class="form-group col-md-3">
							<label for="role">Sign up as</label>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="role" id="user" value="option1" checked>
							  <label class="form-check-label" for="user">
							   User
							  </label>
							</div>
							<div class="form-check">
							  <input class="form-check-input" type="radio" name="role" id="author" value="option2">
							  <label class="form-check-label" for="author">
							    Author
							  </label>
							</div>
						</div>


					</div>
					
					<button type="submit" class="btn btn-primary">Sign in</button>
				</form>
			</div>
			


	</div>
</section>

<!-- INCLUDE FOOTER SECTION -->

<?php include '../partials/footer.php'; ?>
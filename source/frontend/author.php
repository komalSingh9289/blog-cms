<!-- INCLUDE header and navigation panel -->

<?php include '../partials/header.php'; ?>
<?php include '../partials/navigation.php'; ?>

<!-- MAIN SECTION -->

<section class="section-sm border-bottom">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="title-bordered mb-5 d-flex align-items-center">
					<h1 class="h4">John Doe</h1>
					<ul class="list-inline social-icons ml-auto mr-3 d-none d-sm-block">
						<li class="list-inline-item"><a href="#"><i class="ti-facebook"></i></a>
						</li>
						<li class="list-inline-item"><a href="#"><i class="ti-twitter-alt"></i></a>
						</li>
						<li class="list-inline-item"><a href="#"><i class="ti-github"></i></a>
						</li>
					</ul>
				</div>
			</div>
			<div class="col-lg-3 col-md-4 mb-4 mb-md-0 text-center text-md-left">
				<img loading="lazy" class="rounded-lg img-fluid" src="images/author.jpg">
			</div>
			<div class="col-lg-9 col-md-8 content text-center text-md-left">
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sit amet vulputate augue. Duis auctor lacus id vehicula gravida. Nam suscipit vitae purus et laoreet. Donec nisi dolor, consequat vel pretium id, auctor in dui. Nam iaculis, neque ac ullamcorper. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sit amet vulputate augue. Duis auctor lacus id vehicula gravida. Nam suscipit vitae purus et laoreet.</p>
				<p>Donec nisi dolor, consequat vel pretium id, auctor in dui. Nam iaculis, neque ac ullamcorper.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sit amet vulputate augue.</p>
			</div>
		</div>
	</div>
</section>

<!-- POSTS BY AUTHOR SECTION -->

<section class="section-sm">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="title text-center">
					<h2 class="mb-5">Posted by this author</h2>
				</div>
			</div>
			
			<?php include 'postByAuthor.php'; ?>
			
		</div>
	</div>
</section>

<!-- INCLUDE FOOTER SECTION -->

<?php include '../partials/footer.php'; ?>
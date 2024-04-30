<?php 
// Step 1: Establish database connection
$host = 'localhost';
$dbname = 'blog_platform_cms';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

// Step 2: Write a query to fetch categories
$query = "SELECT * FROM posts";

// Step 3: Execute the query
try {
    $statement = $pdo->prepare($query);
    $statement->execute();
    $categories = $statement->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}

?>



<article class="row mb-5">
					<div class="col-12">
						<div class="post-slider">
							<img loading="lazy" src="images/post/post-1.jpg" class="img-fluid" alt="post-thumb">
						</div>
					</div>
					<div class="col-12 mx-auto">
						<h3><a class="post-title" href="post-details-1.html">Cheerful Loving Couple Bakers Drinking Coffee</a></h3>
						<ul class="list-inline post-meta mb-4">
							<li class="list-inline-item"><i class="ti-user mr-2"></i><a href="author.php">John Doe</a>
							</li>
							<li class="list-inline-item">Date : March 14, 2020</li>
							<li class="list-inline-item">Categories : <a href="#!" class="ml-1">Photography </a>
							</li>
							<li class="list-inline-item">Tags : <a href="#!" class="ml-1">Photo </a> ,<a href="#!" class="ml-1">Image </a>
							</li>
						</ul>
						<p>It’s no secret that the digital industry is booming. From exciting startups to global brands, companies are reaching out to digital agencies, responding to the new possibilities available. However, the industry is fast becoming overcrowded, heaving with agencies offering similar services — on the surface, at least. Producing creative, fresh projects is the key to standing out.</p> <a href="post-details-1.html" class="btn btn-outline-primary">Continue Reading</a>
					</div>
				</article>
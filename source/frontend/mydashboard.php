

<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include '../partials/header.php'; 

include '../partials/navigation.php';




?>

<section class="section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="title-bordered mb-5 d-flex align-items-center">
         			 <h1 class="h4">"Grab your coffee, settle in, and let's weave some friendly tales together on this fine day."</h1>
        		</div>

				<div class="title-bordered mb-5 d-flex align-items-center">
					<a href="#" class="btn btn-primary links" data-url="myPosts.php">My Posts</a>
				 
                    <a href="#" class="btn btn-primary ml-2 links" data-url="drafts.php">Drafts</a>
                    <a href="#" class="btn btn-primary ml-2 links" data-url="likedPost.php">Liked Posts</a>

                    <a href="addPost.php" class="btn btn-primary ml-2 " >Today's Blog</a>
				</div>
				<article class="row mb-5" id="content">

				</article>
			</div>
		</div>
	</div>

</section>

<script>
    // Function to load content dynamically using AJAX
    function loadContent(url) {
        // Make an AJAX request to the specified URL
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // If request is successful, update the main area with the loaded content
                    document.getElementById("content").innerHTML = xhr.responseText;
                } else {
                    // If request fails, display an error message
                    document.getElementById("content").innerHTML = "Error loading content.";
                }
            }
        };
        xhr.open("GET", url, true);
        xhr.send();
    }

    // Event listener for sidebar item clicks
    document.addEventListener("DOMContentLoaded", function() {
        // Get all sidebar items
        var sidebarItems = document.querySelectorAll(".links");

        // Add click event listener to each sidebar item
        sidebarItems.forEach(function(item) {
            item.addEventListener("click", function(event) {
                // Prevent default link behavior
                event.preventDefault();

                // Get the href attribute of the clicked item
                var url = this.getAttribute("data-url");

                // Load content dynamically
                loadContent(url);
            });
        });
    });
</script>




<?php include '../partials/footer.php'; ?>
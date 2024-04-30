   <!-- Search -->
   <div class="widget">
      <h5 class="widget-title"><span>Search</span></h5>
      <form action="search.php" class="widget-search">
         <input id="search-query" name="s" type="search" placeholder="Type &amp; Hit Enter...">
         <button type="submit" name="search"><i class="ti-search"></i>
         </button>
      </form>
   </div>

   <!-- categories -->
   <div class="widget">
      <h5 class="widget-title"><span>Categories</span></h5>
      <ul class="list-unstyled widget-list">
         <?php include 'category.php'; ?>
      </ul>
   </div>

   <!-- tags -->
   <div class="widget">
      <h5 class="widget-title"><span>Tags</span></h5>
      <ul class="list-inline widget-list-inline">
       <?php include 'tag.php'; ?>
      </ul>
   </div>


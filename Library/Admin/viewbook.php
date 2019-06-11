<?php require_once('includes/sessioncheck.php');
      require_once('includes/database.php');
      require_once('includes/book.php');
      require_once('includes/pagination.php');  

      $current_page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
      $per_page = 6;
      $count = Book::count_all();
 
      $pagination = new Pagination($current_page, $per_page, $count);

      $sql = "SELECT * FROM books ";
	  $sql .= "LIMIT {$per_page} ";
	  $sql .= "OFFSET {$pagination->offset()}";
	  $books = Book::find_by_sql($sql);

	  $lastPage = -1;
	  $booksInLastPage = -1;

	  if ($count % 6 != 0) {
	  	 $lastPage = $count / 6;
	     $lastPage = ceil($lastPage);
	     $booksInLastPage = $count % 6;
	  }
	 


?>
<!DOCTYPE html>
<html>
<head>
	<title>View Books</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>
<?php include_once('layouts/header.php') ?>


<div id="content">   
	<div id="booklist">
		<?php $counter = 0; ?>

		
			<?php  foreach($books as $book): 

				if(($counter % 3 == 0)) { echo "<div class=\"threebooks\">";}

			?>

				<div class="book"> 
					<?php echo "<a href=\"bookprofile.php?isbn={$book->isbn}\">";?>
					<img src="<?php echo $book->imagepath; ?>">
					<?php echo "</a>"; ?>
				</div>

			<?php 
			$counter++;   
			
			if(($counter == 3 || $counter == 6)) { echo "</div>"; }

			if($current_page == $lastPage && $counter == $booksInLastPage && $counter != 3 && $counter != 6) {
				echo "</div>";
			}
			                              
			endforeach; ?>

	</div>

	<div id="pagination">
		<?php

			if($pagination->total_pages() > 1) { // create pagination if total page is greater then 1.
				// code for previous button
				if($pagination->has_previous_page()) {
					// if we have prev page then go to viewbook and call the prev method this link is only available if you click the button bcs we wrap it with buttons.
					echo "<a href=\"viewbook.php?page=";
					echo $pagination->previous_page();
					echo "\"><button class=\"nextprev\">Previous</button> </a>";
				} else {
					echo "<button class=\"nextprev\">Previous</button>";
				}

				$total_pages = $pagination->total_pages();

				$twoBackFromCurrentPage = $current_page - 2;
				$oneBackFromCurrentPage = $current_page - 1;
				$current = $current_page;
				$oneFrontToCurrentPage = $current_page + 1;
				$twoFrontToCurrentPage = $current_page + 2;

				if($current_page - 3 > 0) {
					echo "<button id=\"current\">...</button>";
				}

				if ($twoBackFromCurrentPage > 0) {
					echo "<a href=\"viewbook.php?page={$twoBackFromCurrentPage}\" ><button>{$twoBackFromCurrentPage}</button></a>";
				}

				if ($oneBackFromCurrentPage > 0) {
					echo "<a href=\"viewbook.php?page={$oneBackFromCurrentPage}\" ><button>{$oneBackFromCurrentPage}</button></a>";
				}

				echo "<button id=\"current\">{$current_page}</button>";

				if ($oneFrontToCurrentPage <= $total_pages) {
					echo "<a href=\"viewbook.php?page={$oneFrontToCurrentPage}\" ><button>{$oneFrontToCurrentPage}</button></a>";
				}

				if ($twoFrontToCurrentPage <= $total_pages) {
					echo "<a href=\"viewbook.php?page={$twoFrontToCurrentPage}\" ><button>{$twoFrontToCurrentPage}</button></a>";
				}

				if ($current_page + 3 <= $total_pages) {
					echo "<button id=\"current\">...</button>";
				}


				// code for numbered button
	     	    // for($i = 1; $i <= $pagination->total_pages(); $i++) {

	     	    // 	if($i == $current_page) {
	     	    // 		echo "<button id=\"current\">{$i}</button>";
	     	    // 		// if i is in current page then don't create a link
	     	    // 	} else {
	     	    // 		echo "<a href=\"viewbook.php?page={$i}\" ><button>{$i}</button></a>";
	     	    // 		// else wrap the buttons inside the link.
	     	    // 	}
	     	    // }

	     	    // code for next button
				if($pagination->has_next_page()) {
					// when this button is clicked check whether it has a next page or not if it has a next page then call next page method 
					echo "<a href=\"viewbook.php?page=";
					echo $pagination->next_page();
					echo "\"><button class=\"nextprev\">Next</button> </a>";
				} else {
					// else if we don't have any next page then just create a button.
					echo "<button class=\"nextprev\">Next</button>";
				}

		}

		?>
			
	</div>  
	
</div>
<?php include_once('layouts/footer.php') ?>
<?php require_once('includes/sessioncheck.php');
	  require_once('includes/database.php');
      require_once('includes/book.php');
      require_once('includes/pagination.php');
      require_once('includes/students.php');

      if (isset($_GET['searchbtn']) && isset($_GET['searchcatagory']) && ($_GET['searchcatagory'] == "book" || $_GET['searchcatagory'] == "student") && !empty($_GET['search'])  ) { // if search btn is pressed, if search catagory is selected (it can be book or student) and if search box is not empty then check the next if that which catagory (book or student) is selected?

      	  if($_GET['searchcatagory'] == "book") { // condition for checking book
      	  	$searchword = trim($_GET['search']); // get the data enterd to search box and save it inside vr
      	  	$sql = "select count(*) from books where name like '%{$searchword}%' or isbn = '{$searchword}'";
      	  		// now we have the number of books that contain specific words and according to that we can create pagination.
      	  		// we should set the following vars to create pagination to show the result of query.
      	   	  $count = Book::count_by_sql($sql); // return count value ex: 7 result is one row one col
	      	  $current_page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
		      $per_page = 6;


		      $pagination = new Pagination($current_page, $per_page, $count);

		      $sql = "SELECT * FROM books where name like '%{$searchword}%' or isbn = '{$searchword}'";
			  $sql .= "LIMIT {$per_page} ";
			  $sql .= "OFFSET {$pagination->offset()}";

			  $books = Book::find_by_sql($sql);

      	  	

      	  } // end if condition for book

      	  if ($_GET['searchcatagory'] == "student") { // if codition for student.
      	  			// if student is selected then redirect to another page so we can show the std info and all pagination there . in this file pagination is created for the viewing books
      	  		 header("Location: searchstudent.php?searchcatagory={$_GET['searchcatagory']}&search={$_GET['search']}&searchbtn={$_GET['searchbtn']}");
      	  		 


      	  } // end if condition for student.



      } // end if condition for search box and btn and searchword. 
      else { // if no data is searched then redirect to viewbook page.
      		header("Location: viewbook.php");
      		exit();
      }

      

// vars needed to solve the problem of div in last page 

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
	<title>Add Book</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>

<?php include_once('layouts/header.php') ?>


<div id="content">
	<div id="booklist">
		<?php $counter = 0; ?>

		
			<?php  foreach($books as $book): 

				if(($counter % 3 == 0)) { echo "<div class=\"threebooks\">";}
				// foreach inside the html use : for opening and endforeach; for closing.

			?>

				<div class="book"> 
					<?php echo "<a href=\"bookprofile.php?isbn={$book->isbn}\">";?>
					<!-- if you click the link(img) then you will go to bookprofile.php and provide isbn of the selected img in the header -->
					<img src="<?php echo $book->imagepath; ?>">
					<!-- takes img from db -->
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
					echo "<a href=\"searchbookstudent.php?searchcatagory={$_GET['searchcatagory']}&search={$_GET['search']}&searchbtn=search&page=";
					echo $pagination->previous_page();
					echo "\"><button class=\"nextprev\">Previous</button> </a>";
				} else {
					echo "<button class=\"nextprev\">Previous</button>";
				}


				// code for numbered button
	     	    for($i = 1; $i <= $pagination->total_pages(); $i++) {

	     	    	if($i == $current_page) {
	     	    		echo "<button id=\"current\">{$i}</button>";
	     	    		// if i is in current page then don't create a link
	     	    	} else {
	     	    		echo "<a href=\"searchbookstudent.php?searchcatagory={$_GET['searchcatagory']}&search={$_GET['search']}&searchbtn=search&page={$i}\" ><button>{$i}</button></a>";
	     	    		// else wrap the buttons inside a link.
	     	    	}
	     	    }

	     	    // code for next button
				if($pagination->has_next_page()) {
					// when this button is clicked check whether it has a next page or not if it has a next page then call next page method 
					echo "<a href=\"searchbookstudent.php?searchcatagory={$_GET['searchcatagory']}&search={$_GET['search']}&searchbtn=search&page=";
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


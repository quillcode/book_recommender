<?php require_once('sessioncheck.php');
	  require_once('../admin/includes/database.php'); 
	  require_once('../admin/includes/book.php');
	  require_once('../admin/includes/pagination.php');
	  require_once('../admin/includes/students.php');


	  $id = $_SESSION['id'];
  	  $student = Student::find_by_id($id);

	   
	  
	  
	   if (isset($_GET['searchbtn']) && !empty($_GET['search'])  ) { // if search btn is pressed, and the search input is not empty 

	   		
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

			  $books = Book::find_by_sql($sql); // return rows of info for each book found by sql.
			
		

}   else{
	header("Location: index.php");
}

?>
<?php include_once('layouts/header.php') ?>
	<main class="content">


		 <?php 
		     $counter=1;  
			 foreach($books as $book):
		?>
		<a id="b<?php echo $counter;?>" href="bookprofile.php?isbn=<?php echo $book->isbn;?>">
		<img src="<?php echo "../Admin/$book->imagepath"; ?>" >
		</a>

		<?php 
			$counter++;
		
			 endforeach; ?>


		<?php if($pagination->total_pages() > 1){

			echo "<ul class=\"pagination\" id=\"page\" >";
			// code for previous page
			// echo "<a href=\"searchbookstudent.php?searchcatagory={$_GET['searchcatagory']}&search={$_GET['search']}&searchbtn=search&page=";
			if($pagination->has_previous_page()){
				echo "<li class=\"next_prev\"> <a href=\"search.php?&search={$_GET['search']}&searchbtn=search&page="; 
				echo $pagination->previous_page();
				echo "\">Prev</a></li>";
			}
			else{
				echo "<li class=\"next_prev\"><a>Prev</a></li> ";
			}


			//code for current page and other pages number
			for ($i=1; $i <= $pagination->total_pages() ; $i++) { 
				if($i == $current_page){
					echo "<li><a id=\"current\"> {$i}</a></li>";
				}
				else{
					echo "<li><a href=\"search.php?&search={$_GET['search']}&searchbtn=search&page={$i}\" >{$i}</a></li>";
				}
			}


		// code for next page
			
			if($pagination->has_next_page()){
				echo "<li class=\"next_prev\"> <a href=\"search.php?&search={$_GET['search']}&searchbtn=search&page=" ;
				echo $pagination->next_page();
				echo "\">Next </a></li>";
			}
			else{
				echo "<li class=\"next_prev\"><a>Next</a></li> ";
			}

			echo "</ul>";
		
		} 

		?>


	</main>
	
	<?php include_once('layouts/profile.php'); ?>

	<?php include_once('layouts/qoutes.php'); ?>
	<footer class="footer"> </footer>
</body>
</html>
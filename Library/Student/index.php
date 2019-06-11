<?php require_once('sessioncheck.php');
	  require_once('../admin/includes/students.php');
	  require_once('../admin/includes/issue_book_student.php');
	  require_once('../admin/includes/book.php');
	  require_once('../admin/includes/rated_book_student.php');

   $id = $_SESSION['id'];
   $student = Student::find_by_id($id);

   

	$newbooks = Book::new_books(); 

		

		/////////////////////////////////////////////////////////

   $books_isbns_and_student_ids = IssueBookStudent::find_isbns_by_id($student->id);
   	// find isbns for a specific students. (issued isbn)
    
   $books =  array();

   foreach ($books_isbns_and_student_ids as $isbn_id) {

   		$books[] = Book::find_by_isbn($isbn_id->isbn);
   		// return one row of book based on isbn. this row has cols...
   }

   // one last rated book
   $last_rated_book_student = RatedBookStudent::find_by_id($student->id);

   if($last_rated_book_student) {

	   	// get recommend isbn from python sever
   		// we send request to python server and the server send us common separated isbns
	   	$request = file_get_contents("http://localhost:8000/?isbn={$last_rated_book_student->isbn}");

		$isbnsArray = explode("," , $request);

		$recommandedbooks = array();

		// we get the first 3 books started from second book because the first book is the book that we rated
		for ($i=1; $i < 4; $i++) { 

			$recommandedbooks[] = Book::find_by_isbn($isbnsArray[$i]); // to get the 3 book from 1 indexed until 3.

		}

   } else {
   	// get most poppular isbns from python sever

	      	$request = file_get_contents("http://localhost:8000");
			$isbnsArray = explode("," , $request);

			$recommandedbooks = array();

			for ($i=0; $i < 3; $i++) { 

				$recommandedbooks[] = Book::find_by_isbn($isbnsArray[$i]); // to get the 3 book from 0 indexed until 2.

		}

   }

  
?>

<?php include_once('layouts/header.php') ?>

	<main class="general-content">

		<div id="issuedbooks">
			<h3>Books issued to you</h3>
		<?php 
			$counter = 1;
		 	foreach ($books as $book) {

		 		$rateBookStudent = RatedBookStudent::find_by_isbn_id($book->isbn, $student->id); 
		 		$rate = 0;
		 		if($rateBookStudent) {
		 			$rate = $rateBookStudent->rating;
		 		}

		 		echo "<div id=\"I{$counter}\" >";
			 		echo "<img src=\"../Admin/{$book->imagepath}\" >";

			 		// this div consist of five star for book each star is inside the btn and img and have id.
			 	  	echo "<div id=\"five_star\" data-for-this-book=\"isbn={$book->isbn}&id={$student->id}\">";
			 	  		// when the button is clicked(event) then changepic event is fired and pic will change
			 	  	for ($i=1; $i < 6; $i++) { 

			 	  		if ($i <= $rate) {
			 	  			echo "<button onclick=\"changepic(event)\"><img src=\"icons/selected.png\"  class=\"rating\" id=\"{$i}\"></button>";

			 	  		} else {
			 	  			echo "<button onclick=\"changepic(event)\"><img src=\"icons/unselected.png\"  class=\"rating\" id=\"{$i}\"></button>";
			 	  		}



			 	  	}
				 	
			 		echo "</div>";

		 		echo "</div>";

		 		$counter++;
		 	}

		?>
			<!-- <img src="images/book.png" id="I1">
			<img src="images/cbook.png" id="I2">
			<img src="images/cbook (2).png" id="I3"> -->
			
		</div>

		<div id="recommendedbooks">
			
			<?php
				if($last_rated_book_student) {
					echo "<h3> Books You may want to read</h3>";
				} else {
					echo "<h3> Popular books in library</h3>";
				}

			?>
			<a href="bookprofile.php?isbn=<?php echo $recommandedbooks[0]->isbn;?>">
				<img src="../Admin/<?php echo $recommandedbooks[0]->imagepath; ?>" >
			</a>

			<a href="bookprofile.php?isbn=<?php echo $recommandedbooks[1]->isbn;?>">
				<img src="../Admin/<?php echo $recommandedbooks[1]->imagepath; ?>" >
			</a>
			
			<a href="bookprofile.php?isbn=<?php echo $recommandedbooks[2]->isbn;?>">
				<img src="../Admin/<?php echo $recommandedbooks[2]->imagepath; ?>" >
			</a>
		</div>

		<div id="newbooks">
			<h3>New books added to Library</h3>

			<a href="bookprofile.php?isbn=<?php echo $newbooks[0]->isbn;?>">
				<img src="../Admin/<?php echo $newbooks[0]->imagepath; ?>" ></a>

			<a href="bookprofile.php?isbn=<?php echo $newbooks[1]->isbn;?>">
			<img src="../Admin/<?php echo $newbooks[1]->imagepath; ?>" ></a>

			<a href="bookprofile.php?isbn=<?php echo $newbooks[2]->isbn;?>">
			<img src="../Admin/<?php echo $newbooks[2]->imagepath; ?>" ></a>
		</div>

	</main>

		<?php include_once('layouts/profile.php'); ?>


		<?php include_once('layouts/qoutes.php'); ?>
	<footer class="footer"> </footer>

	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
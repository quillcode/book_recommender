<?php  
	   require_once('sessioncheck.php');
       require_once('../admin/includes/rated_book_student.php');
       require_once('../admin/includes/book.php');
       require_once('../admin/includes/issue_book_student.php');



if(isset($_GET['id']) && isset($_GET['isbn']) && isset($_GET['rating'])) {

	$id = trim($_GET['id']);
	$isbn = trim($_GET['isbn']);
	$rating = trim($_GET['rating']);

	$request = file_get_contents("http://localhost:8000/?isbn={$isbn}");

	$isbnsArray = explode("," , $request);


	$rated_book_student = RatedBookStudent::find_by_isbn_id($isbn, $id); // to find rating for book

	if($rated_book_student) { // if there is rating for book then
		$rated_book_student->rating = $rating; // update that rating with $rating
		$rated_book_student->update();
	} else {
		 // else create a new object and insert all of the data for its fields.
		$rated_book_student = new RatedBookStudent();

		$rated_book_student->id = $id;
		$rated_book_student->isbn = $isbn;
		$rated_book_student->rating = $rating;

		$rated_book_student->create();
	}






	$books = array();

	for ($i=1; $i < 4; $i++) { 

		$book = Book::find_by_isbn($isbnsArray[$i]); // to get the 3 book from 0 indexed until 2.

		$books[] = $book; // return 3 book records to the objects.
	}
		
	
		echo "<h3>Books You may want to read</h3>";

		// if (!IssueBookStudent::isIssuedToUser($books[0]->isbn, $id)) {

		// 	echo "<a href=\"bookprofile.php?isbn={$books[0]->isbn}\">  <img src=\"../Admin/{$books[0]->imagepath}\"><a>" ;
		// }

		// if (!IssueBookStudent::isIssuedToUser($books[1]->isbn, $id)) {
		// 	 echo "<a href=\"bookprofile.php?isbn={$books[1]->isbn}\"> <img src=\"../Admin/{$books[1]->imagepath}\" >  <a>" ;
		// }

		// if (!IssueBookStudent::isIssuedToUser($books[2]->isbn, $id)) {
		// 	echo "<a href=\"bookprofile.php?isbn={$books[2]->isbn}\"> <img src=\"../Admin/{$books[2]->imagepath}\"><a>" ;
		// }


		if (!IssueBookStudent::isIssuedToUser($books[0]->isbn, $id)) {

			echo "<img src=\"../Admin/{$books[0]->imagepath}\" >";
		}

		if (!IssueBookStudent::isIssuedToUser($books[1]->isbn, $id)) {
			echo "<img src=\"../Admin/{$books[1]->imagepath}\" >";
		}

		if (!IssueBookStudent::isIssuedToUser($books[2]->isbn, $id)) {
			echo "<img src=\"../Admin/{$books[2]->imagepath}\" >";
		}
		
		
}


?>


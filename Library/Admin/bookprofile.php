<?php require_once('includes/sessioncheck.php');
	  require_once('includes/database.php');
      require_once('includes/book.php');
      require_once('includes/issue_book_student.php');
      require_once('includes/students.php');

	  $message = "";
	  $show = "";
	
	// first if -> to show all the info of the isbn sent in header.
	if(isset($_GET['isbn'])) { // if there is isbn in the header or GET array then
		$isbn = $_GET['isbn']; // get it and save it inside the $isbn variable.

		$book = Book::find_by_isbn($isbn); // return all info of an isbn.

		if(!$book) { // if it returns false then go to viewbook.php means if we send an isbn that is not in our database then we will be redirected to the viewbook page
			header("Location: viewbook.php");
		    exit(); // output the message before exiting.
		} // 1st if ended.
	} // 2nd if ended
	else {
		header("Location: viewbook.php"); // else redirect to viewbook.php (if there is no isbn)
		exit();
	}


	// 2nd if to do the delete of the current isbn.
	if(isset($_GET['isbn']) && isset($_GET['delete'])) { // when the delete value is pressed it sends 2 things delete value and the isbn  

		$isbn = $_GET['isbn']; // get the isbn
		$book = Book::find_by_isbn($isbn); // find the book and save it in $book

		if(!$book) {
			header("Location: viewbook.php"); // if the book is not found by sending isbn the redirect to viewbook page. and exit.
		    exit(); // output a message and terminate the current script.
		}

		$book->delete(); // if book found then call delete method.
		unlink($book->imagepath); // this method is used to delete the image of the book from the folder in 								which we store our images.
		IssueBookStudent::delete_by_isbn($book->isbn); // also delete from issued books...
		header("Location: viewbook.php"); // and after deletion redirect to viewbook page.
		exit(); // terminate the script.


	}

	// code for issubtn.
	if(isset($_POST['issuebtn'])){ // if issuebtn is pressed then

		$id = trim($_POST['stdid']);
		$isbn = trim($_POST['isbn']);

		// find book by isbn 
		$issuebook = Book::find_by_isbn($isbn); // retreive the book from database
		$student = Student::find_by_id($id); // retrieve the student from database
		$numOfIssue = IssueBookStudent::count_by_id_isbn($id,$isbn); // retrieve the student book record from database. (this table shows which book is issued to std.)


		// check is it copy field 
		// if it is zero show warning msg 
		if(!$issuebook || $issuebook->numofcopy == 0) { // if not any isbn is found(so issuebook object will be null) or the numofcopy is 0 
			$message = "No copy of this book is available in library";
		}else if(!$student){ // if std didn't find then object will be null or false
			$message = "invalid id";
		} else if($numOfIssue > 0) {
			$message = "the book is already issued to the student";
		}
		else {

			$book_std = new IssueBookStudent();
			$book_std->isbn = trim($_POST['isbn']);
			$book_std->id = trim($_POST['stdid']);
			$book_std->create(); // insert isbn and stdid
			$message = "book has been issued.";
			$issuebook->numofcopy--; 
			$issuebook->update();
			 $book = $issuebook; // ???

		}
			// css class
			$show = "js-show";
		
		
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Book profile</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">
	

</head>

<?php include_once('layouts/header.php') ?>


<div id="content">
	<p id="message" class="<?php echo $show ; ?>"><?php echo $message; ?></p>
	<div id="bkprofile">
		<div id="totalprofile">
		<img src="<?php echo $book->imagepath ; ?>" id="description_id">
		<div id="description">
			<div>
				<label>Name: </label><p><?php echo $book->name; ?></p>
			</div>
			<div>
				<label>Publisher:</label> <p><?php echo $book->author; ?></p>
			</div>
			<div>
				<label>Date:</label><p><?php echo $book->yearofpub; ?></p>
			</div>
			<div>
				<label>Category:</label> <p><?php echo $book->catagory; ?></p>
			</div>
			<div>
				<label>ISBN:</label><p><?php echo $book->isbn; ?></p>
			</div>
			<div>
			<?php
				// find count of issued copies ofthis book by isbn from issue_book_student table
			    // $bookCoutn = IssueBookStd::find_count_by_isbn($isbn);



			?>
	
			<label>Copies:</label> <!-- total num of copies -->
				<p><?php  $remain = $book->numofcopy;
						   $issued = IssueBookStudent::find_count_by_isbn($isbn);
						   $total = $remain + $issued;
						   echo $total;
				 ?></p>
			</div>

			<div>
				<label>Remaining:</label> <!-- The num of copies of a specific book remaining in library -->
				<p><?php echo $book->numofcopy ?></p>
			</div>

			<div>
				<label>Issued:</label> <!-- num of issued -->
				<p><?php $bookCount = IssueBookStudent::find_count_by_isbn($isbn);
				echo $bookCount; ?></p>
			</div>


		</div>
	 </div>

		
		<div id="bottomdiv">
		<div id="ctrlbtn">
			<a href="updatebook.php?isbn=<?php echo $book->isbn ?>">
			<button id="updatebtn">Update</button>
		    </a>

			<a href="bookprofile.php?delete=delete&isbn=<?php echo $book->isbn; ?>">
			<button id="deletebtn" onclick=" confirmDeletion(event);">Delete</button>
		    </a>
		</div>

		<div>
		<form id="issue_form" action="bookprofile.php?isbn=<?php echo $book->isbn; ?>" method="post">
				<label>Enter User ID</label>
				<input type="hidden" name="isbn" value="<?php echo $book->isbn ?>">
				<input type="text" name="stdid">
				<input type="submit" name="issuebtn" value="Issue" id="issuebookBtn">

		</form>
		</div>
	</div>


	</div>
</div>

<script src="js/main.js"></script>
<script>
	function confirmDeletion(event) {
		var result = confirm("do you really want to delete the book!");

		if(result == false) {
			event.preventDefault();
		}

	}
</script>
<?php include_once('layouts/footer.php')?>
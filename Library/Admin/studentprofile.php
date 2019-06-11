<?php require_once('includes/sessioncheck.php');
	  require_once('includes/database.php');
      require_once('includes/students.php');
      require_once('includes/issue_book_student.php');
      require_once('includes/book.php');

      
	
      // if id is send in get array header then do the following
      if(isset($_GET['id'])){
      	// get id and save it inside the $id var
      	$id = $_GET['id'];

      	$student = Student::find_by_id($id);

      	// first get records from issue book using student id to find all the books issued for a student.
      	$bks_student = IssueBookStudent::find_isbns_by_id($student->id);

      	// then get all records of books using the isbns in bks_student and later we will use these isbns to get the image path of these isbns.
      	$books = Book::find_books_by_isbn($bks_student);



      		if(!$student){
      			header("Location: viewstudent.php");
      			exit();
      		}
      		 }
      	else{
      		header("Location: viewstudent.php");
      		exit();
      	}

      	// if delete button is pressed it send delete and id value check if these are send in header.
      	if(isset($_GET['delete']) && isset($_GET['id'])){
      		// get the id and find it
      		$id = $_GET['id'];
      		$student = Student::find_by_id($id); // find the std and save it inside the $student object

      		if(!$student){
      			header("Location: viewstudent.php");
      			exit(); 
      		}

      		$student->delete();

      		header("Location: viewstudent.php");
      		exit();
	}

	// code for return button
	if(isset($_GET['return']) && isset($_GET['id']) && isset($_GET['isbn']) ){
		
		IssueBookStudent::delete_by_isbn_id(trim($_GET['isbn']), trim($_GET['id']));
		// header("Location: studentprofile.php?id=<?php echo $student->id;
		$bks_student = IssueBookStudent::find_isbns_by_id($student->id);
      	// then get all records of books using the isbns in bks_student and later we will use these isbns to get the image path of these isbns.
      	$books = Book::find_books_by_isbn($bks_student);
      	
      	$isbn = $_GET['isbn'];
      	$book = Book::find_by_isbn($isbn);
      	$book->numofcopy++;
      	$book->update();

      	


	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Student profile</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>

<?php include_once('layouts/header.php') ?>


<div id="content">
	<div id="bkprofile">
		<div id="stdescription">
			<div>
				<p class="stdclass"> ID : &nbsp; <?php echo $student->id; ?></p>
			</div>
			<div>
				<p class="stdclass">Firstname : &nbsp; <?php echo $student->firstname; ?></p>
			</div>
			<div>
				<p class="stdclass">Lastname : &nbsp; <?php echo $student->lastname; ?></p>
			</div>
			<div>
				<p class="stdclass">Username :&nbsp; <?php echo $student->username; ?></p>
			</div>
			<div>
				<p class="stdclass">Password : &nbsp;<?php echo $student->password; ?></p>
			</div>
			<div>
			<p class="stdclass">Gender : &nbsp;<?php echo $student->gender; ?></p>
			</div>
			<div>
			<p class="stdclass">Faculty :&nbsp;<?php echo $student->faculty; ?></p>
			</div>
			<div>
			<p class="stdclass">Semester :&nbsp; <?php echo $student->semester; ?></p>
			</div>

		</div>

		<div id="stdctrlbtn">
			<a href="updatestudent.php?id=<?php echo $student->id; ?>">
			<button id="updatebtn">Update</button>
		    </a>

			<a href="studentprofile.php?delete=delete&id=<?php echo $student->id; ?>">
			<button id="deletebtn">Delete</button>
		    </a>
		</div>

	</div>

	<div id="issuedbookforstd">

		<?php
			foreach ($books as $book): ?>

		<div class="onebook">
		<a href="bookprofile.php?isbn=<?php echo $book->isbn; ?>">
		<img src="<?php echo $book->imagepath; ?>"
		</a>
		<a href="studentprofile.php?return=return&id=<?php echo $student->id;?>&isbn=<?php echo $book->isbn?>">
		<button>return</button>
		</a>
	    </div>

	<?php endforeach; ?>

	</div>
</div>
<?php include_once('layouts/footer.php')?>
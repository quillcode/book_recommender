<?php require_once('includes/sessioncheck.php');
require_once('includes/database.php');
require_once('includes/book.php');

	$message = "";  

	if(isset($_GET['isbn'])) { // if isbn is send in query string then get it and create and obj

		$book = Book::find_by_isbn($_GET['isbn']);

		if(!$book) { // if it send any isbn that is not present in db then redirect to viewbook page.
			header("Location: viewbook.php");
		    exit();
		} // 2nd if end
	}// 1st if end
	 else { // if no data is send then redirect to viewbook page.
		header("Location: viewbook.php");
		exit();
	}

	// you can use the following technique if you don't want to send
	// get data for isbn when submitting the form.


	// if(isset($_POST['isbn'])) {
	// 	$isbn = $_POST['isbn'];

	// 	$book = Book::find_by_isbn($isbn);

	// 	if(!$book) {
	// 		header("Location: viewbook.php");
	// 	    exit();
	// 	}
	// }


// check if book is submitted (submit btn is pressed)
 if(isset($_POST['update_book'])){


// check if all fields are present
 	if(!empty($_POST['isbn']) && !empty($_POST['book_name']) && !empty($_POST['number']) && !empty($_POST['author']) &&  !empty($_POST['catagory']) ){

 		//if present create an object and get the data of all fields

 		$upbook = new Book();

 		$upbook->isbn = $_POST['isbn'];
 		$upbook->name = $_POST['book_name'];
 		$upbook->author = $_POST['author'];

 		if (!empty($_POST['date'])) {
 			$upbook->yearofpub = $_POST['date'];
 		} else {
 			$upbook->yearofpub = $book->yearofpub;
 		}
 		
 		$upbook->numofcopy = $_POST['number'];
 		$upbook->catagory = $_POST['catagory'];

 		if (!empty($_FILES['photo']['name'])) {
 			$upbook->imagepath = "images/".$_FILES['photo']['name'];
 			move_uploaded_file($_FILES['photo']['tmp_name'], "images/".$_FILES['photo']['name']);
 		} else {
 			$upbook->imagepath = $book->imagepath;
 		}
 		
 		$upbook->update(); // update the data in database.
 		header("Location: bookprofile.php?isbn={$upbook->isbn}"); // after updating redirect to bookprofile page.
		exit();
	

 
 		}else{
 		$message = "please fill all the fields!!";
 	}

 }


?>
<!DOCTYPE html>
<html>
<head>
	<title>Update Book</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>

<?php  include_once('layouts/header.php'); ?>

<div id="content">
	<p id="message"><?php echo $message; ?></p>
	<form id="addbook" method="post" action="updatebook.php?isbn=<?php echo $book->isbn ?>" enctype="multipart/form-data"> 
		<!-- in action attribut we send isbn data in query string when submitting the form because the script must be able to find this book in database by using isbn and create an object, if we don't send this isbn the script can't find the book in database and thus can't create the book object and we will face a lot of errors because we heavily use the book object in our form -->
		<label>ISBN</label>
		<input type="text" disabled value="<?php echo trim($book->isbn);?> ">
		<input type="hidden" name="isbn" value="<?php echo trim($book->isbn); ?>">
		<label>Book Name</label>
		<input type="text" name="book_name" value="<?php echo $book->name;?>">
		<label>Number of copy</label>
		<input type="number" name="number" value="<?php echo $book->numofcopy;?>">
		<label>Author</label>
		<input type="text" name="author" value="<?php echo $book->author;?>">
		<label>Year of Publication</label>
		<input type="text" name="date" value="<?php echo $book->yearofpub;?>">
		<label>Add image</label>
		<input type="file" name="photo" id="file">
		<label>Category</label>
		<input type="text" name="catagory" value="<?php echo $book->catagory;?>">
		<input type="submit" class="submit" name="update_book" value="Update Book">
	</form>
</div>

<?php include_once("layouts/footer.php");
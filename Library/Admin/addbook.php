<?php 
require_once('includes/sessioncheck.php');
require_once('includes/database.php');
require_once('includes/book.php');

	function clean($str){
		$str = trim($str);
		return $str;
	}

	$message = "";
	$isfill = false; // by default fields are empty we use this if one or more fields are left empty then we will not add book isfill should be true to add book.
	$show = "";

// check if book is submitted
 if(isset($_POST['add_book'])){


// check if all fields are present
 	if(!empty($_POST['isbn']) && !empty($_POST['book_name']) && !empty($_POST['number']) && !empty($_POST['author']) && !empty($_POST['date']) && !empty($_FILES['photo']['name']) && !empty($_POST['catagory']) ){

 		//if all fields have data then get the data of all fields
 		// create a book object and assign data to obj

 		$book = new Book();

 		$book->isbn 	= clean($_POST['isbn']);
 		$book->name 	= clean($_POST['book_name']);
 		$book->author 	= clean($_POST['author']);
 		$book->yearofpub= clean($_POST['date']);
 		$book->numofcopy= clean($_POST['number']);
 		$book->catagory = clean($_POST['catagory']);
 		$book->imagepath= "images/".$_FILES['photo']['name'];
 		// save the data in database.
 		$book->create();
 		move_uploaded_file($_FILES['photo']['tmp_name'], "images/".$_FILES['photo']['name']); // files by defualt are saved in defalut directory but to move them into our sepecified folder we should use this method.


 		$message = "book has been saved in database";
 		$isfill = true; // when the fields are fill 
 		
 	}else{
 		$message = "Please fill all the fields!!";
 	}

 		$show = "js-show";
 }
?>

<!DOCTYPE html>   
<html>
<head>
	<title>Add Book</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>


<?php  include_once('layouts/header.php'); ?>

<div id="content">
	<p id="message" class="<?php echo $show ; ?>"><?php echo $message; ?></p>
	<form id="addbook" method="post" action="addbook.php" enctype="multipart/form-data">
		<label>ISBN</label>
		<input type="text" name="isbn" value="<?php echo isset($_POST['isbn']) && !$isfill ? $_POST['isbn'] : ""; ?>">
		<label>Book Name</label>
		<input type="text" name="book_name" value="<?php echo isset($_POST['book_name']) && !$isfill ? $_POST['book_name'] : "" ?>">
		<label>Number of copy</label>
		<input type="number" name="number" value="<?php echo isset($_POST['number']) && !$isfill ? $_POST['number'] : ""; ?>">
		<label>Publisher</label>
		<input type="text" name="author" value="<?php echo isset($_POST['author']) && !$isfill ? $_POST['author'] : ""; ?>">
		<label>Year of Publication</label>
		<input type="text" name="date" value="<?php echo isset($_POST['date']) && !$isfill ? $_POST['date'] : ""; ?>">
		<label>Add image</label>
		<input type="file" name="photo" id="file">
		<label>Category</label>
		<input type="text" name="catagory" value="<?php echo isset($_POST['catagory']) && !$isfill ? $_POST['catagory'] : ""; ?>">
		<input type="submit" class="submit" name="add_book" value="Add Book">
	</form>
</div>

<script src="js/main.js"></script>
<?php include_once("layouts/footer.php");
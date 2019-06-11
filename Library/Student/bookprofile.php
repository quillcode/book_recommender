<?php require_once('sessioncheck.php');
	  require_once('../admin/includes/students.php');
	  require_once('../admin/includes/book.php');
   
   $id = $_SESSION['id'];
   $student = Student::find_by_id($id);

  if(isset($_GET['isbn'])) { // if there is isbn in the header or GET array then
		$isbn = $_GET['isbn']; // get it and save it inside the $isbn variable.

		$book = Book::find_by_isbn($isbn); // return all info of an isbn.

		if(!$book) { // if it returns false then go to viewbook.php means if we send an isbn that is not in our database then we will be redirected to the viewbook page
			header("Location: search.php");
		    exit(); // output the message before exiting.
		} // 1st if ended.
	} // 2nd if ended
	else {
		header("Location: search.php"); // else redirect to viewbook.php (if there is no isbn)
		exit();
	}

?>
<?php include_once('layouts/header.php') ?>
	<main class="content">

		<img src="<?php echo "../Admin/$book->imagepath"; ?>" id="bkprofile">

		<div id="bkpro_content">
			<p><span>Name</span> &nbsp;&nbsp;: <?php echo $book->name; ?></p>
			<p><span>Publisher</span> &nbsp;&nbsp;: <?php echo $book->author; ?></p>
			<p><span>Publication Date</span> : <?php echo $book->yearofpub; ?></p>
			<p><span>ISBN</span> &nbsp;&nbsp;: <?php echo $book->isbn; ?></p>
			<p><span>Category</span> : <?php echo $book->catagory; ?></p>
		</div>
	

	</main>
		<?php include_once('layouts/profile.php'); ?>

	<?php include_once('layouts/qoutes.php'); ?>
	<footer class="footer"> </footer>
</body>
</html>
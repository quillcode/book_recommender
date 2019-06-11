<?php require_once('includes/sessioncheck.php'); 
	  require_once('includes/book.php');
	  require_once('includes/students.php');
	  require_once('includes/issue_book_student.php');
	  ?>
<?php
// note : when we don't use the class methods several times for different purposes and calling different methods, then there is no need to create object of it just call directly ... 

// find all books and divide by four
// get the result
 $bookcount = Book::all_total_copies(); // we dont use count all for books cause book have many copies.
 $onefourth_book = floor($bookcount/4);

$stdcount = Student::count_all();
$onefourth_std = floor($stdcount/4);

$issued_books = IssueBookStudent::count_all();  
$height = (380*$issued_books)/$bookcount;

$std_holdingbks = IssueBookStudent::count_unique();
$height2 = (380*$std_holdingbks)/$bookcount;


?>
<!DOCTYPE html>
<html>
<head>
	<title>Book profile</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">
<style>
	#graph_container {
		position: relative;
		width: 800px;
		height: 500px;
		border: 1px solid black;
		margin: 0 auto;
		margin-top: 70px;
		background-color: #2f283e;

	}
	#boxes{
		padding-top: 450px;
	}
	.graph {
		width: 320px;
		height: 390px;
		bottom: 65px;
		border-left: 1px solid white;
		border-bottom: 1px solid white;

	}
	div#books_graph {
		position: absolute;
		left: 70px;
	}
	#students_graph {
		position: absolute;
		left: 470px;

	}

	.bar {

		width: 100px;
		border: 1px solid black;
		position: absolute;
		bottom: 0;
		border-bottom: none;
		transform: scale(1, 0);
	}
	.grow{
		transition-property: transform;
        transition-duration: 1000ms;
        transition-timing-function: ease-in-out;
        transition-delay: 300ms;
        

        transform: scale(1, 1);
        transform-origin: bottom center;
	}

	#total_books {
		height: 380px;
		left: 50px;
		background-color: #ffc107;
		border: none;

	}

	#issue_books {
		<?php echo 'height:'. $height . 'px'; ?>;
		left: 200px;
		background-color: #71ca6b;
		border: none;

	}

	#total_students {

		height: 380px;
		left: 50px;
		background-color: #009688;
		border: none;

	}

	#issue_students {

		<?php echo 'height:'. $height2 . 'px'; ?>;
		left: 200px;
		background-color: #ca0404;
		border: none;

	}

	div#graph_container label {
		position: absolute;
		display: block;
		width: 60px;
		margin: 0;
		padding:0;
		direction:rtl;
		background-color: #2f283e;
		color: white;
	}

	/* 450-50 fifth label start
		400/4 = 100 but we will add 95 not 100 cuase
	 */
	#fifth {

		top:50px;
		left: 10px;
	}
	#fourth {
		top:145px;
		left: 10px;

	}
	#third {
		top:240px;
		left: 10px;

	}
	#second {
		top:335px;
		left: 10px;

	}

	#first {
		top: 420px;
		left: 10px;

	}

	#stdfifth{
		top: 50px;
		left: 410px;
	}
	#stdfourth {
		top:145px;
		left: 410px;

	}
	#stdthird {
		top:240px;
		left: 410px;

	}
	#stdsecond {
		top:335px;
		left: 410px;

	}

	#stdfirst {
		top: 420px;
		left: 410px;

	}
	div#totalbook_box{
		height: 25px;
		width: 25px;
		margin-left: 50px;
   		background-color: #ffc107;
	}
	div#issuedbook_box{
		height: 25px;
		width: 25px;
		margin-left: 50px;
		background-color: #71ca6b;
	}
	div#totalstd_box{
		height: 25px;
		width: 25px;
		margin-left: 50px;
		background-color: #009688;
	}
	div#issuedtostd_box{
		height: 25px;
		width: 25px;
		margin-left: 50px;
		background-color: #ca0404;
	}

	#boxes div{
		display: inline-block;
	}
	span{
		padding-left: 5px;
		color: white;
	}
	

</style>

<script>
        window.onload = init;

        function init() {
            let bar = document.querySelectorAll('.bar');
            bar.forEach((el, index)=>{
                el.classList.add('grow');
            });
        }
    </script>

</head>

<?php include_once('layouts/header.php') ?>


<div id="content">


	<div id="graph_container">


		<label id="fifth">- <?php echo $onefourth_book*4; ?></label>  <!-- // result * 4 -->
		<label id="fourth">- <?php echo $onefourth_book*3; ?></label> <!-- // result * 3 -->
		<label id="third">- <?php echo $onefourth_book*2; ?></label> <!-- // result * 2 -->
		<label id="second">- <?php echo $onefourth_book*1; ?></label> <!-- // count/4 = result  -->
		<label id="first">- 0</label>


		<div id="books_graph" class="graph">

			<div id="total_books" class="bar">
				
			</div>

			<div id="issue_books" class="bar">
				
			</div>
			
		</div>
		

		<label id="stdfifth">- <?php echo $onefourth_std*4; ?></label>  
		<label id="stdfourth">- <?php echo $onefourth_std*3; ?></label> 
		<label id="stdthird">- <?php echo $onefourth_std*2; ?></label> 
		<label id="stdsecond">- <?php echo $onefourth_std*1; ?></label> 
		<label id="stdfirst">- 0</label>

		<div id="students_graph" class="graph">

			<div id="total_students" class="bar">
				
			</div>

			<div id="issue_students" class="bar">
				
			</div>
			
		</div>

		<div id="boxes">

		<div id="totalbook_box"></div><span>Total Books</span>
		<div id="issuedbook_box"></div><span>Issued Books</span>
		<div id="totalstd_box"></div><span>Total Student</span>
		<div id="issuedtostd_box"></div><span>Students holding Books</span>

		</div>

	</div>

</div>
<?php include_once('layouts/footer.php')?>
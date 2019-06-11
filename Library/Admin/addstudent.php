<?php
 require_once('includes/sessioncheck.php');
 require_once("includes/database.php"); // provide fatal error and stop script.
 require_once("includes/students.php");


	  $message = "";
	  $isfill = false;
	  $show = "";
	  // is form is submitted? if submitted than process it 

	  if(isset($_POST['add_std'])) { // is add_std button pressed.


	  	// check if any feild is empty

	  		if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['id']) && !empty($_POST['user_name']) && !empty($_POST['password']) && isset($_POST['gender']) && !empty($_POST['faculty']) && !empty($_POST['semester'])) {

	  			//if all feilds is filled get data from post array
	  		  
	  			$firstname = trim($_POST['first_name']);
		  		$lastname  = trim($_POST['last_name']);
		  		$id 	   = trim($_POST['id']);
		  		$username  = trim($_POST['user_name']);
		  		$password  = trim($_POST['password']);
		  		$gender    = trim($_POST['gender']);
		  		$faculty   = trim($_POST['faculty']);
		  		$semester  = trim($_POST['semester']);

		  		// if not empty create a student object from this data
	  			$student = new Student();
	  			$student->id 		= $id;
	  			$student->firstname = $firstname;
	  			$student->lastname  = $lastname;
	  			$student->username  = $username;
	  			$student->password  = $password;
	  			$student->gender    = $gender;
	  			$student->faculty   = $faculty;
	  			$student->semester  = $semester;

	  			$student->create(); // insert these data to database.

	  			$message = "student has been saved in database";
	  			$isfill = true;
	  			// else prompte the user to fill in blanks
	  		} else {
	  			$message = "please fill all the fields!!";
	  		}
	  		$show = "js-show";
	  }

?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Student</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>

<?php include_once('layouts/header.php'); ?>

<div id="content">



<p id="message" class="<?php echo $show ; ?>"><?php echo $message; ?></p>
 
	<form id="addstd" method="post" action="addstudent.php">
	<div class="namediv" id="firstdiv">
		<label>First Name</label>
		<input type="text" name="first_name" id="fname" value="<?php echo isset($_POST['first_name']) && !$isfill ? $_POST['first_name'] : ""; ?>">
		<!-- if the firstname value is set and the cell is filled then echo the previous value else echo an empty string , we do this bcz if we add the book but not all fields are filled then the fields that we filled before should be echoed again.-->
	</div>
	<div class="namediv" id="lastdiv">
		<label>Last Name</label>
		<input type="text" name="last_name" id="lname" value="<?php echo isset($_POST['last_name'])  && !$isfill ? $_POST['last_name'] : ""; ?>">
	</div>
		<label id="idlabel">ID</label>
		<input type="text" name="id" id="stdid"  value="<?php echo isset($_POST['id'])  && !$isfill ? $_POST['id'] : ""; ?>">
		<label>Username</label>
		<input type="text" name="user_name" id="uname" value="<?php echo isset($_POST['user_name'])  && !$isfill ? $_POST['user_name'] : ""; ?>">
		<label>Password</label>
		<input type="password" name="password" id="password">
	<div id="radiodiv">
		<input type="radio" name="gender" value="male" class="gender" <?php if(isset($_POST['gender']) && $_POST['gender'] == "male"  && !$isfill) { echo "checked";}   ?>><label>Male</label>	
		<input type="radio" name="gender" value="female" class="gender" <?php if(isset($_POST['gender']) && $_POST['gender'] == "female"  && !$isfill) { echo "checked";}   ?>><label>Female</label>
	</div>
		<label>Faculty</label>
		<input type="text" name="faculty" id="faculty" value="<?php echo isset($_POST['faculty'])  && !$isfill ? $_POST['faculty'] : ""; ?>">
		<label>Semester</label>
		<select name="semester">
			<option value="">select a semester</option>
			<option value="1">Semester 1</option>
			<option value="2" >Semester 2</option>
			<option value="3">Semester 3</option>
			<option value="4">Semester 4</option>
			<option value="5">Semester 5</option>
			<option value="6">Semester 6</option>
			<option value="7">Semester 7</option>
			<option value="8">Semester 8</option>
			<option value="9">Semester 9</option>
			<option value="10">Semester 10</option>
		</select>
		<input type="submit" name="add_std" class="submit" value="Add Student">	
	</form>


</div>
<script src="js/main.js"></script>
<?php include_once("layouts/footer.php");
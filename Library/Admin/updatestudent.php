<?php require_once('includes/sessioncheck.php');
	  require_once("includes/database.php"); // provide fatal error and stop script.
	  require_once("includes/students.php");


	  $message = "";
	 // check if isbn is sent in header.
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$student = Student::find_by_id($id);

		if(!$student){
			header("Location: viewstudent.php");
			exit();
		}
	}
	else{
		header("Location: viewstudent.php");
		exit();
	}

	// check if update button is pressed
	if(isset($_POST['update_std'])){

		// check if all fields are filled
		if(!empty($_POST['first_name']) && !empty($_POST['last_name']) && !empty($_POST['id']) && !empty($_POST['user_name']) && !empty($_POST['password']) && isset($_POST['gender']) && !empty($_POST['faculty']) && !empty($_POST['semester'])){

			// if filled then create an object update the data in db.
			$upstudent = new Student();
			$upstudent->id = $_POST['id'];
			$upstudent->firstname = $_POST['first_name'];
			$upstudent->lastname = $_POST['last_name'];
			$upstudent->username = $_POST['user_name'];
			$upstudent->password = $_POST['password'];
			$upstudent->gender = $_POST['gender'];
			$upstudent->faculty = $_POST['faculty'];
			$upstudent->semester = $_POST['semester'];

			$upstudent->update(); // update the student
			header("Location: studentprofile.php?id={$upstudent->id}");
			exit();

		}
		else{
			$message = "please fill all the fields!";
		}

	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Update Student</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>

<?php include_once('layouts/header.php'); ?>

<div id="content">



<p id="message"><?php echo $message; ?></p>
 
	<form id="addstd" method="post" action="updatestudent.php?id=<?php echo $student->id; ?>" enctype="multipart/form-data">
		<!-- in action attribute we send id which we get from $_GET and send it to db when the form is submitted bcs the script must be able to find student in database by using the isbn sent in form and create and object. -->

	<div class="namediv" id="firstdiv">
		<label>First Name</label>
		<input type="text" name="first_name" id="fname" value="<?php echo $student->firstname; ?>">
		</div>

	<div class="namediv" id="lastdiv">
		<label>Last Name</label>
		<input type="text" name="last_name" id="lname" value="<?php echo $student->lastname; ?>">
	</div>
		<label id="idlabel">ID</label>
		<input type="text" name="id" id="stdid"  value="<?php echo $student->id; ?>">
		<label>Username</label>
		<input type="text" name="user_name" id="uname" value="<?php echo $student->username; ?>">
		<label>Password</label>
		<input type="password" name="password" id="password" value="<?php echo $student->password; ?>">
	<div id="radiodiv">
		<input type="radio" name="gender" value="male" class="gender" ><label>Male</label>	
		<input type="radio" name="gender" value="female" class="gender" ><label>Female</label>
	</div>
		<label>Faculty</label>
		<input type="text" name="faculty" id="faculty" value="<?php echo $student->faculty; ?>">
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
		<input type="submit" name="update_std" class="submit" value="Update Student">	
	</form>


</div>

<?php include_once("layouts/footer.php");
<?php 
session_start();
 
	
	if(isset($_POST['submit'])) {

		$username = $_POST['username'];
		$password = $_POST['password'];

		if($username == "safia" && $password == "zadran") {

			$_SESSION['user'] = "safia";
			header("Location: index.php");
			exit();
			
		}
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/login.css">
	
</head>
<body>

<form  action="login.php" method="post">
	<p>Login</p>
	<input class="form_input" type="text" name="username" placeholder="Enter Username">
	<input class="form_input" type="password" name="password" placeholder="Enter Password">
	<input id="subbtn" type="submit" name="submit" value="Login">
</form>

</body>
</html>



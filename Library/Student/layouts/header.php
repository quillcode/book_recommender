<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">

	<style type="text/css">
		#issuedbooks #five_star button {
			margin: 0;
			padding: 0;
			border:none;
			width: 20px;
			height: 18px;
			outline:none;
		}
		#issuedbooks #five_star button img {
			padding: 0;
			margin: 0;
			width: 100%;
			height: 100%;
		}
</style>

</head>
<body class="grid">
	<header class="header">
		<span style="padding-top: 7px; padding-left: 20px;"><a href="index.php"><img src="images/home.ico"></a></span>
		<form id="navform" action="search.php" method="get">
			<input id="searchinput" type="text" name="search" placeholder="search book by name or isbn"/>
			<input type="submit" id="search" name="searchbtn" value="search"/>
		</form>

		<a href="logout.php?logout=logout" ><button id="logout" name="logout"> Logout </button></a>

	</header>
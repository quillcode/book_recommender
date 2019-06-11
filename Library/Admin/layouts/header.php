
<body>
<header>
	<nav>
		<div id="profile">
			<!-- <img src="images/pro.png">
			<p>Admin Name</p> -->
		</div>

		<form id="navfrom" action="searchbookstudent.php" method="get"> <!-- go to searchbookstudent.php -->
			<select name="searchcatagory" >
				<option value="book" class="dropdown">book</option>
				<option value="student" class="dropdown">student</option>
			</select>
			<input id="searchinput" type="text" name="search" placeholder="search book by isbn or name & student by id or name"> <!-- search box.  -->
			<input id="searchbtn" type="submit" name="searchbtn" value="search">

		</form>
		<a href="logout.php?logout=logout"><button id="logout">Logout</button></a>
	</nav>
</header>

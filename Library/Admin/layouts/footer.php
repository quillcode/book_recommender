<aside id="menu">
	<ul>
		<li><a href="index.php">Home</a></li>
		<li><a href="addbook.php">Add Book</a></li>
		<li><a href="addstudent.php">Add Students</a></li>
		<li><a href="viewbook.php">View Book</a></li>
		<li><a href="viewstudent.php">View Student</a></li>
		<li><a href="renewcsvdata.php">Renew CSV Data</a></li>
		
	</ul>
</aside>

</body>
</html>


<?php

if(isset($database)) {
	$database->close_connection(); // and at the end close the database connection.
}


?>
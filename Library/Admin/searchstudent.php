<?php require_once('includes/sessioncheck.php');
      require_once('includes/database.php');
      require_once('includes/students.php');
      require_once('includes/pagination.php');


      $searchword = trim($_GET['search']);
      $sql = "select count(*) from students where firstname like '%{$searchword}%' or id = '{$searchword}'"; // return one field named as count(*) we use this query to find the count to create the number of page that we need 

      $current_page = !empty($_GET['page']) ? (int) $_GET['page'] : 1;
      $per_page = 9;
      $count = Student::count_by_sql($sql);

      $pagination = new Pagination($current_page, $per_page, $count);

      $sql = "select * from students where firstname like '%{$searchword}%' or id = '{$searchword}' limit {$per_page} offset {$pagination->offset()}"; // this query is used to show stds that contain search word.
       
      $students = Student::find_by_sql($sql);  // save 



?>


<!DOCTYPE html>
<html>
<head>
	<title>View Students</title>
	<link rel="stylesheet" type="text/css" href="styles/reset.css">
	<link rel="stylesheet" type="text/css" href="styles/main.css">

</head>
<?php include_once('layouts/header.php') ;?>

<div id="content">
	<div id="stdlist">
		<table>
			<tr id="tblheader">
				<th>ID</th>
				<th>Firstname</th>
				<th>Lastname</th>
				<th>Profile</th>
			</tr>

		<?php foreach($students as $student){
		echo "<tr>";
  		echo "<td>" . $student->id ."</td>";   // why we use student why we don't use students...???
  		echo "<td>" . $student->firstname . "</td>";
  		echo "<td>" . $student->lastname . "</td>" ;
  		echo "<td><a href=\"studentprofile.php?id={$student->id}\">";
  		echo "<button id='profilebtn'>Profile</button></a></td> ";
  		}

  		?>
			
		</table>
	</div>

	<div id="pagination">

			<?php
			// create pagination if total pages is greater then 1. 
			if($pagination->total_pages() > 1 ){

				// check if currentpage has prev button then write code for previous button
				if($pagination->has_previous_page()){

					echo "<a href=\"viewstudent.php?page="; 
					echo $pagination->previous_page();
					echo "\"><button class=\"nextprev\">Previous</button></a>";

				} else {
					echo "<button class= \"nextprev\">Previous</button>";
				}  // end of code for prev

				// code for numbered button
				for($i=1; $i<=$pagination->total_pages(); $i++){
					// if i is in current page then don't create a link
					if($i == $current_page){
						echo "<button id= \"current\"> ". $i . "</button>";
					}

					else{
						echo "<a href=\"viewstudent.php?page={$i}\"><button>$i</button></a>";
					}

				} // end of code for numbered button
			

				// check if currentpage has next button then code for next button.
				if($pagination->has_next_page()){
					echo "<a href=\"viewstudent.php?page=";
					echo $pagination->next_page();
					echo "\"><button class=\"nextprev\">Next</button></a>";
				}
				else{
					echo "<button class=\"nextprev\">Next</button>";
				}
			 } // end of if condition for checking if total page is greater then 1.

			?>
			
	</div>


</div>
	
<?php include_once("layouts/footer.php");
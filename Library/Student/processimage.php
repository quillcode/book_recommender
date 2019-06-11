<?php require_once('sessioncheck.php');
require_once('../Admin/includes/database.php');
require_once('../Admin/includes/students.php');
	

	if(isset($_POST['setprofile']) ){ // if button is clicked 

		if(!empty($_FILES['image']['name'])  && isset($_GET['id'])){  // if file is choosen and id is set

			$id  = trim($_GET['id']);  // we need the student id to store the image path for the student.

			$student = Student::find_by_id($id);

			$oldPath = $student->imagepath; // if student wants to change his/her image.

			if($oldPath) {
				unlink($oldPath);
			}


			$image_path = "ProfileImages/".$_FILES['image']['name'];
			$moved = move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

			// when image is inserted it will be moved to profileImages directory and it must also be set on the database.
			
			if($moved) {

				$sql = "update students set imagepath = '{$image_path}' where id = '{$id}'";

				$database->query($sql);

				header("Location: index.php");
			}


		}
		else{
			
			header("Location: index.php");
		}

	}



?>
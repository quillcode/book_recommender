<?php
include_once('database.php');


class Student{

	public $id;
	public $firstname;
	public $lastname;
	public $username;
	public $password;
	public $gender;
	public $faculty;
	public $semester;
	public $imagepath;


	public static function getallStudents(){
		$students = array();

		global $database;

		$result = $database->query("select * from students");

		while($row = mysqli_fetch_array($result)){ // to extract info from each row

			$student = new Student();
			$student->id = $row['id']; // assignment of instance variables
			$student->firstname = $row['firstname'];
			$student->lastname = $row['lastname'];
			$student->username = $row['username'];
			$student->password = $row['password'];
			$student->gender = $row['gender'];
			$student->faculty = $row['faculty'];
			$student->semester = $row['semester'];

			$students[] = $student; // assign them to array.

		}

		return $students;
	}

	public static function count_all() {

	global $database;
	$sql = "select count(*) as count from students";
	$result = $database->query($sql);
	$row = mysqli_fetch_array($result); // count is just a single value but still it returns a field inside a row. so return the count field insdie the row.
	return $row['count'];

}

	public static function count_by_sql($sql){ // return count value for a specific condition such as where 											name like %saf%;
		global $database;
		$result = $database->query($sql);
		$row = mysqli_fetch_array($result);
		return $row['count(*)'];
	}

	public static function find_by_sql($sql){

		global $database;
		$result = $database->query($sql); // multipel rows result

		$students = array(); // create an empty array.

		// to get all rows create a loop
	while($row = mysqli_fetch_array($result)){
			$student = new Student();
			$student->id = $row['id'];
			$student->firstname = $row['firstname'];
			$student->lastname = $row['lastname'];
			$student->username = $row['username'];
			$student->password = $row['password'];
			$student->gender = $row['gender'];
			$student->faculty = $row['faculty'];
			$student->semester = $row['semester'];



			$students[] = $student; // return one row of each student.

		}
		return $students; // ????
	}

	public static function find_student_by_username_password($username, $password) {
		global $database;

		$result = $database->query("select * from students where username = '{$username}' and password = '{$password}'");

		if($row = mysqli_fetch_array($result)){ // we don't use while bcs we just wanna find one std fields using id.
			$student = new Student();
			$student->id = $row['id'];
			$student->firstname = $row['firstname'];
			$student->lastname = $row['lastname'];
			$student->username = $row['username'];
			$student->password = $row['password'];
			$student->gender = $row['gender'];
			$student->faculty = $row['faculty'];
			$student->semester = $row['semester'];
			$student->imagepath = $row['imagepath'];

			return $student; // return a student row.
		}
		else{
			return false;
		}

	}

	public static function find_by_id($id){

		global $database;

		$result = $database->query("select * from students where id = '{$id}'");

		if($row = mysqli_fetch_array($result)){ // we don't use while bcs we just wanna find one std fields using id.
			$student = new Student();
			$student->id = $row['id'];
			$student->firstname = $row['firstname'];
			$student->lastname = $row['lastname'];
			$student->username = $row['username'];
			$student->password = $row['password'];
			$student->gender = $row['gender'];
			$student->faculty = $row['faculty'];
			$student->semester = $row['semester'];
			$student->imagepath = $row['imagepath'];

			return $student; // return a student row.
		}
		else{
			return false;
		}

	}



	public function create(){ // save the student info
		global $database;

		$sql = "insert into students(id, firstname, lastname, username, password, gender, faculty, semester) ";
		$sql .= " values ('{$this->id}', '{$this->firstname}', '{$this->lastname}', '{$this->username}', '{$this->password}', '{$this->gender}', '{$this->faculty}', '{$this->semester}')";
		
		
		$database->query($sql);
	}

	public function delete(){

		global $database;

		$sql = "delete from students where id = '{$this->id}'";
		$database->query($sql);
	}
	
	public function update(){

		global $database;
		$sql = "update students set ";
		$sql .= "id = '{$this->id}' , firstname = '{$this->firstname}', lastname = '{$this->lastname}', " ;
		$sql .= "username = '{$this->username}', password = '{$this->password}', ";
		$sql .= " gender = '{$this->gender}', faculty = '{$this->faculty}', ";
		$sql .= "semester = '{$this->semester}' ";
		$sql .= "where id = '{$this->id}'";

		$database->query($sql);

	
	}



}


?>
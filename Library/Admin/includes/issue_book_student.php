<?php
require_once('database.php');

class IssueBookStudent{

	public $isbn;
	public $id;



	public function create(){
		global $database;

		$sql = "insert into issue_book_student (isbn, id) values('{$this->isbn}', '{$this->id}')";
		$database->query($sql);

	}

	public static function isIssuedToUser($isbn, $id) {

		return self::count_by_id_isbn($id, $isbn) > 0;



	}

	public static function delete_by_isbn_id($isbn, $id){
		global $database;
		$sql = "delete from issue_book_student where isbn = '{$isbn}' and id = '{$id}' ";
		$database->query($sql);
	}

	public static function delete_by_isbn($isbn) {  // if a book is deleted in the book table this method will delete 
		global $database;
		$sql = "delete from issue_book_student where isbn = '{$isbn}'";
		$database->query($sql);									// the related records of that books issue_book_student table

	}

	public static function count_all(){
		global $database;
		$sql = "select count(*) as count from issue_book_student";
		$result = $database->query($sql);
		$row = mysqli_fetch_array($result);
		return $row['count'];
	}

	public static function count_unique() {
		global $database;
		$sql = "select count(*) as count from issue_book_student group by id";
		$result = $database->query($sql);
		$row = mysqli_fetch_array($result);
		return $row['count'];
	}

	public static function count_by_id_isbn($id, $isbn) { // to know that the isbn is not assigned to the user before.
		global $database;

		$sql = "select count(*) as count from issue_book_student where id = '{$id}' and isbn = '{$isbn}'";

		$result = $database->query($sql);
		$row = mysqli_fetch_array($result);
		return $row['count'];
		


	}
	public static function find_isbns_by_id($id) { // find isbns issued to a specific stdid
		global $database;

		$sql = "select * from issue_book_student where id = '{$id}'";

		$result = $database->query($sql);

		$books_students = array();

		while( $row = mysqli_fetch_array($result)) {

			// each time it fetch a row it will make a new obj and extract the attributes of obj and assign them to instance variables.

			$book_student = new IssueBookStudent();
			$book_student->id = $row['id'];
			$book_student->isbn = $row['isbn'];

			$books_students[] = $book_student;


		}

		return $books_students;
	}

	public static function find_count_by_isbn($isbn){ // to count the num of copies of a specific isbn that is issued to students.
		global $database;
		$sql = "select count(*) as count from issue_book_student where isbn = '{$isbn}' ";
		$result = $database->query($sql);
		$row = mysqli_fetch_array($result);


		return $row['count'];
	}


	public static function find_by_sql($sql){

		global $database;
		$result = $database->query($sql); // multipel rows result

		$students = array(); // create an empty array.

		// to get all rows create a loop
	while($row = mysqli_fetch_array($result)){
			$student = new Student();
			$student->id = $row['id'];
			
			$students[] = $student; // return one row of each student.

		}
		return $students; // ????
	}
}

?>
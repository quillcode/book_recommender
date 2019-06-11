<?php
require_once('database.php');

class RatedBookStudent{

	public $isbn;
	public $id;
	public $rating;


	public function create(){
		global $database;

		$sql = "insert into rated_book_student (isbn, id, rating, date) values('{$this->isbn}', '{$this->id}', '{$this->rating}', NOW() )";

		$database->query($sql);

		

	}

	public function update() {

		global $database;

		$sql = "update rated_book_student set rating = '{$this->rating}' where isbn = '{$this->isbn}' and id = '{$this->id}'";

			$database->query($sql);
	}

	public static function find_by_id($id) { // given a std id find the last rated isbns
		global $database;
		$sql = "select * from rated_book_student where id = '{$id}' order by date desc";
		
		$result = $database->query($sql);

		if ($row = mysqli_fetch_array($result)) {

			$rated_book_student = new RatedBookStudent();

			$rated_book_student->id = $row['id'];
			$rated_book_student->isbn = $row['isbn'];
			$rated_book_student->rating = $row['rating'];

			return $rated_book_student;  // one row.

		} else {
			return false;
		}
	}

	public static function get_all() {
		global $database;
		$sql = "select * from rated_book_student";
		$result = $database->query($sql);

		$rated_books_students = array();

		while ($row = mysqli_fetch_array($result)) {

			$rated_book_student = new RatedBookStudent();

			$rated_book_student->id = $row['id'];
			$rated_book_student->isbn = $row['isbn'];
			$rated_book_student->rating = $row['rating'];

			$rated_books_students[] = $rated_book_student;  

		}

		return $rated_books_students;

	}

	public static function find_by_isbn_id($isbn, $id) {

		global $database;
		$sql = "select * from rated_book_student where isbn = '{$isbn}' and id = '{$id}'";
		$result = $database->query($sql);

		if ($row = mysqli_fetch_array($result)) {

			$rated_book_student = new RatedBookStudent();

			$rated_book_student->id = $row['id'];
			$rated_book_student->isbn = $row['isbn'];
			$rated_book_student->rating = $row['rating'];

			return $rated_book_student;  // one row. (an object)

		} else {
			return false;
		}

	}

	public static function delete_record_by_isbn($isbn) {
		global $database;
		$sql = "delete from rated_book_student where isbn = '{$isbn}'";
		$database->query($sql);
	}



}

?>
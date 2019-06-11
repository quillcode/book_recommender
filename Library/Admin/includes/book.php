<?php 
require_once('database.php');
require_once('rated_book_student.php');
 
 class Book{

public $isbn;
public $name;
public $author;
public $yearofpub;
public $numofcopy;
public $catagory;
public $imagepath;
// public $date;


public static function count_all() { // return the number of all the rows in db. no condition.

	global $database;
	$sql = "select count(*) as count from books";
	$result = $database->query($sql);
	$row = mysqli_fetch_array($result); // count is just a single value but still it returns a field inside a row. so return the count field insdie the row.
	return $row['count'];

}

public static function all_total_copies(){
	global $database;
	$sql = "select SUM(numofcopy) as totalcopies from books";
	$result = $database->query($sql);
	$row = mysqli_fetch_array($result);
	return $row['totalcopies'];
}

public static function count_by_sql($sql) { // return count value for a specific condition ex where name 													like '%abc%'
	global $database;
	$result = $database->query($sql);
	$row = mysqli_fetch_array($result); // count is just a single value but still it returns a field inside a row. so return the count field insdie the row.
	return $row['count(*)'];
}

public static function find_by_sql($sql) { // --> take a sql query as arg and give its output.

	global $database;
	$result = $database->query($sql);

	$books = array();

	while( $row = mysqli_fetch_array($result)) {

		// each time it fetch a row it will make a new obj and extract the attributes of obj and assign them to instance variables.

		$book = new Book();
		$book->isbn = $row['isbn'];
		$book->name = $row['name'];
		$book->author = $row['author'];
		$book->yearofpub = $row['author'];
		$book->numofcopy = $row['numofcopy'];
		$book->catagory = $row['catagory'];
		$book->imagepath = $row['imagepath'];

		$books[] = $book; // books an array of objects.


	}

	return $books;
}

public static function find_by_isbn($isbn) { // return only one row according to given isbn.
	global $database;
	$sql = "select * from books where isbn = '{$isbn}'";
	$result = $database->query($sql);

	if ($row = mysqli_fetch_array($result)) {

		$book = new Book();
		$book->isbn = $row['isbn'];
		$book->name = $row['name'];
		$book->author = $row['author'];
		$book->yearofpub = $row['yearofpub'];
		$book->numofcopy = $row['numofcopy'];
		$book->catagory = $row['catagory'];
		$book->imagepath = $row['imagepath'];

		return $book;

	} else {
		return false;
	}
}

   

public function create(){ //save info about book

	global $database;

	$sql = "insert into books(isbn, name, author, yearofpub, numofcopy, catagory, imagepath, Date) values('{$this->isbn}', '{$this->name}', '{$this->author}', '{$this->yearofpub}', '{$this->numofcopy}', '{$this->catagory}', '{$this->imagepath}', NOW() )";

	$database->query($sql);

}

public function delete(){
	global $database;

	$sql = "delete from books where isbn = '{$this->isbn}'";

	$database->query($sql);
	RatedBookStudent::delete_record_by_isbn($this->isbn);

}

public function update(){

	global $database;

	$sql = "update books set name = '{$this->name}', author = '{$this->author}', yearofpub = '{$this->yearofpub}', numofcopy = '{$this->numofcopy}', catagory = '{$this->catagory}', imagepath = '{$this->imagepath}'  where isbn = '{$this->isbn}' ";

		$database->query($sql);

}

public static function find_books_by_isbn($bks_student){

		$books = array();

      	foreach ($bks_student as $value) {
      		$books[] =	Book::find_by_isbn($value->isbn);
      	}
      	
      	return $books;
}

public static function new_books(){
	global $database;

	$sql = "select * from books ORDER BY Date desc"; 
	$result = $database->query($sql);

	$books = array();

	while( $row = mysqli_fetch_array($result)) {

		// each time it fetch a row it will make a new obj and extract the attributes of obj and assign them to instance variables.

		$book = new Book();
		$book->isbn = $row['isbn'];
		$book->name = $row['name'];
		$book->author = $row['author'];
		$book->yearofpub = $row['author'];
		$book->numofcopy = $row['numofcopy'];
		$book->catagory = $row['catagory'];
		$book->imagepath = $row['imagepath'];

		$books[] = $book; // books an array of objects.


	}

	return $books;

}


}


?>
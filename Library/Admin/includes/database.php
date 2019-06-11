<?php


class Database {

	private $connection; 

	public function __construct(){ // magic func used to establish connection whenever obj created automatically called.
		
		$this->connection = mysqli_connect('localhost', 'root', '', 'library') or die('Connection Erro');

	}
	public function query($sql){ // first connect to db then make query and send it to db.
		
		$result = mysqli_query($this->connection, $sql) or die('Query failed');
		return $result;
	}

	public function affected_rows(){
		return mysqli_affected_rows($this->connection);
	}

	public function close_connection(){
		mysqli_close($this->connection);
	}

	public function get_connection(){
		return $this->connection;
	}


}


$database = new Database();



?>
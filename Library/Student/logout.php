<?php
session_start();

if(isset($_GET['logout'])) {

	unset($_SESSION['user']);
	header('location: login.php');
	exit();
}


?>
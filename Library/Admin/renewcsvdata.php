<?php require_once('includes/rated_book_student.php'); 


 $allRecord = RatedBookStudent::get_all();

 $csvString = "\"User-ID\";\"ISBN\";\"Book-Rating\"";
 $csvString .= PHP_EOL;

 if($handle = fopen('pythonServer/BX-Book-Ratings.csv', 'w')) {

    foreach($allRecord as $record) {
 	    $csvString .= "\"{$record->id}\";\"{$record->isbn}\";\"{$record->rating}\"";
 	    $csvString .=  PHP_EOL;

 	}


 	fwrite($handle, $csvString);
 	fclose($handle);


 }
 
 header("Location: index.php");













?>
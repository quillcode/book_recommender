<?php 
	

	$books_pics = array('images/knowledge is power.jpg', 'images/knowledge.jpg', 'images/light.jpg');

	$book_pics_index = rand(0, count($books_pics)-1);

	$qoutes = array( '"Knowledge knocks on the door of action. If it recieves a reply it stays otherwise it departs. " ', 'Be a life long student! The more you learn, the more you earn and the more self confidence you will have. ', 'The only Good is Knowledge and the only Evil is IGNORANCE.');

	$qout_index = rand(0, count($qoutes)-1);


?>

	<aside class="sidebar2">
		<div id="dailyqoute">
			<img src="<?php echo $books_pics[$book_pics_index]; ?>">
			<p><?php echo $qoutes[$qout_index];  ?></p>
		</div>
	</aside>
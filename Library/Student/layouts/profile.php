<aside class="sidebar1">
		<div id="myprofile">
			<div id="titlepic">
				<p>My Profile</p>
				<?php 
						if(!empty(trim($student->imagepath))) {
							echo "<img src=\"{$student->imagepath}\">";
						} else {
							echo "<img src=\"images/profile.png\">";
						}
				?>

				
				
			</div>
			<div id="profileDetail">Profile Details</div>
			<div id="profilecontent">
			<p>Firstname &nbsp;: <?php echo $student->firstname; ?></p>
			<p>Lastname &nbsp;: <?php echo $student->lastname; ?></p>
			<p>Username : <?php echo $student->username; ?></p>
			<p>Gender &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $student->gender; ?></p>
			<p>Faculty &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $student->faculty; ?></p>
			</div>


			<form method="post" action="processimage.php?id=<?php echo $student->id; ?>" enctype="multipart/form-data" >
					<input type="file" name="image" id="chooseimg">
					<input type="submit" name="setprofile" value="SET" id="setprofile" style="width:50px;">
				</form>
		</div>


	</aside>
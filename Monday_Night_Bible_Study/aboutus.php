<?php include("config/config.php"); ?>

<!DOCTYPE html>
<html>
	<head>
		<!-- MUST INCLUDE THIS BECAUSE SESSION VARIABLES START IN CONFIG → LOGIN_HANDLER.PHP (THIS SHOULD GO AT TOP OF PAGE, BUT DREAMHOST DOES NOT ALLOW -->
		<!-- Below Belongs Our Title and Links -->
		<?php include("includes/head.php"); ?>
	</head>
	<!-- Main Body Belongs Below -->
	<body>
		<header>
			<!-- We Include Navbar Stuff and Logo Using Header PHP -->
			<!-- DECIDING IF USER IS GUEST/ADMIN/MEMBER -->
			<?php 
				if(isset($_SESSION['username'])) {
					$username = $_SESSION['username'];
					$adminfetch = mysqli_fetch_array(mysqli_query($con, "SELECT admin FROM user WHERE user_name = '$username'"));
					$adminquestion = $adminfetch['admin'];
					
					if($adminquestion == 'yes') {
						include("includes/headers/admin_header.php");
					}
					else {
						include("includes/headers/user_header.php");
					}
				}
				else {
					include("includes/headers/guest_header.php");
				}
			?>
		</header>
		<main>
		<!-- SCRIPT TO SET MARGIN-TOP of MAIN SO NAVBAR CAN BE SEEN ON SMALL DEVICES -->
			<script>
			$(document).ready(function(){ // USES JQuery
				width = window.innerWidth; // Gets Width Of Device
				if(width < 420) {
					var mainNavBarHeight = $(".drop-down-menu").height();
					
					// Setting MarginTop of Main
					// Apparently There is A Difference Between JQuery Object and DOM Object
					$("main")[0].style.marginTop = mainNavBarHeight + 25 + "px";
					
					// Coloring Main Nav Bar Black on Small Screens
					var mainNavBarReal = $(".main_nav_bar");
					mainNavBarReal[0].style.width = "100vw";
					mainNavBarReal[0].style.backgroundColor = "#0B1114";
				}
			});
			</script>
			<section class = "aboutgroup">
				<h1> About Us </h1>
				<p> We are a small group that is part of our lovely church, Clear Creek Community Church. The group is affiliated with the church, HOWEVER the website
				operates independently of the church. Our members try our best to align with the church, but not all of us have theology degrees and(or) are pastors.
				We are just ordinary citizens trying to log diaries of our spiritual journies and hard questions that we wrestle with. That means not all our articles
				may contain biblically accurate content. Every human makes mistakes, but we can be corrected and our content may be adjusted. </p>
			</section>
			<section class = "aboutussection">
				<h1> Meet Our Members </h1>
				<?php
					// Post Query
					$posts = mysqli_query($con, "SELECT first_name, last_name, profile_picture, about_user, default_pic, date_joined FROM user");
					
					// Gets All Posts
					$i = 0;
					while($post_row = mysqli_fetch_array($posts)) {						
						// Can't Echo $post_row['column'], So We Store All As Variables
						$firstname = $post_row['first_name'];
						$lastname = $post_row['last_name'];
						$profilepicture = $post_row['profile_picture'];
						$abouttheuser = $post_row['about_user'];
						$isdefaultpic = $post_row['default_pic'];
						$date_joined = $post_row['date_joined'];
						$date_joined_array = explode( '-', $date_joined);
						
						// Return Month String
						if($date_joined_array[1] == 1) {
							$month = "January";
						}
						else if($date_joined_array[1] == 2) {
							$month = "February";
						}
						else if($date_joined_array[1] == 3) {
							$month = "March";
						}
						else if($date_joined_array[1] == 4) {
							$month = "April";
						}
						else if($date_joined_array[1] == 5) {
							$month = "May";
						}
						else if($date_joined_array[1] == 6) {
							$month = "June";
						}
						else if($date_joined_array[1] == 7) {
							$month = "July";
						}
						else if($date_joined_array[1] == 8) {
							$month = "August";
						}
						else if($date_joined_array[1] == 9) {
							$month = "September";
						}
						else if($date_joined_array[1] == 10) {
							$month = "October";
						}
						else if($date_joined_array[1] == 11) {
							$month = "November";
						}
						else {
							$month = "December";
						}
						
						$user_date_joined = $month.' '.$date_joined_array[0];
						
						$name = ucfirst($firstname)." ".ucfirst($lastname);
						
						if($isdefaultpic == 'yes') {
							$picture = "assets/images/defaults/$profilepicture";
						}
						else {
							$picture = "assets/images/profilepictures/$profilepicture";
						}
				
						echo "<div class = 'userabout'>
									<img src = '$picture'></img>
									<div>
										<h2> $name </h2>
										<p> $abouttheuser </p>
										<p> $name Joined In $user_date_joined </p>
									</div>
								</div>";
					}
				?>
			</section>
			</script>
		</main>
	</body>
</html>
<?php
if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
}

function postparttop($name, $title, $date, $directory_inner, $picture) {
	$text = "
	<?php require '../config/config.php'; ?>
	<!DOCTYPE html>
	<html>
		<head>
			<!-- Below Belongs Our Title and Links -->
			<title>
				Monday Night Group
			</title>
			<!-- Links to Frameworks or Other Stuff -->
			<script src = \"https://kit.fontawesome.com/de1b23d5aa.js\" crossorigin = \"anonymous\"></script> <!-- FONT AWESOME ICONS -->
			<link rel = \"stylesheet\" type = \"text/css\" href = \"../assets/css/monday_night_group_bible_study.css\"> <!-- WORKS BECAUSE IT IS ACCESSED FROM OUTER FILE -->
			<script src = \"../assets/js/jquery-3.6.0.js\"></script>
			<meta name = \"viewport\" content = \"width = device-width, initial-scale=1\">
		</head>
		<!-- Main Body Belongs Below -->
		<body>
			<header>
				<!-- We Include Navbar Stuff and Logo Using Header PHP -->
				<!-- DECIDING IF USER IS GUEST/ADMIN/MEMBER -->
				<?php 
					if(isset(\$username)) {
						include(\"../includes/headers/user_header_post.php\");
					}
					else {
						include(\"../includes/headers/guest_header_post.php\");
					}
				?>
			</header>
			<main>
				<section class = \"post_section\">
					<div class = \"article_info\" style = \"background-image: url('$directory_inner');\">
						<div class = \"floattobottom\">
							<h1 class = \"titlepost\"> $title </h1>
							<div class = \"infopanel\">
								<div class = \"postinfo\">
									<p class = \"setheight\"> Written By $name <br>
									Written on $date </p>
								</div>
								<image src = \"../$picture\" class = \"postinfoimage\"></image>
							</div>
						</div>
					</div>
					
					<!-- Script to Calculate Height of SetHeight and Set Image Width And Height to That Height -->
					<script> 
						// Script Uses JQuery
						$(document).ready(function() {
							var paragraphHeight = $(\".setheight\").height();
							
							// Setting Height of User Controls
							// Apparently There is A Difference Between JQuery Object and DOM Object
							$(\".postinfoimage\")[0].style.height = paragraphHeight + \"px\";
							
							// Setting OffSet from Top Nav for User Controls ID
							$(\".postinfoimage\")[0].style.width = paragraphHeight + \"px\";
						});
					</script>
					";
	return $text;
	}
?>
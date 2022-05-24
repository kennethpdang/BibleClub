<?php require 'config/config.php'; ?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Below Belongs Our Title and Links -->
		<?php include("includes/head.php"); ?>
	</head>
	<!-- Main Body Belongs Below -->
	<body>
		<!-- MUST INCLUDE THIS BECAUSE SESSION VARIABLES START IN CONFIG → LOGIN_HANDLER.PHP (THIS SHOULD GO AT TOP OF PAGE, BUT DREAMHOST DOES NOT ALLOW -->
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
			<!-- THIS IS TO ADD MORE TEXT WHEN USER SCROLLS : Uses JQuery -->
			<!-- Description, as user scrolls, more text is added to loading-welcome class. By end of scroll, loading welcome's text should light up -->
			<!-- Temporarily Disable --> <script src = "assets/js/loadingwelcometxt.js"></script> <!-- Can Include In Header -->

			<section id = "loading-welcome">
				<span>
					<h1 class = "element1" id = "element1"> We </h1>
					<h1 class = "element2" id = "element2"> Love </h1> 
					<h1 class = "element3" id = "element3"> Because </h1> 
					<h1 class = "element4" id = "element4"> He </h1> 
					<h1 class = "element5" id = "element5"> First </h1> 
					<h1 class = "element6" id = "element6"> Loved </h1>
					<h1 class = "element7" id = "element7"> Us </h1>
				</span>
			</section>
			
			<section id = "posts">
				<?php
					// Post Query
					$posts = mysqli_query($con, "SELECT * FROM posts");
					
					// Gets All Posts
					$i = 0;
					while($post_row = mysqli_fetch_array($posts)) {
						// This is very good code, prints: 1122112211 sequence.
						if((($i + 1) % 4) > 1) {
							$divLength = "70%";
						}
						else {
							$divLength = "30%";
						}
						
						$i++; // For Div Length.
						
						// Can't Echo $post_row['column'], So We Store All As Variables
						$color = $post_row['color'];
						$title = $post_row['post_title'];
						$author = $post_row['post_author'];
						$image = $post_row['picture_directory_inner']; // PHP WOULD THINK BACKSLASHES HERE ARE ESCAPE CHARACTER. GOT TO ADD SLASHES.
						$image = addslashes($image);
						$link = $post_row['post_link'];
						
						echo "<div class = 'post-background' style = 'width: $divLength;'>
								<a href = 'posts/$link.php' class = 'post' style = 'background-color: $color;'>
									<div> <!-- Without, Flex Property Places Header and Author On Same Line -->
										<h2> $title </h2>
										<hr>
										<p> Written by $author </p>
									</div>
								</a>
							</div>";
					}
				?>
			</section>
		</main>
		<footer>
			<span>
				<a href = "https://www.clearcreek.org/locations/" target = "_blank" class = "join-group"> Come to A Service! <i class = "fa fa-place-of-worship fa-lg"></i> </a> &nbsp;&nbsp;&nbsp;
				<a href = "https://www.clearcreek.org/group-details/?id=10979" target = "_blank" class = "join-group"> Join Us? <i class = "fa fa-handshake-angle fa-lg"></i> </a>
			</span>
			<h5> © <?php echo date('Y')."-".date('Y')+1; ?> &nbsp;&nbsp;&nbsp; Jonathan Brubaker & Alexis Brubaker </h5>
		</footer>
	</body>
</html>
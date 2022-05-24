<?php include("config/config.php"); ?>

<?php
	if(isset($_POST['publish_post'])) {	
		// Setting All Values
		$username = $_SESSION['username'];
		$authorfetch = mysqli_fetch_array(mysqli_query($con, "SELECT first_name, last_name FROM user WHERE user_name = '$username'"));
		$author = ucfirst($authorfetch[0])." ".ucfirst($authorfetch[1]);
		$date = date("Y-m-d");
		$isPrivate = "no";
		
		// Mark Private or No
		if(isset($_POST['private'])) {
			$isPrivate = "yes";
		}
		
		// Clear Out Any HTML Tags
		$text = strip_tags($_POST['post_content']);
		$title = strip_tags($_POST['post_title']);
		
		// Since PHP Thinks Periods In Text Is String Concatenation
		$text = addslashes($text);
		
		// Allow User to Enter Line Breaks
		$text = str_replace('\r\n', '\n', $text);
		$text = nl2br($text);
		
		// Upper Case Title
		$title = ucwords($title);
		
		// Making Sure Title Does Not Exist Already
		
		// Assigning A Post Color
		$color_Array = array("#F2F3AE", "#EDD382", "#F5B969", "#FC9E4F", "#FF521B");
		$thisPostColor = $color_Array[rand(0, 4)];
		
		// Assign a Random Post Link
		$values1 = rand(0, 5);
		$values2 = rand(0, 7);
		$values3 = rand(0, 9);
		$postLink = strval($values1).strval($values2).strtolower($title).strval($values3);
		$postLink = preg_replace("/[^A-Za-z0-9]/", '', $postLink); // Removing NonAlphanumeric Characters Since You Can't Create a File Name with Certain Characters
		$postLink = preg_replace("/\s+/", "", $postLink);
		
		// Assigning Random Inner Picture if Not Chosen
		if(!is_uploaded_file($_FILES['imageinside']['tmp_name'])) {
			$value4 = rand(1, 7);
			$directory_inner = "../assets/images/postpictures/post_pictures_inside_default/landscape".$value4.".jpg";
		}
		else {
			$filename = $_FILES['imageinside']['name']; // Get file and it's name and hold it locally.
			$location = "assets/images/postpictures/post_pictures_inside/".$filename; // Get location to save.
			
			// Moving Picture to Location
			move_uploaded_file($_FILES['imageinside']['tmp_name'], $location);
			
			// Setting Directory Inner to Where We Moved the File
			$directory_inner = "../".$location; // From the directory of posts, we need to add '../'.
		}
		
		// Pushing Everything To Database
		mysqli_query($con, "INSERT INTO posts VALUES('','$author','$title','$text','$date', '$isPrivate','$thisPostColor', '$directory_inner', '$postLink')");
		
		// Creating New File and Writing to That File
		$myfile = fopen("posts/".$postLink.".php", "w"); // Handler
		
		// Submit to Another Function that Returns Values
		require('includes/post_part/postparttop.php');
		
		// Adding Appropriate Picture into Post
		$namenew = mysqli_fetch_array(mysqli_query($con, "SELECT profile_picture, default_pic FROM user WHERE user_name = '$username'"));
		$image = $namenew['profile_picture'];
		$isdefaultpic = $namenew['default_pic'];
		
		if($isdefaultpic == 'yes') {
			$picture = "assets/images/defaults/$image";
		}
		else {
			$picture = "assets/images/profilepictures/$image";
		}
		
		// Actual Contents
		$beginning = postparttop($author, $title, $date, $directory_inner, $picture);
		$ending = "<?php require('../includes/post_part/postpartbottom.php'); ?>";
	
		$textBody = mysqli_fetch_array(mysqli_query($con, "SELECT post_text FROM posts WHERE post_title = '$title'"));
		$textBodyNew = "<p>".$textBody['post_text']."</p>";
		
		// Writing to the File
		fwrite($myfile, $beginning);
		fwrite($myfile, $textBodyNew);
		fwrite($myfile, $ending);
		fclose($myfile);
		
		// Updating Num Posts from User
		mysqli_query($con, "UPDATE user SET num_post = num_post + 1 WHERE user.user_name = '$username'");
		
		// Deleting Temporary Photo if Set
		
		// Refresh Page
		header("Refresh: 1;"); 
		// echo("<meta http-equiv = 'refresh' content = '0'>"); // THIS KEEPS PULLING DOWN THE PAGE FOR SOME REASON!
	}
?>

<!DOCTYPE html>
<html>
	<head>
	<!-- MUST INCLUDE THIS BECAUSE SESSION VARIABLES START IN CONFIG → LOGIN_HANDLER.PHP (SUPPOSE TO GO ON TOP OF PAGE, BUT DREAMHOST WON'T ALLOW) -->
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
					Header("Location: index.php");
				}
			?>
		</header>
		<main class = "manage_main">
			<!-- Script to Calculate Height and OffSet From Navbar for User_Controls Section -->
			<script> 
				// Script Uses JQuery
				$(document).ready(function() {
					var mainNavBarHeight = $(".main_nav_bar").height();
					
					// Setting Height of User Controls
					// Apparently There is A Difference Between JQuery Object and DOM Object
					$("#user_controls")[0].style.height = "calc(100vh - " + mainNavBarHeight + "px)";
					
					// Setting OffSet from Top Nav for User Controls ID
					$("#user_controls")[0].style.marginTop = mainNavBarHeight + "px";
					
					// Removing Everything On Small Screen and Telling User to Use Desktop
					width = window.innerWidth; // Gets Width Of Device
					if(width < 800) {
						$("#form_section").remove();
						$("#user_controls").remove();
						$(".manage_main" ).append("<h2> To Write A Post <br> Please Use a Desktop </h2>");
					}
				});
			</script>
			
			<section id = "form_section">
				<form class = "write_a_post_form" action = "manageposts.php" method = "POST" enctype="multipart/form-data" autocomplete="off">
					<!-- Want in Same Row -->
					<div class = "full">
						<!-- Place for User to Type Information In -->
						<div class = "form">
							<input type = "text" placeholder = "Enter Title of Form" class = "post_header" name = "post_title" required></input>
							<textarea placeholder = "Let us hear your reflection on the Gospel..." class = "post_text" name = "post_content" required></textarea>
						</div>
						<div class = "pictureuploadwidth">
							<!-- Inside Post Picture -->
							<div class = "image-upload after">
								<label for = "file-input">
									<image src = "assets/images/checkered_background.png" draggable = "false" class = "fileselector"></image>
								</label>
								<input id = "file-input" type = "file" name = "imageinside">
							</div>
							<input type = "checkbox" name = "private">
							<label for = "private"> Mark Private? </label>
						</div>
					</div>
					<!-- Submit Button For Post Form -->
					<input type = "submit" name = "publish_post" value = "Post" class = "post_button">
				</form>
				
				<!-- SCRIPT TO SET POST_BUTTON DOM ELEMENT'S WIDTH TO POST_CONTENT'S WIDTH -->
				<script>
				/* $(document).ready(function(){
					var text_area_s_width = $(".post_text").width();
					console.log(text_area_s_width);
					$(".post_button")[0].style.width = text_area_s_width + "px";
				}); */
				</script>
			</section>
			<section id = "user_controls">
				<?php
					$username = $_SESSION['username'];
					$authorfetch = mysqli_fetch_array(mysqli_query($con, "SELECT first_name, last_name FROM user WHERE user_name = '$username'"));
					$author = ucfirst($authorfetch[0])." ".ucfirst($authorfetch[1]);

					// Post Query
					$posts = mysqli_query($con, "SELECT * FROM posts WHERE post_author = '$author'");
					
					// Getting Posts
					while($post_row = mysqli_fetch_array($posts)) {
						$dateWritten = $post_row['post_date'];
						$title = $post_row['post_title'];
						$postid = $post_row['id'];
						$postlink = $post_row['post_link'];
						
						echo "<div class = 'previous_post'>
								<div>
									<h2> $title </h2>
									<p> Date Written: $dateWritten </p>
								</div>
								<a href = 'texteditor.php?id=$postlink'> <i class = 'fa fa-pen-to-square fa-lg'></i> </a>
								<a href = '#' onclick = 'deletePost($postid)'> <i class = 'fa fa-trash fa-lg' ></i> </a>
							</div>";
					}
				?>
				
				<!-- Script for Delete Button to Use PHP To Delete Post First Alert -->
				<script>
					// This Uses AJAX
					function deletePost(id){
						$.ajax({
							type: "GET",
							url: "includes/handlers/deletePost.php",
							data:{deleteId:id},   
							dataType: "html",                
							success: function(data){  // What to Do On Success
								location.reload(); // REFRESH PAGE SO IT LOOKS LIKE IT IS DELETED
								return false;
							}
						});
					};
				</script>
			</section>
		</main>
	</body>
</html>
<?php require 'config/config.php'; ?>
<?php
	// Seeing if post link paramaters passed through the URL by managepost.php is set:
	if(isset($_GET['id'])) {
		// Getting post link from paramaters passed in through the URL by managepost.php:
		$post_link = $_GET['id'];
		
		// Query values from database where the database post link matches the post link variable on line four (to insert the values into the form):
		$post_text_title_and_content_SQL_STMT = "SELECT post_title, post_text FROM posts WHERE post_link = '$post_link'";
		$post_title_and_text_fetch = mysqli_fetch_array(mysqli_query($con, "$post_text_title_and_content_SQL_STMT"));
		$post_title_content = $post_title_and_text_fetch['post_title'];
		$post_text_content = $post_title_and_text_fetch['post_text'];
	}
	
	// Pushing the values to the database:
	if(isset($_POST['update_post'])) {
		// Retrieving values from form and stripping all injected HTML values:
		$updated_post_title = strip_tags($_POST['post_title_edit']);
		$updated_post_text = strip_tags($_POST['post_text_edit']);
		
		// Replacing all detected line breaks with the line break character (so that user can submit a post with line breaks):
		$updated_post_text = str_replace('\r\n', '\n', $updated_post_text);
		$updated_post_text = nl2br($updated_post_text);
		
		// Updating the database with new post and new title:
		$post_title_and_text_update_SQL_stmt = "UPDATE posts SET post_title = '$updated_post_title', post_text = '$updated_post_text' WHERE post_link = '$post_link'";
		mysqli_query($con, $post_title_and_text_update_SQL_stmt);
		
		// Deleting the previous post (to write a new post with updated contents):
		unlink('posts/'.$post_link.".php");
		
		// Adding appropriate picture for post:
		$username = $_SESSION['username'];
		$author_profile_picture_and_picture_default_SQL_STMT = "SELECT profile_picture, default_pic FROM user WHERE user_name = '$username'";
		$author_profile_picture_and_picture_default_fetch = mysqli_fetch_array(mysqli_query($con, "SELECT profile_picture, default_pic FROM user WHERE user_name = '$username'"));
		$author_profile_picture_name = $author_profile_picture_and_picture_default_fetch['profile_picture'];
		$author_is_default_picture = $author_profile_picture_and_picture_default_fetch['default_pic'];
		
		if($author_is_default_picture == 'yes') {
			$author_profile_picture_directory = "assets/images/defaults/$author_profile_picture_name";
		}
		else {
			$author_profile_picture_directory = "assets/images/profilepictures/$author_profile_picture_name";
		}
		
		// Retrieving the original post date, original picture for post inner, and post author (to pass to postparttop php function):
		$original_post_information_SQL_STMT = "SELECT post_author, post_date, picture_directory_inner FROM posts where post_link = '$post_link'";
		$original_post_information_fetch = mysqli_fetch_array(mysqli_query($con, $original_post_information_SQL_STMT));
		$original_post_author = $original_post_information_fetch['post_author'];
		$original_post_date = $original_post_information_fetch['post_date'];
		$original_post_inner_picture = $original_post_information_fetch['picture_directory_inner'];
		
		// Beggining of updated post and ending of updated post:
		require('includes/post_part/postparttop.php');
		$beginning_of_updated_post = postparttop($original_post_author, $updated_post_title, $original_post_date, $original_post_inner_picture, $author_profile_picture_directory);
		$ending_of_updated_post = "<?php require('../includes/post_part/postpartbottom.php'); ?>";
	
		// Retrieving updated post text (to write into file):
		$updated_post_text_SQL_STMT = "SELECT post_text FROM posts WHERE post_link = '$post_link'";
		$updated_post_text_fetch = mysqli_fetch_array(mysqli_query($con, $updated_post_text_SQL_STMT));
		$updated_post_text = $updated_post_text_fetch['post_text'];
		$updated_post_text = "<p>".$updated_post_text."</p>";
		
		// Creating a new file for updated post:
		$myfile = fopen("posts/".$post_link.".php", "w"); // Handler
		
		// Writing contents to that updated file above:
		fwrite($myfile, $beginning_of_updated_post);
		fwrite($myfile, $updated_post_text);
		fwrite($myfile, $ending_of_updated_post);
		fclose($myfile);
		
		// Sending User Back to Manageposts.php
		Header("Location: manageposts.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Below Belongs Our Title and Links -->
		<?php include("includes/head.php"); ?>
	</head>
	<body>
		<header>
			<!-- We Include Navigation Bar and Logo Using Header PHP And Determining if User is Guest, User, or Admin -->
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
		<main class = "edit_post_main">
			<form action = "texteditor.php?id=<?php echo $post_link ?>" method = "POST">
				<input name = "post_title_edit" class = "update_post_title" type = "text" value = "<?php echo $post_title_content ?>" required></input>
				<textarea name = "post_text_edit" class = "update_post_body" required><?php echo $post_text_content ?></textarea>
				<center> <input name = "update_post" class = "update_post_button" type = "submit" value = "Update Post"></input> </center>
			</form>
		</main>
	</body>
</html>
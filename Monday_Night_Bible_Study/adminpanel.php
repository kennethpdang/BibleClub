<?php require 'config/config.php'; ?>

<?php
	// Fetching Things to Display for Admin Overview
	$numberOfUsers = mysqli_num_rows(mysqli_query($con, "SELECT user_id FROM user"));
	$numberOfPosts = mysqli_num_rows(mysqli_query($con, "SELECT id FROM posts"));
	$numberOfPostsThisMonth = mysqli_num_rows(mysqli_query($con, "SELECT id FROM posts WHERE post_date > DATE_SUB(NOW(), INTERVAL 1 MONTH)"));
	
	// Setting Some Things Prior To Registration
	$error_array = array(); //Holds error messages, like email used already. 
	$date = date("Y-m-d");
	
	// What to Do If User is Trying To Register
	if(isset($_POST['addUser'])) {
		// Constraints on First Name
		$fname = strip_tags($_POST['reg_fname']); // TAKE WHAT WAS SENT FROM THE POST FORM and STRIP TAGS REMOVES HTML TAGS
		$fname = str_replace(' ', '', $fname); // Removes spaces
		$fname = ucfirst(strtolower($fname)); // Capitlize first letter but lowercase everything else.
		$_SESSION['reg_fname'] = $fname;

		// Constraints on Last Name
		$lname = strip_tags($_POST['reg_lname']); // TAKE WHAT WAS SENT FROM THE POST FORM and STRIP TAGS REMOVES HTML TAGS
		$lname = str_replace(' ', '', $lname); // Removes spaces
		$lname = ucfirst(strtolower($lname)); // Capitlize first letter but lowercase everything else.
		$_SESSION['reg_lname'] = $lname;
		
		// Constraints on User Name
		$username = strip_tags($_POST['reg_username']); // TAKE WHAT WAS SENT FROM THE POST FORM and STRIP TAGS REMOVES HTML TAGS
		$username = str_replace(' ', '', $username); // Removes Spaces
		$_SESSION['reg_username'] = $username;
		
		// Constraints on Password
		$password = strip_tags($_POST['password']); // TAKE WHAT WAS SENT FROM THE POST FORM and STRIP TAGS REMOVES HTML TAGS
		$_SESSION['password'] = $password;
		
		// Constraints on ConfirmationPassword
		$passwordconfirm = strip_tags($_POST['password_confirm']); // TAKE WHAT WAS SENT FROM THE POST FORM and STRIP TAGS REMOVES HTML TAGS
		$_SESSION['password_confirm'] = $passwordconfirm;
		
		// Checking to See if Password and Password Confirmation are the same.
		if ($password != $passwordconfirm) {
			array_push($error_array, "Passwords do not match. <br>");
		}
		else {
			if(preg_match('/[^A-Za-z0-9@]/', $password)) {
				array_push($error_array, "Your password should only contain alphanumeric characters. <br>");
			}
		}
		
		// Handling Length of Password.
		if ((strlen($password) > 30) || (strlen($password) < 5)) {
			array_push($error_array, "Your password should be between 5 and 30 characters <br>");
		}
		
		// Generating Random Picture First
		$randomPictureNumber = rand(0, 16);
		if($randomPictureNumber == 1) {
			$generatedPictureDirectory = "head_alizarin.png";
		}
		else if ($randomPictureNumber == 2) {
			$generatedPictureDirectory = "head_belize_hole.png";
		}
		else if ($randomPictureNumber == 3) {
			$generatedPictureDirectory = "head_carrot.png";
		}
		else if ($randomPictureNumber == 4) {
			$generatedPictureDirectory = "head_deep_blue.png";
		}
		else if ($randomPictureNumber == 5) {
			$generatedPictureDirectory = "head_emerald.png";
		}
		else if ($randomPictureNumber == 6) {
			$generatedPictureDirectory = "head_green_sea.png";
		}
		else if ($randomPictureNumber == 7) {
			$generatedPictureDirectory = "head_nephritis.png";
		}
		else if ($randomPictureNumber == 8) {
			$generatedPictureDirectory = "head_pete_river.png";
		}
		else if ($randomPictureNumber == 9) {
			$generatedPictureDirectory = "head_pomegranatehead_pumpkin.png";
		}
		else if ($randomPictureNumber == 10) {
			$generatedPictureDirectory = "head_red.png";
		}
		else if ($randomPictureNumber == 11) {
			$generatedPictureDirectory = "head_sun_flower.png";
		}
		else if ($randomPictureNumber == 12) {
			$generatedPictureDirectory = "head_turqoise.png";
		}
		else if ($randomPictureNumber == 13) {
			$generatedPictureDirectory = "head_wet_asphalt.png";
		}
		else {
			$generatedPictureDirectory = "head_wisteria.png";
		}
		
		
		// Pushing Everything To Database if Good
		if(empty($error_array)) {
			mysqli_query($con, "INSERT INTO user VALUES('', '$username', '$fname', '$lname', '$password', '0', 'no', '$generatedPictureDirectory', 'no', '', '', '$date', 'yes')");
			
			// Clear Session Variables
			$_SESSION['reg_fname'] = '';
			$_SESSION['reg_lname'] = '';
			$_SESSION['password'] = '';
			$_SESSION['password_confirm'] = '';
			$_SESSION['reg_username'] = '';
		}
	}
	
	if(isset($_POST['deleteUser'])) {
		$toDeleteID = $_POST['deleteID'];
		
		// DELETE ALL POSTS FROM USER IF MARKED
		if(isset($_POST['deleteAllPosts'])) {
			$authorfetch = mysqli_fetch_array(mysqli_query($con, "SELECT first_name, last_name FROM user WHERE user_id = '$toDeleteID'"));
			$author = ucfirst($authorfetch['first_name'])." ".ucfirst($authorfetch['last_name']);
			
			// DELETING ALL POST PAGES IN POST FOLDER FROM AUTHOR
			
			
			// DELETING ALL POSTS WHERE POST_AUTHOR is AUTHOR
			mysqli_query($con, "DELETE FROM posts WHERE post_author = '$author'");
		}
		
		// DELETING USER THEMSELVES
		mysqli_query($con, "DELETE FROM user WHERE user_id = '$toDeleteID'");
	}
	
	$error_array_for_alerts = array();
	if(isset($_POST['submitAlert'])) {
		// Constraints on Push Alert
		$alert = strip_tags($_POST['pushAlert']);
		
		// Making Sure Alert is Less than 30 Characters
		if(strlen($alert) > 30) {
			array_push($error_array_for_alerts, "Your alert must not be over 30 characters");
		}
		
		// Adding Alert to Alert Database
		if(empty($error_array_for_alerts)) {
			mysqli_query($con, "INSERT INTO alerts VALUES('', '$alert', 'yes')");
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- Below Belongs Our Title and Links -->
		<title>
			Monday Night Group
		</title>
		<!-- Links to Frameworks or Other Stuff -->
		<script src = "https://kit.fontawesome.com/de1b23d5aa.js" crossorigin="anonymous"></script> <!-- FONT AWESOME ICONS -->
		<script src = "assets/js/jquery-3.6.0.js"></script>
		<link rel = "stylesheet" type = "text/css" href = "assets/css/monday_night_group_bible_study.css"> <!-- WORKS BECAUSE IT IS ACCESSED FROM OUTER FILE -->
		<link rel="icon" type="image/x-icon" href="assets/images/favicon.ico">
		<meta name = "viewport" content = "width = device-width, initial-scale=1">
	</head>
	<!-- Main Body Belongs Below -->
	<body>
		<!-- MUST INCLUDE THIS BECAUSE SESSION VARIABLES START IN CONFIG → LOGIN_HANDLER.PHP (THIS SHOULD GO AT TOP OF PAGE, BUT DREAMHOST DOES NOT ALLOW -->
		<header class = "admin_panel_header">
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
						Header("Location: index.php");
					}
				}
				else {
					Header("Location: index.php");
				}
			?>
		</header>
		<main class = "adminpanelmain">
			<section class = "admin-grid">
				<div class = "welcome-admin">
					<img src = "
					<?php
						$namenew = mysqli_fetch_array(mysqli_query($con, "SELECT profile_picture, default_pic FROM user WHERE user_name = '$username'"));
						$image = $namenew['profile_picture'];
						$isdefaultpic = $namenew['default_pic'];
								
						if($isdefaultpic == 'yes') {
							$picture = "assets/images/defaults/$image";
						}
						else {
							$picture = "assets/images/profilepictures/$image";
						}
								
						echo "$picture";
					?>" class = "admin-profile-picture"></img>
					
					<div class = "column-of-welcome-admin">
						<h1> Welcome to Your Admin Panel: <?php
						$namefetch = mysqli_fetch_array(mysqli_query($con, "SELECT first_name, last_name FROM user WHERE user_name = '$username'"));
						$firstname = $namefetch['first_name'];
						$lastname = $namefetch['last_name']; 
						$name = $firstname." ".$lastname;
						echo $name;
						?> </h1>
						<h4> Today is <?php echo date("F j, Y"); ?> | <div id = 'time' style = 'display: inline; padding: 0px;'></div> </h4>
					</div>
					
					<script>
						// SCRIPT TO ADD REAL TIME IN PANEL (SINCE PHP TIME DOES NOT UPDATE);
						function checkTime(i) {
						  if (i < 10) {
							i = "0" + i;
						  }
						  return i;
						}

						function startTime() {
						  var today = new Date();
						  var h = today.getHours() % 12;
						  var m = today.getMinutes();
						  var s = today.getSeconds();
						  
						  var amorpm = '';
						  
						  if (today.getHours() > 12) {
							amorpm = 'PM';
						  }
						  else {
							amorpm = 'AM';
						  }
						  
						  m = checkTime(m);
						  s = checkTime(s);
						  document.getElementById('time').textContent = h + ":" + m + ":" + s + " " + amorpm;
						  t = setTimeout(function() {
							startTime()
						  }, 500);
						}
						startTime();
					</script>
					
				</div>
				<div class = "admin-overview">
					<h3> Overview </h3>
					<p> Total Users: <?php echo $numberOfUsers; ?> </p>
					<p> Total Posts: <?php echo $numberOfPosts; ?> </p>
					<p> Posts Within Last Month: <?php echo $numberOfPostsThisMonth; ?> </p>
				</div>
				<div class = "users">
					<h3> Current Users </h3>
					<hr>
					<?php 
						$users = mysqli_query($con, "SELECT * FROM user");
					
						// Get All User
						while($user_row = mysqli_fetch_array($users)) {
							$username = ucfirst($user_row['first_name'])." ".ucfirst($user_row['last_name']);
							$userid = $user_row['user_id'];
							$usernumpost = $user_row['num_post'];
							$isdefaultpic = $user_row['default_pic'];
							$profilepicture = $user_row['profile_picture'];
							
							if($isdefaultpic == 'yes') {
								$picture = "assets/images/defaults/$profilepicture";
							}
							else {
								$picture = "assets/images/profilepictures/$profilepicture";
							}
							
							echo "
								<div class = 'a_current_user'>
									<img src = '$picture' class = 'user-profile-picture' style = 'grid-area: picture'></img>
									<p style = 'grid-area: name'> $username </p>
									<p style = 'grid-area: numpost'> $usernumpost Post(s) </p>
									<p style = 'grid-area: userid'> ID: $userid </p>
								</div>
								<hr>
							";
						}
					?>
				</div>
				<form class = "add_user" method = "POST" action = "adminpanel.php" autocomplete = "off">
					<h3> Add User &nbsp <i class = "fa fa-user-plus fa-lg"></i> </h3>
					<input type = "text" placeholder = "First Name" name = "reg_fname" required></input>
					<input type = "text" placeholder = "Last Name" name = "reg_lname" required></input>
					<input type = "text" placeholder = "User Name" name = "reg_username" required></input>
					<input type = "password" placeholder = "Enter Password" name = "password" required></input>
					<input type = "password" placeholder = "Confirm Entered Password" name = "password_confirm" required></input>
					<input type = "submit" name = "addUser"></input>
				</form>
				<form class = "delete_user" method = "POST" action = "adminpanel.php">
					<h3 class = "delete_header"> Delete User &nbsp  <i class = "fa fa-trash-can fa-lg"></i> </h3>
					<div class = "organizeLegendandField">
						<label for = "deleteID" class = "deleteIDLabel"> Enter an ID to Delete </label>
						<input type = "number" name = "deleteID" class = "userIDEnter" max = "999"></input>
						<label for = "deleteAllPosts" class = "deleteAllPostsLabel"> Remove All Posts? </label>
						<input type = "checkbox" name = "deleteAllPosts" class = "deleteAllPostsCheckbox"></input>
					</div>
					<input type = "submit" name = "deleteUser" class = "deleteUserConfirm" value = "Delete"></input>
				</form>
				<form class = "push_alert" method = "POST" action = "adminpanel.php">
					<h3> Push Alert &nbsp <i class="fa-solid fa-circle-exclamation fa-lg"></i> </h3>
					<input type = "text" name = "pushAlert" placeholder = "EX: Group Canceled 4/29/22"></input>
					<input type = "submit" name = "submitAlert" value = "Alert Users"></input>
				</form>
				
				<div class = "information_For_Admin_Widget">
					<h2> Where Is The Website Hosted? </h2>
					The website is hosted on a <a href = "https://www.dreamhost.com/">Dreamhost</a> machine that runs 24/7. The database is hosted on 
					<a href = "https://east1-phpmyadmin.dreamhost.com/signon.php?pma_servername=GETYOUROWNSERVER">myPHPadmin</a>.
					It is protected, the password should never be shared with anyone. The login information to that database is: <details style = "display: inline; margin: 0px; background-color: #2f363e; padding: 10px; border-radius: 5px;"> 
					<summary> login info </summary> username: FIND YOUR OWN PASSWORD <br> password: FIND YOUR OWN PASSWORD </details>
					. Everything on the database works with hypertext preprocessor and SQL language. It is highly encouraged to not modified anything unless you absolutely 
					know what you are doing. The website is designed to operate without the user ever needing to touch the back-end.
					
					<h2> What if this Site Needs Service </h2>
					It should only need to be serviced if a bug occurs, otherwise it should run indefintely until the subscription runs out for being hosted on the server. 
					If a bug occurs, you can email <a href = "mailto: kennethpdang@gmail">kennethpdang@gmail.com</a>.
				</div>
			</section>
		</main>
		<footer class = "admin_footer">
			<span>
				<a href = "https://www.clearcreek.org/locations/" target = "_blank" class = "join-group"> Come to A Service! <i class = "fa fa-place-of-worship fa-lg"></i> </a> &nbsp;&nbsp;&nbsp;
				<a href = "https://www.clearcreek.org/group-details/?id=10979" target = "_blank" class = "join-group"> Join Us? <i class = "fa fa-handshake-angle fa-lg"></i> </a>
			</span>
			<h5> © <?php echo date('Y')."-".date('Y')+1; ?> &nbsp;&nbsp;&nbsp; Jonathan Brubaker & Alexis Brubaker </h5>
		</footer>
	</body>
</html>
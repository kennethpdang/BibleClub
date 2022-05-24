<?php
	require '../../config/config.php';
	
	// SET EVERYTHING TO NULL TO MAKE IT EASIER TO DEBUG
	$password = '';
	$username = '';
	$error_array = array();
	
	if(isset($_POST['login_button'])) {
		// Declaring Some Variables
		$username = strip_tags($_POST['log_username']);
		$username = strtolower($username);
		$_SESSION['username'] = $username;
		
		$password = strip_tags($_POST['log_password']);
		$password = strtolower($password);
		
		// Checking Database For Current Username and Password
		$check_username = mysqli_query($con, "SELECT user_name FROM user WHERE user_name = '$username' AND password = '$password'");
		$check_username_array = mysqli_num_rows($check_username);
		
		if($check_username_array == 1) {
			Header("Location: ../../index.php");
		}
		else {
			array_push($error_array, "Your email or username is incorrect");
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<!-- PHP CODE DOES NOT WORK SINCE DIRECTOR FOR STYLESHEET IS DIFFERENT -->
		<title>
			Monday Night Group
		</title>
		<!-- Links to Frameworks or Other Stuff -->
		<script src="https://kit.fontawesome.com/de1b23d5aa.js" crossorigin="anonymous"></script> <!-- FONT AWESOME ICONS -->
		<link rel = "stylesheet" type = "text/css" href = "../../assets/css/monday_night_group_bible_study.css">
		<script src = "../../assets/js/jquery-3.6.0.js"></script>
		<meta name = "viewport" content = "width = device-width, initial-scale=1">
	</head>
	
	<!-- Main Body Belongs Below -->
	<body>
		<header>
			<!-- We Include Navbar Stuff and Logo Using Header PHP NEEDED TO CHANGE SINCE THIS IS DIFFERENT PLACE -->
			<nav class = "main_nav_bar">
				<div class = "drop-down-menu" onclick = "openDropDownContent()">
					<button class = "drop-down-button"> <i class = "fa fa-bars fa-lg"></i> </button>
					<div class = "drop-down-content" id = "drop-down-content">
						<a href = "../../index.php"> Home &nbsp <i class = "fa fa-home fa-lg"></i> </a>
						<a href = "../../bible.php"> The Bible <i class = "fa fa-bible fa-lg"></i> </a>
						<a href = "../../includes/form_handlers/login_handler.php"> Log In &nbsp <i class = "fa fa-sign-out fa-lg"></i> </a>
						<a href = "../../aboutus.php"> About Us &nbsp <i class = "fa fa-users fa-lg"></i> </a>
					</div>
				</div>
			</nav>
			<!-- Script Changes Drop Down Content From Display None To Display Block  -->
			<script>
				var currentOddEven = 0; // Initialize Menu to Close Always
				// var content = document.getElementsByClassName("drop-down-content");
				var content = document.getElementById("drop-down-content");
				
				function openDropDownContent () {
					currentOddEven++;
					console.log(currentOddEven);
					openDropDownContent2(currentOddEven);
				}
				
				function openDropDownContent2(currentOddEven) {
					if(currentOddEven % 2 == 1) {
						content.style.display = "block";
					}
					else {
						content.style.display = "none";
					}
				}
			</script>
			
			<!-- Script to Enlarge Form On Small Screen (SINCE CSS NOT WORKING/ TEMPORARY FIX) -->
		</header>
		<main>
			<section id = "loading-welcome">
				<form action = "login_handler.php" method = "POST" class = "changesize">
					<div class = "log-in-panel">
						<!-- ECHO OUT USER ERRORS IN FORM -->
						<?php if(count($error_array) >0) {
							echo "<div class = 'formarea5'>
							$error_array[0];
						</div>";} ?>
						<div class = "formarea1 formheader">
							<h2> Log In Below </h2>
							<hr>
						</div>
						<div class="form__group field formarea2">
							<!-- NOTE LABEL MUST BE AFTER FOR IT TO WORK PROPERLY -->
						  <input type = "input" class = "form__field" placeholder = "User_Name" name = "log_username" id = 'name' value = "<?php if(isset($_POST['username'])) { echo $_SESSION['username']; } ?>" required />
						  <label for = "username" class="form__label"> Username </label>
						</div>
						<div class="form__group field formarea3">
							<!-- NOTE LABEL MUST BE AFTER FOR IT TO WORK PROPERLY -->
						  <input type = "password" class = "form__field" placeholder = "Password" name = "log_password" id = 'password' required />
						  <label for = "password" class = "form__label"> Password </label>
						</div>
						<input type = "submit" name = "login_button" value = "Login" class = "login_button formarea4">
					</div>
				</form>
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
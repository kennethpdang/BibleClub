<?php include("config/config.php"); ?>
<?php if(isset($_SESSION['username'])) {
		$username = $_SESSION['username'];
		$namearray = mysqli_fetch_array(mysqli_query($con, "SELECT first_name, last_name FROM user WHERE user_name = '$username'"));
		$name = ucfirst($namearray['first_name'])." ".ucfirst($namearray['last_name']);
	}

	if(isset($_POST['aboutmesave'])) {
		$aboutuser = $_POST['userabout'];
		$aboutuser = addslashes($aboutuser); // To prevent the periods from PHP thinking of as string concatenation.
		
		$userdateofbirth = $_POST['userdate'];
		
		mysqli_query($con, "UPDATE user SET about_user = '$aboutuser' WHERE user.user_name = '$username'");
		mysqli_query($con, "UPDATE user SET user_date = '$userdateofbirth' WHERE user_name = '$username'");
	}
	
	if(isset($_FILES['file'])) {
		$filename = $_FILES['file']['name']; // Get file and it's name and hold it locally.
		$location = "assets/images/profilepictures/".$filename; // Get location to save.
		
		// Move the PNG To It's Location
		move_uploaded_file($_FILES['file']['tmp_name'], $location);
		
		// Add the PNG Directory to Profile Picture
		mysqli_query($con, "UPDATE user SET profile_picture = '$filename' WHERE user_name = '$username'");
		// Update Default Profile Picture to No
		mysqli_query($con, "UPDATE user SET default_pic = 'no' WHERE user_name = '$username'");
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
		<main class = "onepagefullmain">
			<section id = "manageaccountsection">
				<div class = "userwelcome">
					<form action = "manageaccount.php" method = "POST" enctype = "multipart/form-data" class = "image-upload"> <!-- Image Upload Class Display Hides -->
						<label for = "file-input">
							<image src = "<?php
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
							?>
							" draggable = "false"></image>
						</label>
						<input id = "file-input" type = "file" name = "file" onchange = "this.form.submit()"> <!-- Onchange This.Form.Submit() will Submit Form As Soon As File is Uploaded -->
						<?php if(isset($_FILES['file'])) { echo "<div class = 'output'> Changed! </div>"; } ?>
						<!-- ID FOR LABEL MUST MATCH INPUT TO HIDE -->
					</form>
				
					<div>
						<h1> Welcome to Your Account, <?php echo $name ?>!</h1>
						<h3> Today is <?php echo date('l jS \of F Y'); ?> </h3>
						<h3> The Forecast Is: <div class = "weather" style = "display: inline; padding: 0px;"></div> °F &nbsp <i id = "injectweather"></i> </h3>
					</div>
				</div>
				
				<script>
				// Script to Pull Things from Server
				// Allows us to request API from LocalHost
				const proxy = 'https://cors-anywhere.herokuapp.com/';
				
				let apiLocation = 'GET YOUR OWN TOKEN';		
				const weatherApi = `${proxy}http://api.weatherapi.com/v1/current.json?key=${apiLocation}&q=galveston`;
				
				// Now Above Object
				fetch(weatherApi)
					.then(response => {
						return response.json();
					})
					.then(data => {
						console.log(data.current.temp_f);
						let whatIcon = data.current.condition.text;
						
						// Insert Into DOM Element
						document.getElementsByClassName("weather")[0].textContent = data.current.temp_f;
						
						// Get Icon DOM Element
						var injectweather = document.getElementById("injectweather");
						
						// Modify Weather Icon Based on Text
						if(whatIcon == "Partly cloudy" || whatIcon == "Cloudy" || whatIcon == "Overcast") {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud");
						}
						else if (whatIcon == "Mist" || whatIcon == "Fog" || whatIcon == "Freezing fog") {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud-fog");							
						}
						else if (whatIcon == "Patchy rain possible" || whatIcon == "Patchy freezing drizzle possible" || whatIcon == "Light showers of ice pellets" 
						|| whatIcon == "Light rain" || whatIcon == "Patchy light drizzle" || whatIcon == "Moderate rain at times" 
						|| whatIcon == "Light drizzle" || whatIcon == "Freezing drizzle" || whatIcon == "Heavy freezing drizzle" || whatIcon == "Patchy light rain" 
						|| whatIcon == "Light freezing rain" || whatIcon == "Light rain shower" || whatIcon == "Patchy light rain with thunder"){
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud-drizzle");
						}
						else if (whatIcon == "Patchy snow possible" || whatIcon == "Blowing snow" || whatIcon == "Light snow" || whatIcon == "Patchy light snow" ||
						whatIcon == "Patchy moderate snow" || whatIcon == "Light snow showers" || whatIcon == "Patchy light snow with thunder" || whatIcon == "Blizzard"
						|| whatIcon == "Heavy snow" || whatIcon == "Patchy heavy snow" || whatIcon == "Moderate snow" || whatIcon == "Moderate or heavy snow showers") {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud-snow");
						}
						else if (whatIcon == "Thundery outbreaks possible" || whatIcon == "Moderate or heavy rain with thunder" || whatIcon == "Moderate or heavy snow with thunder") {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud-bolt");
						}
						else if (whatIcon == "Patchy sleet possible" || whatIcon == "Light sleet" || whatIcon == "Moderate or heavy sleet" || whatIcon == "Moderate or heavy sleet showers"
						|| whatIcon == "Light sleet showers") {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud-sleet");
						}
						else if (whatIcon == "Moderate or heavy showers of ice pellets" || whatIcon == "Ice pellets") {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud-hail");
						}
						else if (whatIcon == "Moderate rain" || whatIcon == "Heavy rain at times") {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud-showers");
						}
						else if (whatIcon == "Heavy rain" || whatIcon == "Moderate or heavy freezing rain" || whatIcon == "Moderate or heavy rain shower" || whatIcon == "Torrential rain shower") {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-cloud-showers-heavy");
						}
						else {
							injectweather.classList.add("fa-solid");
							injectweather.classList.add("fa-sun");
						}
					});
				</script>
				
				<form class = "aboutmeform" method = "POST" action = "manageaccount.php">
					<div class = "aboutinfo">
						<h3> About Me </h3>
						<textarea name = "userabout" placeholder = "Share a little bit about yourself! Share your hobbies and your goals! All things posted here would be displayed to the about us page." required></textarea>
					</div>
					
					<div class = "dateofbirthinfo">
						<h3> Date of Birth </h3>
						<input type = "date" name = "userdate"></input>
					</div>
					
					<div class = "save_changes_center">
						<input type = "submit" class = "save_changes" name = "aboutmesave"></input>
					</div>
				</form>
				
				<div class = "alerts">
					<p> No Alerts at This Time </p>
				</div>
				
				<!-- Script to Calculate Height and OffSet From Navbar for Info Section -->
				<script> 
					// Script Uses JQuery
					$(document).ready(function() {
						var mainNavBarHeight = $(".main_nav_bar").height();
						
						// Setting Height of User Controls
						// Apparently There is A Difference Between JQuery Object and DOM Object
						$(".info")[0].style.height = "calc(100vh - " + mainNavBarHeight + "px)";
						
						// Setting OffSet from Top Nav for User Controls ID
						$(".info")[0].style.marginTop = mainNavBarHeight + "px";
						
						// On Small Screens Shift Everything Down So Navbar does not Overlap Widgets
						width = window.innerWidth; // Gets Width Of Device
						if(width < 420) {
							var mainNavBarHeight = $(".main_nav_bar").height();
							$(".onepagefullmain")[0].style.marginTop = mainNavBarHeight + 50 + "px";
						}
					});
				</script>
				
				<div class = "info">
					<h2> Do I Have to Share My Date Of Birth? </h2>
					<p> As Paul the Apostle says, by no means! The date of birth option is an unrequired field unlike the fields for logging in. What the purpose of date of birth is,
					is to let us know when we can celebrate your birthday and to notify others of that. In the future, if we choose to develop a bot to send notifications
					regarding birth dates, we may do so. </p>
					
					<h2> How To Delete an Account? </h2>
					<p> Please inform either Jonathan Brubaker or Alexis Brubaker of your intentions to delete your account. 
					They have an admin panel to monitor creation and deletion of accounts. </p>
					
					<h2> What Is the Purpose of This? </h2>
					<p> Reading through Romans as a group in the Fall of 2021, we encountered a lot of challenging verses in scriptures.
					For example, submission to governments in Romans 13:1. How are we supposed to interpret this? What about evil and tyrannical governments?
					Or what about in Romans 9:21-22, when Paul the Apostle is making the analogy between God's rights and a potter's right
					to make vessels of for honorable use and vessels for dishonorable use? With free-will being one of the tenants of Christianity, 
					the verse may make you restless because it seems counterintuitive. The whole purpose of this website is when we are told to wrestle through 
					'hard ideas' we may do so here. And hopefully, God willing, if we have a revelation or an epiphany we can share with others. This isn't set in stone, or strictly
					to adhere by, there are other purposes as mention below. Reflections on specific events in the days are good examples. </p>
					
					<h2> Which Post Should Be Posted? </h2>
					<p> Really, anything can be posted. Whenever I read the Bible, I annotate / make comments in three ways. I write:
					<ul>
						<li> Context: Literally, context! Like what are 'phylacteries' that the Pharisees wear in Matthew 23:5? What is a Centurion in Matthew 8?
						What is Samaritan in John 4 (are they Gentiles, or Jews, or something completely different, or both)? Who was the Queen of the South?
						Who are the Levites? So on and so forth. </li>
						<li> Big Idea: What is the general meaning of a string of verses? For example, in Matthew 10:24, I wrote "the sword Jesus brings is the conflict
						that people may experience in being called to love Jesus above all others (including family members). For example, the Christian faith may get
						you killed in communist countries." In Matthew 7:16, in regards to recognizing false prophets, I wrote "fruits are probably 'works'. For example, Jim Jones 
						was a cult leader that lead a mass-murder suicide and David Koresh was a cult leader that participated in gun fights." </li>
						<li> Connection: In Matthew 6:1, when Jesus says, "Beware of rpracticing your righteousness before other people in order to be seen by them, for then you will have no reward from your Father who is in heaven."
						I wrote the connection to myself, as I always wanted to start a YouTube channel. Being guilty, I wrote, "Think of yourself? Would it then be just to record a video
						on YouTube or something along these lines?" That is, something akin to the Mr. Beast type of videos. </li>
						<li> Question: Examples for this category would be in Matthew 20:16, when Jesus was talking about the last being first and first being last, I wrote "if a sick and elderly woman
						fully believes in Christ and repents, does that mean she would be first in Heaven compared to someone also faithful but born into a community of believers?". Some of the harder questions are also in Matthew, like
						after reading the Parable of the Sower where Jesus makes an analogy between humans and the soil and the Word of the Lord being seeds, I encountered the Parable of the Weeds. 
						...finish line of though...</li>
					</ul>
					The website, was originally developed in regards to questions that are open ended like the last. However, as developing it, I felt that there was no need for any restriction
					as all categories may help a user from our group or anyone having a link seeking a question.
					
					<h2> Are All the Posts Public? Can I Create a Private Post for Just the Group? </h2>
					<p> There is a short and long technical answer. <br><br> Short Answer: Posts are public unless you set it to private-only before posting. <br><br>
					Long Answer: Think of a website like an artwork that you created. In order for others to view the artwork, it has to be posted to a gallery. 
					The artwork is analogous to the files containing the code (HTML/CSS/JS/PHP/SQL) and the gallery / art museum is analogous to a server (that is
					a machine running 24/7 where your files are hosted). The code for this website are hosted on dreamhost for ~$1.97 a month. Anyone with that link, 
					would be directed to a guest webpage, which won't display articles that aren't set to the public. If that guest signs in (meaning he / she 
					is part of the small group), then the articles would be display. If you really want to get into the nitty gritty, this is done with 
					<a href = "https://www.w3schools.com/php/php_sessions.asp" target = "_blank"> PHP SESSION variables </a>,
					which you can feel free to search up. </p> 
					
					<h2> What Happens to All Submitted Data? </h2>
					<p> It is stored on the database indefinitely until we run out of money to pay for the server. Or until it is deleted by the user. If a user 
					is removed by the Brubakers the content will still remain on the website, because the purpose of the website is to share what we have "wrestled through"
					with already. However, if it is requested that ALL content be removed once the user is deleted, there is a method for the Brubaker's to do so through,
					the admin panel. </p>
					
					<h2> How Did This Became to Be? </h2>
					<p> Bear with us for a while. An anonymous member, who needs no honor or mention was a computer science major. Part of getting a job as a computer science 
					major is doing a lot of "self projects" like this, and posting the code on a place called <a href = "https://github.com/" target = "_blank"> GitHub </a> as well as a link to your personal GitHub on your resume. 
					He had a lot of ideas originally, like making a video game or some website to share mathematical content. However, in the end, he wanted to serve his community, 
					and those who truly loved. He was a sinner and just as broken as everyone else, and was in some dark places prior. However, he felt so loved and welcomed by this group 
					that this is the way he decided to serve them. </p>
					
					<h2> What is the Purpose Of Alerts? </h2>
					<p> Alerts, that is the piece to your left are used to push notifications like cancellation of group, church events, Go Ops opportunities, alternative
					meeting places, or information of that nature. NEEDS IMPLEMENTATION: All members can push alerts, but the blue alerts are from the Brubakers. </p>
					</div>
			</section>
		</main>
	</body>
</html>
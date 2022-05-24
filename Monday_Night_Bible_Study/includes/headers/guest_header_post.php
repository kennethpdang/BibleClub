<nav class = "main_nav_bar">
	<div class = "drop-down-menu" onclick = "openDropDownContent()">
		<button class = "drop-down-button"> <i class = "fa fa-bars fa-lg"></i> </button>
		<div class = "drop-down-content" id = "drop-down-content">
			<a href = "../index.php"> Home &nbsp <i class = "fa fa-home fa-lg"></i> </a>
			<a href = "../bible.php"> The Bible <i class = "fa fa-bible fa-lg"></i> </a>
			<a href = "../includes/form_handlers/login_handler.php"> LogIn <i class = "fa fa-sign-in fa-lg"></i> </a>
			<a href = "../aboutus.php"> About Us &nbsp <i class = "fa fa-users fa-lg"></i> </a>
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
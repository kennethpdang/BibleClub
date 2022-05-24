<?php
// We Got To Adjust PHP For This Specific File
include("../../config/config.php");

if(isset($_GET['deleteId'])){ // DeleteID Was What We Called It In Data Attribute in AJAX
    $id = $_GET['deleteId']; // DeleteID Was What We Called It In Data Attribute in AJAX
    delete_data($con, $id); // Past These to A Function Called Delete_Data
}

function delete_data($con, $id) {
	// Deleting Post File From Folder
	$linkquery = mysqli_fetch_array(mysqli_query($con, "SELECT post_link, picture_directory_inner, post_author FROM posts WHERE id = '$id'"));
	$link = strval($linkquery['post_link']);
	$picture_directory_inner = strval($linkquery['picture_directory_inner']);
	$author = strval($linkquery['post_author']);
	$name = explode(' ',$author);
	$first_name = $name[0];
	$last_name = $name[1];
	
	// Deleting Number of Posts from Author
	mysqli_query($con, "UPDATE user SET num_post = num_post - 1 WHERE user.first_name = '$first_name' AND user.last_name = '$last_name'");
	
	// Need to Make Sure Picture is Delete ONLY if Picture is Not Done in Default
	if(!str_contains($picture_directory_inner, "post_pictures_inside_default")) { // DOES NOT CONTAIN A DEFAULT
		unlink("../".$picture_directory_inner); // DELETING PICTURE FROM DIRECTORY OF DELETEPOST.PHP
	}

	unlink("../../posts/".$link.".php");
	// THIS DUMB THING ABOVE COSTS ME SEVERAL HOURS TO DEBUG! NEEDED BOTH FILE EXTENSION AND PERIOD.
	
	// Deleting Post From Database
	$queryDelete = "DELETE FROM posts WHERE id = '$id'";
	$exec = mysqli_query($con, $queryDelete);
	
	// Refresh Page
	echo("<meta http-equiv='refresh' content='1'>");
}
?>
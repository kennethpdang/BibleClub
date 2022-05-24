<?php
$filename = $_FILES['file']['name']; // Get file and it's name and hold it locally.
$location = "../../assets/images/profilepictures".$filename; // Get location to save.

echo "<script> console.log('$filename') </script>";
echo "<script> console.log('$location') </script>";

// Moves the file to the location specified. 
if(move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
	echo "<script> alert('file moved successfully') </script>";
}
else {
	echo "<script> alert('Error uploading file') </script>";
}
?>
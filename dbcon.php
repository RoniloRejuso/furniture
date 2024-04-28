<?php
$conn= mysqli_connect('localhost', 'root', '', 'furniture');
if (!$conn) {
	// 	echo ("Connection Failed: ".mysqli_error($conn));
	echo ("Connection Failed: " . mysqli_connect_error());
	exit;
}
?>
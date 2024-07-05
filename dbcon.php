<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost"; // Update if necessary
$username = "u138133975_ourhome";
$database = "u138133975_furniture";
$password = "A@&DDb;7";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "";
?>

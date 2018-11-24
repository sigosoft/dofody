<?php
$server = "localhost";
$database = "rs500and_domino";
$username = "rs500and_doctor";
$password = "123456789";

$con = mysqli_connect($server,$username,$password) or die('Unable to Connect');
 if($con)
 {
 	mysqli_select_db($con,$database);
 	//echo "connected";
 }
 ?>
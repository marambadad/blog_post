<?php
session_start(); // Start the session.
if (isset($_SESSION['user_id'])) {
	include ('header.php');
	echo 'You are logged in!			
} else { 
	header('Location: http://mobadad.uwmsois.com/_____/final/login.php');
}
?>
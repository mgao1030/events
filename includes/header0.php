<!DOCTYPE html>
<html>
<head>
<title>Tech Events in New York</title>
<link rel="stylesheet" type="text/css" href="includes/techevents.css" />
</head>
<body style="background-image:url('images/newyork.png');background-size:100% auto;margin:0px;">
<header>
	<br>
	<br>
	<a href="index.php"><img src="images/logo.png" width="80" height="80"></a>
	<h1>Tech Events in New York</h1>
	<br>
	
	<?php
	if (isset($_SESSION['fname']) && isset($_SESSION['lname']) ) {
		echo "<h4>Welcome, ".$_SESSION['fname']." ".$_SESSION['lname'];
		echo "<br>";
		echo "<br>";
		echo "<a class='registered' href=\"registered.php\">View registered events</a> | <medium><a href=\"sign_out.php\">Log out</a></medium></h4>";
		echo "<br>";
	}
	?>
</header>
<div id="body">
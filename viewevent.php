<?php
session_start();


require_once 'includes/auth.php';
include_once 'includes/header.php';
require_once 'includes/login.php';
require_once 'includes/functions.php';
echo "<br>";
$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

if (isset($_GET['id'])) {
	$id = sanitizeMySQL($conn, $_GET['id']);
	
	$query = "SELECT name,date_format(start_time, '%Y/%m/%d %l:%i%p') as start_time,date_format(end_time, '%l:%i%p') as end_time,street_address,city,state,zip,description
	FROM events JOIN address
	ON events.address_id = address.address_id WHERE event_id =".$id;
	$result = $conn->query($query);
	if (!$result) die ("Invalid event id.");
	$rows = $result->num_rows;
	if ($rows == 0) {
		echo "No event found with id of $id<br>";
	} else {
		while ($row = $result->fetch_assoc()) {
			echo '<h3>Event Information</h3>';
			echo '<p>'." Event Name: " . $row["name"]." <br><br>Date and Time: ".$row["start_time"]." - ".$row["end_time"]." <br><br>Address: ".$row["street_address"].", ".$row["city"].", ".$row["state"]." ".$row["zip"]."<br><br>Description: ".$row["description"].'</p>';		
		}
	}
}
#if user has registered this event, then echo "update"; if not, then echo "RSVP"
if (isset($_GET['id'])) {
	$id = sanitizeMySQL($conn, $_GET['id']);
	
	$query2 = "SELECT * FROM registration 
	WHERE user_id = $_SESSION[user_id]
	AND event_id =".$id;
	$result2 = $conn->query($query2);
	if (!$result2) die ("Database access failed: " . $conn->error);
	$rows2 = $result2->num_rows;
	if ($rows2 > 0) {
		echo "<p><a href=\"update.php?id=$id \">Update event preference</a><br><br> <a href=\"cancel.php?id=$id \">I'm not attending any more!</a></p>";
		echo "<br>";
		echo "<p><a href=\"index.php\">Return to homepage</a></p>";

	} else {		
		echo "<p><a href=\"registration.php?id=$id \">I'm interested!</a></p>";
		echo "<br>";
		echo "<p><a href=\"index.php\">Return to homepage</a></p>";
		} 
}
include_once 'includes/footer.php';
?>

<style>
#body{width:60%;}
</style>
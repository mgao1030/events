<?php
session_start();


require_once 'includes/auth.php';
include_once 'includes/header.php';
require_once 'includes/login.php';

$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);

$query = "SELECT event_id, name, date_format(start_time, '%Y/%m/%d %l:%i%p') as start_time, date_format(end_time, '%Y/%m/%d %l:%i%p') as end_time, street_address, city, state, zip, description
				FROM events JOIN address
				ON events.address_id = address.address_id
				ORDER BY start_time ASC";
$result = $conn->query($query);
if (!$result) die ("Database access failed: " . $conn->error);
$rows = $result->num_rows;
echo "<br>";
echo "<table><tr><th>Event Name</th><th>Time</th><th>Address</th><th>Description</th></tr>";
while ($row = $result->fetch_assoc()) {
	echo '<tr>';
	echo "<td>";
	echo "<a href=\"viewevent.php?id=".$row["event_id"]."\">".$row["name"]."</a>";
	echo "</td><td>".$row["start_time"]."</td><td>".$row["street_address"]."<br>".$row["city"].", ".$row["state"]." ".$row["zip"]."</td><td>".$row["description"]." </td>";
	echo '</tr>';
}

echo "</table>";

include_once 'includes/footer.php';
?>

<style>
#body{width:90%;}
</style>
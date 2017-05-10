<?php
session_start();


require_once 'includes/auth.php';
require_once 'includes/login.php';
require_once 'includes/functions.php';
date_default_timezone_set('America/New_York');

if (isset($_POST['submit'])) { //check if the form has been submitted
	if ((empty($_POST['num_guests'])) || (empty($_POST['mealpref_id'])) ) {
		$message = '<p class="error">Please fill out all of the form fields!</p>';
	} else {
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$user_id = $_SESSION['user_id'];
		$event_id = sanitizeMySQL($conn, $_GET['id']);
		$date_registration = date('Y-m-d', time());
		$mealpref_id = sanitizeMySQL($conn, $_POST['mealpref_id']);
		$num_guests = sanitizeMySQL($conn, $_POST['num_guests']);
		$query = "UPDATE registration
		SET date_registration = \"$date_registration\", mealpref_id = $mealpref_id, num_guests = $num_guests
		WHERE user_id = $user_id and event_id = $event_id";
		$result = $conn->query($query);
		if (!$result) {
			die ("Database access failed: " . $conn->error);
		} else {
			$message = "<p class=\"message\">You have successfully updated your event preference! <br><a href=\"index.php\"><br/>Return to events list</a></p>";
		}
	}
}
?>

<?php
include_once 'includes/header.php'; 
if (isset($message)) echo $message;
echo "<br>";
?>

<form method="post" action="">
	<fieldset>
		<legend>RSVP</legend>
		<label for="num_guests">Number of Guests:</label>
		<input type="text" name="num_guests"><br> 		
		<label for="mealpref">Meal Preference:</label> 
		<select name="mealpref_id">
		  <option value="1">Regular</option>
		  <option value="2">Diabetic</option>
		  <option value="3">Gluten-free</option>
		  <option value="4">Kosher</option>
		  <option value="5">Muslim</option>
		  <option value="6">Vegan</option>
		</select><br>
		<input type="submit" name="submit">
	</fieldset>
</form>
<?php include_once 'includes/footer.php'; ?>
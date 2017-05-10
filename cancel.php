<?php
session_start();


require_once 'includes/auth.php';
require_once 'includes/login.php';
require_once 'includes/functions.php';


$conn = new mysqli($hn, $un, $pw, $db);
if ($conn->connect_error) die($conn->connect_error);
$user_id = $_SESSION['user_id'];
$event_id = sanitizeMySQL($conn, $_GET['id']);
$query = "DELETE FROM registration 
WHERE user_id = $user_id and event_id = $event_id";
if ($conn->query($query) === TRUE) {
		$message = "<p class=\"message\">Your registration has been canceled! <br><a href=\"index.php\"><br/>Return to events list</a></p>";
} else {
		$message = "<p class=\"message\">Error canceling registration. <br><a href=\"index.php\"><br/>Return to events list</a></p>";
}
?>

<?php
include_once 'includes/header.php'; 
if (isset($message)) echo $message;
?>

<?php include_once 'includes/footer.php'; ?>
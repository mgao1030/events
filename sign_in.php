<?php
session_start();

require_once 'includes/login.php';
require_once 'includes/functions.php';

if (isset($_POST['submit'])) { //check if the form has been submitted
	if ( empty($_POST['username']) || empty($_POST['password']) ) {
		$message = '<p class="error">Missing username or password!</p>';
	} else {
		$conn = new mysqli($hn, $un, $pw, $db);
		if ($conn->connect_error) die($conn->connect_error);
		$username = sanitizeMySQL($conn, $_POST['username']);
		$password = sanitizeMySQL($conn, $_POST['password']);			
		$salt1 = "asd&*";  
		$salt2 = "@&E1e";  
		$password = hash('ripemd128', $salt1.$password.$salt2);
		$query  = "SELECT fname, lname, user_id FROM users WHERE username='$username' AND password='$password'"; 
		$result = $conn->query($query);    
		if (!$result) die($conn->error); 
		$rows = $result->num_rows;
		if ($rows==1) {
			$row = $result->fetch_assoc();
			$_SESSION['fname'] = $row['fname'];
			$_SESSION['lname'] = $row['lname'];
			$_SESSION['user_id'] = $row['user_id'];
			$goto = empty($_SESSION['goto']) ? '/events/' : $_SESSION['goto'];			
			header('Location: ' . $goto);
			exit;			
		} else {
			$message = '<p class="error">Wrong username or password. Please try again!</p>';
		}
	}
}
?>

<?php 
include_once 'includes/header0.php'; 
if (isset($message)) echo $message;
echo "<br>";
?>
<fieldset style="width:30%"><legend>Log-in</legend>
<form method="POST" action="">
Username:<br><input type="text" name="username" size="50"><br>
Password:<br><input type="password" name="password" size="50"><br>
<input type="submit" name="submit" value="Log-In">
</form>
</fieldset>

<?php
include_once 'includes/footer.php';
?>
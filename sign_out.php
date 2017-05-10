<?php
session_start();
$_SESSION = array();
session_destroy();
include_once 'includes/header0.php';
echo "<p>You are now logged out!</p>";
echo "<p><a href=\"index.php\">Return to homepage</a></p>";
include_once 'includes/footer.php';
?>

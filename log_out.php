<?php require_once("includes/functions.php"); ?>
<?php require("includes/login_test.php"); ?>
<?php
$_SESSION = array(); //unset all the session variables

if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time() - 42000, '/');
}

session_destroy();

redirect_to();
 ?>

 <p><a href="index.php">login account</a></p>
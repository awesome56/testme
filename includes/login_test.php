<?php //include_once("includes/functions.php");  ?>

<?php 
session_start();
if ((!isset($_SESSION['name'])) &&  (!isset($_SESSION['id']))){

	redirect_to();
	//header('Location:index.php');
}

?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_testme.php");?>
<?php include("includes/header.php"); ?>
<?php
unset($_SESSION['exam']);
unset($_SESSION['subject']);
unset($_SESSION['year']); 
unset($_SESSION['noq']);
?>


	<div class="body">
		

<p>Edit created test</p>

<p>Create new test</p>



<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?> ">

			


	<p>Subject:<br><input type="text" name="subject_type"></p>
	
	<p>year: <br><input type="number" min="1600" max="2099" step="1" value="2019" name="year"></p>
	<p>no of questions:<br><input type="number" min="1" step="1" name="n_o_q"></p>
	<p><input type="Submit" name="create_test" value="+create test"></p>

</form> 


<?php  
if ( isset($_POST["create_test"])){

	
	$subject = $_POST['subject_type'];
	$year = $_POST['year'];
	$noq = $_POST['n_o_q'];

	$_SESSION['exam'] = "CREATED TEST";
	$_SESSION['subject'] = $subject;
	$_SESSION['year'] = $year;
	$_SESSION['noq'] = $noq;

header("Location: create_question.php");


}
	 	
?>


	</div>
<?php
require("includes/footer.php");
?>
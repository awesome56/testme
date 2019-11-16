<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_testme.php");?>
<?php include("includes/header.php"); ?>



<div class="body">
		<h3>Please choose examination type</h3>
		<div>

<?php 

// checks if its default or user

$run_query_etype = get_all_examtype(0);

?>			
<?php

$no = 0;
while ($test_type = mysqli_fetch_assoc($run_query_etype)) { /*loop to display type of text and subject*/
?>
<form method="POST" action="">
<fieldset>
<legend><h4> <?php echo $test_type['exam_name']; ?> </h4></legend>

<?php $exam_d[$no] = array('id' => $test_type['id'], 
                        'user_id' => $test_type['user_id'],
                        'exam_name' => $test_type['exam_name']
                    ); 
?> 

<input type="submit" name="<?php echo $exam_d[$no]['exam_name'] ?>" value="select subject">

</fieldset>
</form>
<?php $no++; } ?>




<fieldset>
<legend><h4> CREATED TESTS </h4></legend>
<?php
$query = "SELECT * FROM subjects WHERE user_id = {$_SESSION['id']} and exam_id = 6 ";

		$run_query = mysqli_query($connection, $query);

		$run = mysqli_num_rows($run_query);
if ($run > 0)//checks if user have created any exam 

{

?>
<form method="POST" action="">
<?php $exam_d[4] = array('id' => 6, 
                        'user_id' => 1,
                        'exam_name' => "CREATED TESTS"
                    ); 
?> 

<input type="submit" name="CREATED_TESTS" value="select subject">


</form>
	
<?php  // loop through subject ends
}else{ ?>

	<p>...you have not created any test...<br>

					...<a href="create_test.php">create test</a>...</p>
<?php
}

?>
</fieldset>
		


<?php


for ($i=0; $i < 4; $i++) { 
	if (isset($_POST[$exam_d[$i]['exam_name']])) {
		$_SESSION['st_id'] = $exam_d[$i]['id'];
		$_SESSION['st_user_id'] = $exam_d[$i]['user_id'];
		$_SESSION['st_exam_name'] = $exam_d[$i]['exam_name'];

		header("Location:start_test_subject.php");
	}
}

if (isset($_POST["CREATED_TESTS"])) {
		$_SESSION['st_id'] = 6;
		$_SESSION['st_user_id'] = $_SESSION['id'];
		$_SESSION['st_exam_name'] = "CREATED TESTS";

	header("Location:start_test_subject.php");
}
?>


	</div>
<?php
require("includes/footer.php");
?>
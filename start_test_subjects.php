<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_testme.php");?>
<?php include("includes/header.php"); ?>
<?php require("includes/admin_test.php"); ?>


<?php
//defines arrays of test_type, subjects and created_test selection 
$c_test/*created_test*/ = array();
?>

<div class="body">
		<h3>Please choose examination type</h3>
		<div>

<?php 
// checks if its default or user

$run_query_etype = get_all_examtype(0);

?>			
<?php

while ($test_type = mysqli_fetch_assoc($run_query_etype)) { /*loop to display type of text and subject*/
?>

<fieldset>
<legend><h4> <?php echo $test_type['exam_name']; ?> </h4></legend>

<ul id="subjectmenu">
	<li><a href="#">select subject:</a>
		<ul class="sub1"><!-- list of subjets-->
			
<?php 

$run_query_subject = get_subjects($test_type['id']);
while ($subject =	mysqli_fetch_array($run_query_subject)) { //loop through subject start

?>
<!-- subjects list starts here-->
<li>
<a href="#"><?php echo $subject['subjects'];?></a>

<ul class="sub2"> <!-- list of exam year-->
<?php 

$run_query_year = get_year($subject['id']);
	while($years = mysqli_fetch_array($run_query_year)){//loop through year of exam
?>
<?php
			echo "<li><a href=\"questions.php?subj= " . urlencode($years["id"]) . "\"> {$years["year"]}</a></li>"; /*exam year list starts and ends here*/
?>
<?php		 } ?>
		</ul>						 	
	</li>
	<!-- subjects list ends here-->
<?php } // loop through subject ends?>

			</ul>
		</li>
	</ul>
</ul>
</fieldset>
<?php } ?>




<fieldset>
<legend><h4> CREATED TESTS </h4></legend>
<?php
$query = "SELECT * FROM subjects WHERE user_id = {$_SESSION['id']} and exam_id = 6 ";

		$run_query = mysqli_query($connection, $query);

		$run = mysqli_num_rows($run_query);
if ($run > 0)//checks if user have created any exam 

{
?>

<ul id="subjectmenu">
	<li><a href="#">select subject:</a>

<?php 
// checks user id

$run_query_etype = get_all_examtype(1);

?>			
<?php

while ($test_type = mysqli_fetch_array($run_query_etype)) { /*loop to display type of text and subject*/
?>


		
<?php 

$run_query_subject = get_c_subjects($_SESSION['id']);

while ($subject =	mysqli_fetch_array($run_query_subject)) { //loop through subject start



					?>

					<ul class="sub1"> <!-- list of exam year-->
<?php 

$run_query_year = get_year($subject['id']);

$run = mysqli_num_rows($run_query_year);


	while($years = mysqli_fetch_array($run_query_year)){//loop through year of exam

			echo "<li><a href=\"questions.php?subj= " . urlencode($years["id"]) . "\"> {$subject["subjects"]} . {$years["year"]}</a></li>"; /*exam year list starts and ends here*/

		 } ?>
		</ul ><!-- year ul ends -->	
					
 	


<?php

				}
				

			?>

	
<?php } // loop through subject ends
}else{ ?>

	<p>...you have not created any test...<br>

					...<a href="create_test.php">create test</a>...</p>
<?php
}

?>

		</li>
	</ul>
</ul>
</fieldset>




	</div>
<?php
require("includes/footer.php");
?>
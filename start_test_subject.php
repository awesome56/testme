<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_testme.php");?>
<?php include("includes/header.php"); ?>




<?php
if (isset($_SESSION['st_id']) && isset($_SESSION['st_user_id']) &&  isset($_SESSION['st_exam_name'])) {
	//header("Location:start_test.php");


?>


<form method="POST" action="">
	<fieldset>
		<legend><h4><?php echo $_SESSION['st_exam_name']; ?></h4></legend>
<?php
$no = 0;
$sn = 0;

		$query = "SELECT * 
				FROM subjects
				WHERE user_id = {$_SESSION['st_user_id']}
				AND exam_id = {$_SESSION['st_id']}  ";

	$run_query = mysqli_query($connection, $query);
	
	confirm_query ($run_query);



while ($subject = mysqli_fetch_array($run_query)) { /*loop to display subjects*/
?>		


<?php $subject_d[$sn] = array(
						'user_id'	=> $subject['user_id'], 
                        'id' 		=> $subject['id'],
                        'exam_id' 	=> $subject['exam_id'],
                        'subject' 	=> $subject['subjects'],
                        'year' 		=> $subject['year']
                    ); 
?>

		<fieldset>
			<legend><h5><?php echo $subject['subjects'];?></h5></legend>


<select name="<?php echo $subject_d[$sn]['id'];?>">

<?php

$query_year = "SELECT * 
			   FROM exam_year 
			   WHERE subject_id = {$subject['id']} ";

$run_query_year = mysqli_query($connection, $query_year);
confirm_query($run_query_year);





while($years = mysqli_fetch_array($run_query_year)){//loop through year of exam

?>

	<?php $year_d[$no] = array(
						'id' 			=> 	$years['id'], 
                        'user_id' 		=>  $years['user_id'],
                        'subject_id' 	=>  $years['subject_id'],
                        'year' 			=> 	$years['year']
                    ); 
?> 

	<p><option value="<?php echo $year_d[$no]['id']; ?>"><?php echo $year_d[$no]['year']; ?></option></p>


<?php
$no++;
}
?>

</select>

		<p><input type="submit" name="<?php echo 'submit'.$sn;?>" value="start test"></p>
		</fieldset>

<?php
$sn++;
}

?>



	</fieldset>


</form>
<?php 
// foreach ($year_d as $key => $value) {
// 	echo "ID: {$value['id']} ParentID: {$value['user_id']} subject id: {$value['subject_id']} year: {$value['year']} <br>";
// }

// foreach ($subject_d as $key => $value) {
// 	echo "USER ID: {$value['user_id']} EXAM ID:{$value['exam_id']} ID: {$value['id']} subject: {$value['subject']} year: {$value['year']} <br>";
// }

// 	if (isset($_POST['submit'])) {

// 		$_year       = $_POST['year'];

// 		echo $_year;

// }

for ($i=0; $i < sizeof($subject_d); $i++) { 
	if (isset($_POST["submit".$i])) {

		
		$_SESSION['st_year'] = $_POST[$subject_d[$i]['id']];
		$_SESSION['act_year'] = $subject_d[$i]['year'];
		$_SESSION['act_subj_id'] = $year_d[$i]['subject_id'];


		header("Location:questions.php");

	}
}


}else{ redirect_to('start_test.php'); }




 ?>


<?php
require("includes/footer.php");
?>
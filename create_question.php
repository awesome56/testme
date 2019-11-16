<?php session_start(); ?>
<?php include("includes/db_testme.php"); ?>
<?php require_once("includes/functions.php");  ?>

<?php


	if (isset($_SESSION['subject']) && isset($_SESSION['year']) && isset($_SESSION['noq'])) {
		
	
	
		$passed = array(
		'exam' => mysql_prep($_SESSION['exam']),
		'subject' => mysql_prep($_SESSION['subject']),
		'year' => mysql_prep($_SESSION['year']),
		'noq' => mysql_prep($_SESSION['noq'])
		);
	
		echo "<h3>" . $passed['exam'] . "</h3>";
	echo "<h3>".$passed['subject']." ".$passed['year']."</h3><br>";
?>

<?php
if ($passed['exam'] == "CREATED TEST") { //Tests if exam to be created is from client of admin
	$u_id = mysql_prep($_SESSION['id']); //if true, assigns user id to variable
	$e_id = 6; //if true, assigns created test id to exam id
}else{
	$u_id = 0; //if false, assigns default question id to user id
	$query = "SELECT * FROM exam_type WHERE exam_name = '{$_SESSION['exam']}' "; //query to get selected exam id (default exams/tests)
	$run_query = mysqli_query($connection, $query);

		$result_id = mysqli_fetch_array($run_query);

	$e_id = mysql_prep($result_id['id']); //assigns selected exam id (default exams/tests)
}

// echo $u_id . " " . $e_id;

?>

<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?> ">
<?php  
for ($i=0; $i < $passed['noq']; $i++) { //loop to print entry box for questions and options
	?>
	<fieldset><legend>question <?php echo " ". $i+1;  ?></legend>
<textarea name="<?php echo 'question'.$i; ?>" placeholder="question" cols= 40 rows=4></textarea>
<p><textarea name="<?php echo 'answer'.$i; ?>" placeholder="answer"></textarea></p>
<p><textarea name="<?php echo 'option_1'.$i; ?>" placeholder="option 1"></textarea></p>
<p><textarea name="<?php echo 'option_2'.$i; ?>" placeholder="option 2"></textarea></p>
<p><textarea name="<?php echo 'option_3'.$i; ?>" placeholder="option 3"></textarea></p>
<p><textarea name="<?php echo 'option_4'.$i; ?>" placeholder="option 4"></textarea></p>
</fieldset>
	<?php
}
?>
<p><input type="submit" name="create" value="create"></p>
</form>
<?php
$quest = array();
if (isset($_POST['create'])) {	

for ($i=0; $i < $passed['noq']; $i++){ //loop to assign question and option into an array

$quest[$i] = array(
			mysql_prep($_POST['question'.$i]), 
			mysql_prep($_POST['answer'.$i]),
			mysql_prep($_POST['option_1'.$i]),
			mysql_prep($_POST['option_2'.$i]),
			mysql_prep($_POST['option_3'.$i]),
			mysql_prep($_POST['option_4'.$i])
		);

}

//function add_id auto increments id in database
$count = mysql_prep(add_id('subjects')); 
$count_year =  mysql_prep(add_id('exam_year'));
$count_question = mysql_prep(add_id('questions'));


if ($u_id == 0) { //checks if user id is default test
$query = "SELECT * 
		FROM subjects 
		WHERE subjects = '{$passed['subject']}' 
		AND exam_id = '$e_id' ";
	$run_query = mysqli_query($connection, $query);

		$result = mysqli_num_rows($run_query);
		$result_id = mysqli_fetch_array($run_query);
	if ($result <= 0){ //checks if subject already exist
$query = "INSERT INTO subjects (user_id, id, exam_id, subjects, year) 
VALUES ('$u_id', '$count', '$e_id', '{$passed['subject']}', '{$passed['year']}')";//subject does not exist
		$run_query = mysqli_query($connection, $query); //adds subjects into subject list
		confirm_query ($run_query);


$query = "INSERT INTO exam_year (id, user_id, subject_id, year) 
		VALUES ('$count_year', '$u_id', '$count', '{$passed['year']}')";
		$run_query = mysqli_query($connection, $query); //adds year into year list
		confirm_query ($run_query);
	}else { //if subject exist

		$s_id = $result_id['id']; //assigns existing subject's id as subject id
		//runs only year query
		$query = "INSERT INTO exam_year (id, user_id, subject_id, year) 
		VALUES ('$count_year', '$u_id', '$s_id', '{$passed['year']}')";
		$run_query = mysqli_query($connection, $query); //adds year into year list
		confirm_query ($run_query);
	}		

	
}else { //if user id is created test
$query = "SELECT * 
		FROM subjects 
		WHERE subjects = '{$passed['subject']}' 
		AND exam_id = '$e_id' ";
	$run_query = mysqli_query($connection, $query);

		$result = mysqli_num_rows($run_query);
		$result_id = mysqli_fetch_array($run_query);
	if ($result <= 0){ //checks if subject already exist


$query = "INSERT INTO subjects (user_id, id, exam_id, subjects, year) 
		VALUES ('$u_id', '$count', '$e_id', '{$passed['subject']}', '{$passed['year']}')";
$run_query = mysqli_query($connection, $query); //adds subjects into subject list
confirm_query ($run_query);


$query = "INSERT INTO exam_year (id, user_id, subject_id, year) 
		VALUES ('$count_year', '$u_id', '$count', '{$passed['year']}')";
$run_query = mysqli_query($connection, $query); //adds year into year list
confirm_query ($run_query);
}else{
$s_id = mysql_prep($result_id['id']); //assigns existing subject's id as subject id
		//runs only year query

$query = "INSERT INTO exam_year (id, user_id, subject_id, year) 
		VALUES ('$count_year', '$u_id', '$s_id', '{$passed['year']}')";
		$run_query = mysqli_query($connection, $query); //adds year into year list
		confirm_query ($run_query);

}

}



for ($i=0; $i < $passed['noq']; $i++) {

$query = "INSERT INTO questions (id, year_id, question, answer, option_1, option_2, option_3, option_4) 
		VALUES (NULL,'$count_year' , '{$quest[$i][0]}', '{$quest[$i][1]}', '{$quest[$i][2]}', '{$quest[$i][3]}', '{$quest[$i][4]}', '{$quest[$i][5]}')";

$run_query = mysqli_query($connection, $query);

confirm_query ($run_query);
}
}
}else{
	header("Location: create_test.php");
}


?>

<p><a href="create_test.php">cancel creation</a></p>
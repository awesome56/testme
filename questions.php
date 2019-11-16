<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_testme.php");?>
<?php include("includes/header.php"); ?>

<?php
	if (!isset($_SESSION['st_year'])){
		header('Location:start_test.php');
	}
?>
<?php 

increment_value( $_SESSION['id'], "user", "attempted");//increment no of started test
//increment no of unfinished test



$query = "SELECT * 
				FROM subjects
				WHERE id = {$_SESSION['act_subj_id']}
				LIMIT 1
				";

	$run_query = mysqli_query($connection, $query);
	
	confirm_query ($run_query);
	$sn = 0;
	while ($subject = mysqli_fetch_array($run_query)) {
		$subject_d[$sn] = array(
                        'subject' 	=> $subject['subjects']
                    ); 
	}

	$_SESSION['act_subj'] = $subject_d[0]['subject'];

$subj = $_SESSION['st_year'];

echo "<h4>CATEGORY: {$_SESSION['st_exam_name']}</h4>";
echo "<h4>COURSE: {$_SESSION['act_subj']}</h4>";
echo "<h4>YEAR: {$_SESSION['act_year']}</h4>";

?>

<div class="body">
	<form action="result.php" method="POST">
<?php
// perform database query
$query_question = "SELECT * 
				  FROM questions 
				  WHERE year_id = {$subj}";

$run_query_question = mysqli_query($connection, $query_question);

confirm_query($run_query_question);
$no = 0;
while ($quest = mysqli_fetch_array($run_query_question)) {
	$b[$no]= array(
					array($quest['question'], $quest['id']) ,
					array(
						'answer' => $quest['answer'],
						'option_1' => $quest['option_1'],
						'option_2' => $quest['option_2'],
						'option_3' => $quest['option_3'],
						'option_4' => $quest['option_4']
			) 
		);
$no++;
}

$lb = array("a", "b", "c", "d", "e"); //option tag array



for ($i=0; $i < sizeof($b) ; $i++) { //loop to display question and answers
echo "<p>";
$s_n = $i + 1;

	

echo $s_n . ". " ; //display number of question

	echo $b[$i][0][0] . "<br>"; //display question
	
	$rando = shuffle_assoc($b[$i][1]); //function to shuffle option
	$lb_c = 0;
	foreach ($rando as $key) { //display options
		
		echo $lb[$lb_c];
		 ?>
		 <input type="radio" name="<?php echo $b[$i][0][1]; ?>" value="<?php echo $key; ?>"><?php echo " ".$key; ?><br>

		 <?php
		$lb_c += 1;
	}
	
	echo "</p><br>";
}

?>


<P><input type="submit" name="submit" value="submit question"></P>
	</form>
	</div>
<?php
$_SESSION['_b'] = $s_n;
$_SESSION['__b'] = $b;


require("includes/footer.php");
?>
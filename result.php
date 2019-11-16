<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_testme.php");?>
<?php include("includes/header.php"); ?>


<br/>
<?php $b = $_SESSION['__b']; 
?>

<?php
if (isset($_POST['submit'])) {

increment_value( $_SESSION['id'], "user", "submitted");//increment no of submitted tests
//increment no of unfinished tests

$right = 0;
$unaws = 0;

for ($i=0; $i < $_SESSION['_b']; $i++) { 

	if (isset($_POST[$b[$i][0][1]])) {
		
	

	$opt[$i]= $_POST[$b[$i][0][1]];
	if ($opt[$i] == $b[$i][1]['answer']) {

		$right += 1;
	}
}elseif (!isset($_POST[$b[$i][0][1]])) {
	$unaws += 1;
}
}

echo "<p><b>You got " . $right . " of " . $_SESSION['_b'] . " questions right</b></p>";
echo "<br/>";
if ($unaws >= 1) {

echo "<p><b>You left " . $unaws . " questions unanswered</b></p>";
}	
}

?>

<?php require("includes/footer.php"); ?>
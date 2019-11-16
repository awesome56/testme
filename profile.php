<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/db_testme.php");?>
<?php include("includes/header.php"); ?>


<div class="body">

<!-- <?php 
//include('db_testme.php');
?> -->
		
<?php
	
$query = "SELECT * FROM user WHERE id={$_SESSION['id']} ";

		$run_query = mysqli_query($connection, $query);

		$result = mysqli_num_rows($run_query);
		$data =  mysqli_fetch_array($run_query);

		$unfinished = $data['attempted'] - $data['submitted'];
?>

<a href="">edit profile</a>
<hr>
<p>Amount of times test taken: <?php echo $data['attempted']; ?></p><br>

Average scores<br>

Performance in each test Exam<br>

View individual scores/test<br>

<p>Finished and unfinished test: <?php echo $data['submitted'] . ", " . $unfinished; ?></p><br>

<p><a href="log_out.php">log out</a></p>




	</div>
<?php
require("includes/footer.php");
?>
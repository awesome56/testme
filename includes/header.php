<?php 
require("includes/login_test.php");?>

<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">

	<title>profle</title>
</head>
<body>
	<header>
		<?php
		if (($_SESSION['role'] == "admin") && ($_SESSION['name'] == "Awe Oluwaseun")) {
			echo "<h3>Hello Boss! You are the best</h3>";
		}elseif (($_SESSION['role'] == "admin") && ($_SESSION['name'] == "Ogunwande Boluwatife"))  {
			echo "<h3>Hello Boluwatife!</h3>";
		}else{
		echo "<h3>{$_SESSION['name']}</h3>";
	}
		?>
		<h1>TEST ME</h1>
		<hr>
		<nav>
		<ul id="navmenu">
			<li><a href="profile.php">profile</a></li>
			<li><a href="start_test.php">tests</a></li>
			<li><a href="create_test.php">create test</a></li>
			<?php
			if ($_SESSION['role'] == "admin") {
			echo "<li><a href='default_create_question.php'>create default test</a></li>"	;
			}
			?>
			<li><a href="store.php">store</a></li>
		</ul>
		</nav>
	</header>
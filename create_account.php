<?php require_once("includes/db_testme.php"); ?>
<?php require_once("includes/functions.php");  ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="styles/styles.css">

	<title>student form</title>
</head>
<body>
	<header>
		<h1>TEST ME</h1>
		<nav></nav>
	</header>


	<div class="body">

<?php  
$surnameErr = $firstnameErr = $usernameErr = $emailErr = $passwordErr = "";
$surname = $firstname = $username = $email = $password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (empty($_POST["surname"])) {
		$surnameErr = "surname is required";
	}else{
		$surname = test_input($_POST["surname"]);
	}

	if (empty($_POST["firstname"])) {
		$firstnameErr = "firstname is required";
	}else{
		$firstname = test_input($_POST["firstname"]);
	}

	if (empty($_POST["email"])) {
		$emailErr = "email is required";
	}elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
		$emailErr = "email must be valid";
	}
	else {
		$email = test_input($_POST["email"]);
		
	}

	if (empty($_POST["password"])) {
		$passwordErr = "password is required";
	}else{
		$password = test_input($_POST["password"]);
	}
}


?>




		<form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?> ">
		<fieldset>

			<legend>New student form</legend>
			<label><p>Surname:<br /> <input type="text" name="surname" value="<?php echo $surname; ?>"> <span class= "error"> * <?php echo $surnameErr; ?></span></p></label>
			<label><p>First name:<br /> <input type="text" name="firstname" value="<?php echo $firstname; ?>"> <span class= "error"> * <?php echo $firstnameErr; ?></span></p></label>
			<label><p>Email:<br /> <input type="email" name="email" value="<?php echo $email; ?>"> <span class= "error"> * <?php echo $emailErr; ?></span></p></label>
			<label><p>Password <br /> <input type="password" name="password" value="<?php echo $password; ?>"> <span class= "error"> * <?php echo $passwordErr; ?></span></p></label>
			<p></p><input type="submit" name="submit" value="create account"> <br /></fieldset>
			<p>already have an account <a href="index.php">(sign in)</a></p>
		</fieldset>  


</form>


<?php 

if (isset($_POST['submit'])) {
	
	

  //       $surname                        = mysql_prep($_POST['surname']); 
		// $firstname                      = mysql_prep($_POST['firstname']);
		// $user_name                      = mysql_prep($_POST['username']);
		// $email                          = mysql_prep($_POST['email']);
		// $pass                           = mysql_prep($_POST['password']);
		// $v_password                     = mysql_prep($_POST['v_password']);
		// $role                           = 'client';


// 	$client = array(
// 		"surname" => $_POST['surname'], 
// 		"firstname" => $_POST['firstname'],
// 		"user_name"  => $_POST['username'],
// 		"email"      => $_POST['email'],
// 		"pass"      => $_POST['password'],
// 		"v_password"  => $_POST['v_password'],
// 		"role"       => "client"
// );

	$client = array(
		mysql_prep($_POST['surname']), 
		mysql_prep($_POST['firstname']),
		mysql_prep($_POST['email']),
		sha1($_POST['password']),
"client");
	
$query = "SELECT * FROM user WHERE email='$client[2]' ";
	

		$run_query = mysqli_query($connection, $query);

		$result = mysqli_num_rows($run_query);

		$data =  mysqli_fetch_array($run_query);
		
		if ($result > 0) {

			if (isset($data['email'])) {
			
			$emailAlr = "{$client[2]} already exist";
			$client[2] = "";
		}
		
		}

switch (in_array("",$client,true)) {
	case 'true':
	if (isset($emailAlr)){
	echo $emailAlr;
}
		break;
	
	default:
		$query = "INSERT INTO user (id, surname, firstname, email, password, role) VALUES (NULL,'{$client[0]}','{$client[1]}','{$client[2]}','{$client[3]}','{$client[4]}')";

$run_query = mysqli_query($connection, $query);

if ($run_query) {

	echo "Congratulations! your profile have been created. Here are your details" . '<br>'; 

	echo 'Name: ' .$client[0] . ' ' . $client[1] . '<br>';

	echo  'Email: '. $client[2] . '<br>';

	echo 'Password: ' . mysql_prep($_POST['password']) . '<br>';

	
	

	?>
	<hr>
	 <p><a href="index.php">start testing</a></p>

	<?php
}



		break;
	}
}

?>


	</div>
<?php
require("includes/footer.php");
?>
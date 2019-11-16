<?php 
session_start();
if (isset($_SESSION['name'])) {
	
	header('Location:profile.php');
}
?>

<?php
require_once("includes/db_testme.php");//connect to database
?>

<!DOCTYPE html>
<html>
<head>

	<title>my tutorial</title>
</head>
<body>
	<header>
		<h1>TEST ME</h1>
		<nav></nav>
	</header>


	<div class="body">
		<form method="POST" action="">
		<fieldset>

			<legend>Login</legend>
			<label><p>Email:<br /> <input type="text" name="username"> </p></label>
			<label><p>Password <br /> <input type="Password" name="password"> </p></label>
			<p></p><input type="submit" name="submit" value="login"> <br /></fieldset>
			<p><a href="forgot_pass.php">forgot password</a></p>
			<p>or <a href="create_account.php">create account</a></p>
		</fieldset> 

		<?php




	if ( isset($_POST["submit"])) {

		$user_name        = $_POST['username'];

		$pass     = $_POST['password'];

		$password = sha1($pass);
		

		$query = "SELECT * FROM user WHERE email = '$user_name' and password='$password' ";
	

		$run_query = mysqli_query($connection, $query);

		$result = mysqli_num_rows($run_query);
		$data =  mysqli_fetch_array($run_query);

	 	if ($result > 0) {
	 		$_SESSION['name'] = $data['surname']." " . $data['firstname'];
	 		$_SESSION['id'] = $data['id'];
	 		$_SESSION['role'] = $data['role'];
	 		header("Location:profile.php");

	 	}else{
	 	echo 'invalid username or password';}
	 	
	 }

?>
</form>

	</div>
<?php
require("includes/footer.php");
?>
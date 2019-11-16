<?php 

$server       =     'localhost';

$username     =     'root';

$password     =      '';

$database     =      'testme';



$connection  =  mysqli_connect($server, $username, $password, $database);

if ($connection) {

	
}
else{

echo "Cannot connect to the database";

die("Database selection failed: " . mysqli_error());

}

?>
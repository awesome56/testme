<?php function test_input ($data){
	$data = trim($data);
	
	$data = htmlspecialchars($data);

	return $data;
	} ?>

<?php function redirect_to( $location = "index.php"){
	if ($location != NULL){
		header("location: {$location}");
		exit; 
	}
	} ?>

<?php function mysql_prep( $value ){
	global $connection;
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists("mysqli_real_escape_string"); // i.e PHP >= v4.3.0

	if( $new_enough_php ) {//PHP v4.3.0 or higher
		// undo any magic quoteeffects so mysql_real_escape_string can do the work
		if( $magic_quotes_active ) { $value = stripslashes( $value );}
		$value = mysqli_real_escape_string( $connection, $value );
	} else { // before PHP v4.3.0
		// if magic quotes aren't already on then add slashes manually
		if( !$magic_quotes_active ) { $value = addslashes( $value ); }
		// if magic quotes are active, then the slashes already exist
	}
	return $value;} ?>

<?php function confirm_query($result_set) {
	global $connection;
	if (!$result_set){
	die("Database query failed: ". mysqli_error($connection)); }} ?>

<?php function shuffle_assoc($list){
	if (!is_array($list)) return $list;

	$keys = array_keys($list);
	shuffle($keys);
	$random = array();
	foreach ($keys as $key) $random[$key] = $list[$key];

	return $random;} ?>

<?php function add_id($type){
	global $connection;
	$query = "SELECT * FROM $type";

	$run_query = mysqli_query($connection, $query);

	confirm_query ($run_query);

	$count;
	while ($fetch = mysqli_fetch_array($run_query)){

	$count = $fetch['id'];
	}
	$count++;

	return $count;
	}

	?>

<?php function increment_value( $id, $table, $data) {
		global $connection;
		$query = "SELECT * FROM $table WHERE id=$id ";

		$run_query = mysqli_query($connection, $query);

		confirm_query ($run_query);

		$value =  mysqli_fetch_array($run_query);

		$increment = $value[$data] + 1;

		$query = "UPDATE $table SET $data = '{$increment}' WHERE id = $id ";

		$run_query = mysqli_query($connection, $query);

		confirm_query ($run_query);

	}
	?>

<?php function get_all_examtype($user_id){
	global $connection;
	$query_etype = "SELECT * 
				FROM exam_type
				WHERE user_id = {$user_id}" ;

	$run_query_etype = mysqli_query($connection, $query_etype);
	
	confirm_query ($run_query_etype);
	return $run_query_etype; }

function get_subjects($test_type_id){
	global $connection;
	$query_subject = "SELECT * 
				  FROM subjects 
				  WHERE exam_id = {$test_type_id}"; 

	$run_query_subject = mysqli_query($connection, $query_subject);
	confirm_query($run_query_subject);
	return $run_query_subject; }

function get_c_subjects($user_id){
	global $connection;
	$query_subject = "SELECT * 
				  FROM subjects 
				  WHERE exam_id = 6 AND
				  user_id = $user_id";

	$run_query_subject = mysqli_query($connection, $query_subject);
	confirm_query($run_query_subject);
	return $run_query_subject; }

function get_year($subject_id) {
	global $connection;
	$query_year = "SELECT * 
			   FROM exam_year 
			   WHERE subject_id = {$subject_id}";

	$run_query_year = mysqli_query($connection, $query_year);
	confirm_query($run_query_year);
	return $run_query_year;
	}
	?>
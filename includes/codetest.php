<?php

$test = "awe_seun";

$hashed_pass = password_hash($test, PASSWORD_DEFAULT);

echo $hashed_pass;

echo "<br/>";

echo strlen($hashed_pass);

echo "<br/>";

echo sha1($test);
 
echo "<br/>";

echo strlen(sha1($test));

?>
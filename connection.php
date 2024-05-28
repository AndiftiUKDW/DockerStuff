<?php
$hostname = getenv('db_host');
$username = getenv('db_user');
$password = getenv('db_pass');
$db = getenv('db_name');
$base_url = getenv('base_url');
$conn = mysqli_connect($hostname,$username,$password,$db);
?>
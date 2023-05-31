<?php
date_default_timezone_set("Asia/Kuala_Lumpur");

// config
$host = "127.0.0.1";
$port = "3306";
$socket = "";
$user = "root";
$password = "";

$dbname = "fwdd";

$conn = mysqli_connect($host, $user, $password, $dbname, $port, $socket)
    or die('Failed to connect to database: ' . mysqli_connect_error());
?>
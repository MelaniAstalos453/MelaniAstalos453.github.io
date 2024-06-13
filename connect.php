<?php
header('Content-Type: text/html; charset=utf-8');
$servername = "localhost";
$username = "root";
$password = "";
$basename = "vijesti_db";

$dbc = mysqli_connect($servername, $username, $password, $basename) or die('Error connecting to MySQL server.' . mysqli_error($dbc));
mysqli_set_charset($dbc, "utf8");

?>
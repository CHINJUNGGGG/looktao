<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'project';

$conn =  new mysqli($hostname, $username, $password, $database);
if ($conn->connect_error){
	die("Connection Failed : ".$conn->connect_error);
}
$conn->set_charset("utf8");
error_reporting(E_ALL ^ E_NOTICE);
?>
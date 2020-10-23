<?php
$dsn = 'mysql:host=localhost;dbname=project';
$username = 'root';
$password = '';
$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8');
try {
    $db = new PDO($dsn, $username, $password, $options);
// echo 'ติดต่อฐานข้อมูลสำเร็จ';
} catch (Exception $e) {
// echo 'เชื่อมต่อไม่ได้'.$e->getMessage();
}
error_reporting(E_ALL ^ E_NOTICE);
?>
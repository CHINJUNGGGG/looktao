<?php
session_start();
unset($_SESSION["mem_id"]);
header("Location:index.php");
?>
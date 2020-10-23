<?php
session_start();
include('../path/connect.php');
include('../path/connectpdo.php');
date_default_timezone_set("Asia/Bangkok");
$date = date("Ymd");
$numrand = (mt_rand());

if(isset($_POST["do"]) && $_POST["do"] != "" ){
	$do = $_POST["do"];
	switch($do){

        case 'view_member':
            
                $id = $_POST['id'];
                // print_r($_POST);
                // die();
                $sql = "SELECT * FROM member WHERE mem_id = :id";
                $stmt=$db->prepare($sql);
                $stmt->bindparam(':id',$id);
                $stmt->execute();
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($row);

        break;
    }
}

?>
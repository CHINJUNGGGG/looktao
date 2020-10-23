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

        case 'view_invoice':
            
                $id = $_POST['id'];
                // print_r($_POST);
                // die();
                $sql = "SELECT * FROM invoice WHERE id = :id";
                $stmt=$db->prepare($sql);
                $stmt->bindparam(':id',$id);
                $stmt->execute();
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($row);

        break;

        case 'update':
            
            $id = $_POST['id'];
            $tracking_number = $_POST['tracking_number'];

            $sql_update = "UPDATE invoice SET 
            tracking_number = '".$tracking_number."'
            WHERE id = '".$id."'";
            // echo($sql_update);
            // die();
            $result_update = mysqli_query($conn, $sql_update) or die(mysqli_error());  

            echo "Success";

        break;
    }
}

?>
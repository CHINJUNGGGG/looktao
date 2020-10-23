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

        case 'type_add':
        
            $type_name = $_POST['type_name']; 


            
                $sql = "INSERT INTO `type`(`type_name`) 
                VALUES ('$type_name')";
                            //    echo($sql);
                            //    die();
                $result= mysqli_query($conn, $sql) or die(mysqli_error());                           
                    
                echo "Success";
            
        break;

        case 'view_type':
            
            
                $id = $_POST['id'];
                // print_r($_POST);
                // die();
                $sql = "SELECT * FROM type WHERE type_id = :id";
                $stmt=$db->prepare($sql);
                $stmt->bindparam(':id',$id);
                $stmt->execute();
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($row);

        break;

        case 'edit_type':
            
            
            $type_name = $_POST['type_name']; 
            $type_id = $_POST['type_id']; 

            $sql_update = "UPDATE type SET 
            type_name = '".$type_name."'
            WHERE type_id = '".$type_id."'";
            // echo($sql_update);
            // die();
            $result_update = mysqli_query($conn, $sql_update) or die(mysqli_error());   
            
            echo "Success";
            
        break;
  
    }
}

?>
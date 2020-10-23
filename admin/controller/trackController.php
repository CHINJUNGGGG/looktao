<?php 
session_start();
include('../path/connect.php');
include('../path/connectpdo.php'); 


if(isset($_POST["do"]) && $_POST["do"] != "" ){
	$do = $_POST["do"];
	switch($do){
              
        case 'track':

            $tracking = $_POST['tracking'];
            $price = $_POST['price'];

    
            $sql = "INSERT INTO `shipping`(`shipping_name`, `price`) 
                    VALUES ('$tracking', '$price')";
            $result = mysqli_query($conn, $sql) or die(mysqli_error());
            
            echo "Success";


        break;

        case 'view':
            
            
            $id = $_POST['id'];
            // print_r($_POST);
            // die();
            $sql = "SELECT * FROM shipping WHERE shipping_id = :id";
            $stmt=$db->prepare($sql);
            $stmt->bindparam(':id',$id);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);

    break;

    case 'edit':
        
        
        $shipping_name = $_POST['shipping_name'];
        $price = $_POST['price'];
        $shipping_id = $_POST['shipping_id'];

        $sql_update = "UPDATE shipping SET 
        shipping_name = '".$shipping_name."', price = '".$price."'
        WHERE shipping_id = '".$shipping_id."'";
        // echo($sql_update);
        // die();
        $result_update = mysqli_query($conn, $sql_update) or die(mysqli_error());   
        
        echo "Success";

    break;
    }
}
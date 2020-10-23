<?php 
session_start();
include('../public/connect.php');
include('../public/connectpdo.php'); 

$mem_id = $_SESSION['mem_id'];

if(isset($_POST["do"]) && $_POST["do"] != "" ){
	$do = $_POST["do"];
	switch($do){
              
        case 'update':

            $mem_firstname = $_POST['mem_firstname'];
            $mem_lastname = $_POST['mem_lastname'];
            $mem_email = $_POST['mem_email'];
            $mem_tel = $_POST['mem_tel'];
            $mem_address = $_POST['mem_address'];

  
    
            $sql = "UPDATE member SET mem_firstname = '".$mem_firstname."', mem_lastname = '".$mem_lastname."'
            , mem_tel = '".$mem_tel."', mem_address = '".$mem_address."' WHERE mem_id = '".$mem_id."'";
            $result = mysqli_query($conn, $sql) or die(mysqli_error());

            unset($_SESSION["mem_id"]);
            
            echo "Success";
            
     

        break;
    }
}
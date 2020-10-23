<?php 
session_start();
include('../path/connect.php');
include('../path/connectpdo.php'); 


if(isset($_POST["do"]) && $_POST["do"] != "" ){
	$do = $_POST["do"];
	switch($do){
              
        case 'user':

            $mem_firstname = $_POST['mem_firstname'];
            $mem_lastname = $_POST['mem_lastname'];
            $mem_password = $_POST['mem_password'];
            $mem_email = $_POST['mem_email'];
            $password_hash = password_hash($mem_password, PASSWORD_BCRYPT);

            $sql_check = "SELECT mem_email FROM member WHERE mem_email = '".$mem_email."'";
            $result_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
            $num=mysqli_num_rows($result_check);

            if($num > 0){
                echo "Error";
            }else{    
    
            $sql = "INSERT INTO `member`(`mem_firstname`, `mem_lastname`, `mem_password`, `mem_email`, `mem_level`) 
                    VALUES ('$mem_firstname', '$mem_lastname', '$password_hash', '$mem_email', '1')";
            $result = mysqli_query($conn, $sql) or die(mysqli_error());
            
            echo "Success";

            }

        break;
    }
}
<?php 
session_start();
include('../public/connectpdo.php'); 


if(isset($_POST["do"]) && $_POST["do"] != "" ){
	$do = $_POST["do"];
	switch($do){

        case 'login':

            $mem_email = $_POST['mem_email'];
            $mem_password = $_POST['mem_password'];
           
                if(isset($_POST['mem_email']) && $_POST['mem_email'] != '' && isset($_POST['mem_password']) && $_POST['mem_password'] != '') {
                    $mem_email = trim($_POST['mem_email']);
                    $mem_password = trim($_POST['mem_password']);

                    $query = "SELECT * FROM member WHERE `mem_email` = ? LIMIT 0,1";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(1, $mem_email);
                    $stmt->execute();
                    $num=$stmt->rowCount();
                    // echo($num);
                    // die();
                    if($num > 0) {
                        // echo($num);
                        // die();
                        $row=$stmt->fetch(PDO::FETCH_ASSOC);
                        $_SESSION['mem_id'] = $row['mem_id'];
                        $_SESSION['mem_firstname'] = $row['mem_firstname'];
                        $_SESSION['mem_lastname'] = $row['mem_lastname'];
                        $_SESSION['mem_email'] = $row['mem_email'];
                        $_SESSION['mem_tel'] = $row['mem_tel'];
                        $_SESSION['mem_address'] = $row['mem_address'];
                        $hash = $row['mem_password'];
                      
                        if(password_verify($mem_password,$hash)){
                            echo "Success";
                        }else{
                            echo "Error";
                        }
                    }else{
                        echo "Error";
                    }
                }   

        break;

    }
}
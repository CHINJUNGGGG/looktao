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

        case 'add':
        
            $pro_name = $_POST['pro_name']; 
            $pro_price = $_POST['pro_price']; 
            $pro_quantity = $_POST['pro_quantity']; 
            $pro_type = $_POST['pro_type']; 
            $pro_detail = $_POST['pro_detail']; 

            $path="../img/";  
            $check = $_FILES['pro_img']['type']; 
            if(($check!="image/jpg") and ($check!="image/jpeg") and ($check!="image/pjpeg") and ($check!="image/png") and ($check!="image/gif")){
                echo "Error";
            }else{		
                $path="../img/";  
                $type = strrchr($_FILES['pro_img']['name'],".");
                $newname = 'img_'.$date.$numrand.$type;
                $path_copy=$path.$newname;
                $path_link="../img/".$newname;
                move_uploaded_file($_FILES['pro_img']['tmp_name'],$path_copy);
            
                $sql = "INSERT INTO `product`(`pro_name`, `pro_price`, `pro_quantity`, `pro_type`, `pro_detail`, `pro_img`) 
                VALUES ('$pro_name', '$pro_price', '$pro_quantity', '$pro_type', '$pro_detail', '$newname')";
                            //    echo($sql);
                            //    die();
                $result= mysqli_query($conn, $sql) or die(mysqli_error());                           
                    
                echo "Success";  
            }
                
        break;

        case 'view_product':
            
            
                $id = $_POST['id'];
                // print_r($_POST);
                // die();
                $sql = "SELECT * FROM product WHERE pro_id = :id";
                $stmt=$db->prepare($sql);
                $stmt->bindparam(':id',$id);
                $stmt->execute();
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($row);

        break;

        case 'amount_product':
            
            $id = $_POST['id'];
            $sql = "SELECT pro_quantity,pro_id FROM product WHERE pro_id = :id";
            $stmt=$db->prepare($sql);
            $stmt->bindparam(':id',$id);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($row);

        break;

        case 'delete':
            
            $id = $_POST['id'];


            $sql_update = "DELETE FROM `product` WHERE id = '".$id."'";
            // echo($sql_update);
            // die();
            $result_update = mysqli_query($conn, $sql_update) or die(mysqli_error());
            
            echo "Success";
            

        break;

        case 'amount':
            
            $pro_id = $_POST['pro_id'];
            $pro_quantity = $_POST['pro_quantity'];

            $sql_update = "UPDATE product SET pro_quantity = '".$pro_quantity."' WHERE pro_id = '".$pro_id."'";
            // echo($sql_update);
            // die();
            $result_update = mysqli_query($conn, $sql_update) or die(mysqli_error());
            
            echo "Success";
            

        break;

        case 'edit_product':
            
            
            $pro_name = $_POST['pro_name']; 
            $pro_price = $_POST['pro_price']; 
            $pro_quantity = $_POST['pro_quantity']; 
            $pro_type = $_POST['pro_type']; 
            $pro_detail = $_POST['pro_detail']; 
            $pro_id = $_POST['pro_id']; 

            $check = $_FILES['pro_img']['type']; 
            if(($check!="image/jpg") and ($check!="image/jpeg") and ($check!="image/pjpeg") and ($check!="image/png") and ($check!="image/gif")){
                echo "Error";
            }else{			
                $path="../img/";  
                $type = strrchr($_FILES['pro_img']['name'],".");
                $newname = 'img_'.$date.$numrand.$type;
                $path_copy=$path.$newname;
                $path_link="../img/".$newname;
                move_uploaded_file($_FILES['pro_img']['tmp_name'],$path_copy);

                $sql_update = "UPDATE product SET 
                pro_name = '".$pro_name."', pro_price = '".$pro_price."', pro_quantity = '".$pro_quantity."', 
                pro_type = '".$pro_type."', pro_detail = '".$pro_detail."', pro_img = '".$newname."'
                WHERE pro_id = '".$pro_id."'";
                // echo($sql_update);
                // die();
                $result_update = mysqli_query($conn, $sql_update) or die(mysqli_error());   
                
                echo "Success";
            }

            

        break;
  
    }
}

?>
<?php 
session_start();
$user_id = $_SESSION['mem_id'];
include('../public/connect.php');
include('../public/connectpdo.php');
date_default_timezone_set("Asia/Bangkok");
$date = date("Ymd");	
$numrand = (mt_rand());

if(isset($_POST["do"]) && $_POST["do"] != "" ){
	$do = $_POST["do"];
	switch($do){
              
        case 'invoice':

            $cart_id = $_POST['cart_id'];
            $price = $_POST['price'];
            // print_r($_POST);
            // die();

            $json = array(
                'cart_id' => $cart_id
            );

            $json = json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

            $number = 'INV'.$date.$numrand;
            
            $sql = "INSERT INTO `invoice`(`invoice`, `list`, `price`, `slip`, `user_id`, `create_at`) 
            VALUES ('$number', '$json', '$price', 'no.png', '$user_id', current_timestamp())";
            // echo($sql);
            // die();
            $result = mysqli_query($conn, $sql) or die(mysqli_error());
                
            echo "Success";    

        break;

        case 'mobile':

            $id = $_POST['id'];
            $shipping_id = $_POST['shipping_id'];
            $mem_address = $_POST['address'];

            //    print_r($_POST);
            // die();

            $path="../admin/slip/";
            $check = $_FILES['slip']['type']; 
            if(($check!="image/jpg") and ($check!="image/jpeg") and ($check!="image/pjpeg") and ($check!="image/png") and ($check!="image/gif")){
                echo "Error";
            }else{	 
                $type = strrchr($_FILES['slip']['name'],".");	
                $newname = 'slip_'.$date.$numrand.$type;
                $path_copy=$path.$newname;
                $path_link="../admin/slip/".$newname;
                move_uploaded_file($_FILES['slip']['tmp_name'],$path_copy);

                $sql_s1 = "SELECT * FROM invoice WHERE id = '".$id."'";
                $stmt1=$db->prepare($sql_s1);
                $stmt1->execute();
                $row1=$stmt1->fetch(PDO::FETCH_ASSOC);
                    $i_price = $row1['price'];

                $sql_s = "SELECT price FROM shipping WHERE shipping_id = '".$shipping_id."'";
                $stmt=$db->prepare($sql_s);
                $stmt->execute();
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                    $s_price = $row['price'];

                $sum = $i_price + $s_price;
                
                // echo($sum);
                // die();

                $sql = "UPDATE invoice SET price = '".$sum."', type = '1', slip = '".$newname."', shipping_id = '".$shipping_id."', address = '".$mem_address."', status = '1', update_at = current_timestamp() WHERE id = '".$id."'";
                // echo($sql);
                // die();
                $result = mysqli_query($conn, $sql) or die(mysqli_error());
                    
                echo "Success";    
            }
        
        break;

        case 'cash':

            $id = $_POST['id'];
            $shipping_id = $_POST['shipping_id'];
            $mem_address = $_POST['mem_address'];

            //    print_r($_POST);
            // die();


            $sql = "UPDATE invoice SET type = '2', shipping_id = '".$shipping_id."', address = '".$mem_address."', status = '1', update_at = current_timestamp() WHERE id = '".$id."'";
            // echo($sql);
            // die();
            $result = mysqli_query($conn, $sql) or die(mysqli_error());
                
            echo "Success";    

        break;

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

    }
}

?>
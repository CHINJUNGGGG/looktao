<?php
session_start();
$user_id = $_SESSION['mem_id'];
include('../public/connectpdo.php');
include('../public/connect.php');
date_default_timezone_set("Asia/Bangkok");
$date = date("Y-m-d");
$numrand = (mt_rand());


if(isset($_POST["do"]) && $_POST["do"] != "" ){
    $do = $_POST["do"];
	switch($do){

        case 'cart':
        
            $product_id = $_POST['product_id'];
            $amount = $_POST['amount'];

            $sql_check = "SELECT pro_quantity,pro_price FROM product WHERE pro_id = '".$product_id."'";
            $result_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
            $row = $result_check->fetch_assoc();
            $pro_quantity = $row['pro_quantity'];
            $pro_price = $row['pro_price'];
            // $stock = $pro_quantity - $amount;
            $sum = $amount * $pro_price;

            if($pro_quantity <= 0){

                echo "Error";

            }else{    
    
                $sql = "INSERT INTO `cart`(`product_id`, `amount`, `price`, `user_id`, `date`) VALUES ('$product_id', '$amount', '$sum', '$user_id', '$date')";
                $result = mysqli_query($conn, $sql) or die(mysqli_error());

                // $sql_update = "UPDATE product SET pro_quantity = '".$stock."' WHERE pro_id = '".$product_id."'";
                // $result = mysqli_query($conn, $sql_update) or die(mysqli_error());

                echo "Success";

            }

        break;
    }
}

?>
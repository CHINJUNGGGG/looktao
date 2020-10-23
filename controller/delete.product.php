<?php

include('../public/connect.php');

$cart_id = $_GET['id'];

// echo($cart_id);
// die();

if($cart_id!=''){

    $sql_check = "SELECT * FROM cart WHERE id = '".$cart_id."'";
    $result_check = mysqli_query($conn, $sql_check) or die(mysqli_error());
    $row = $result_check->fetch_assoc();
    $product_id = $row['product_id'];
    $amount = $row['amount'];

    $sql_check1 = "SELECT * FROM product WHERE pro_id = '".$product_id."'";
    $result_check1 = mysqli_query($conn, $sql_check1) or die(mysqli_error());
    $row1 = $result_check1->fetch_assoc();
    $amount1 = $row1['pro_quantity'];

    $stock = $amount + $amount1;

    $sql_update = "UPDATE product SET pro_quantity = '".$stock."' WHERE pro_id = '".$product_id."'";
    $result = mysqli_query($conn, $sql_update) or die(mysqli_error());

    $sql = "DELETE FROM cart WHERE id ='".$cart_id."'";
    
    if($conn->query($sql)== TRUE){
        echo "<script>";
        echo "window.location.href='../cart.php';";
        echo "</script>";
    }else{
        echo "ERROR".$sql."<BR>".$conn->error;
        
    }
}  


?>
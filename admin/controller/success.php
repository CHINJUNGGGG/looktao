<?php

include('../path/connect.php');

$id = $_GET['id'];

if($id!=''){

    $i = 0;
    $someArray = [];
    $query = "SELECT list FROM invoice WHERE id = '".$id."'";
    $result = $conn->query($query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $user = json_decode($row['list'], true);

    foreach($user['cart_id'] as $key => $cart_id){
        $someArray[$i] = $cart_id;
        $i = $i+1;
    }

    foreach($someArray as $index){
        $sql_success = "UPDATE cart SET status = '1' WHERE id = '".$index."'";
        $result_success = mysqli_query($conn, $sql_success) or die(mysqli_error());
    }   
    
    
    $sql_success1 = "UPDATE invoice SET status = '2', update_at = current_timestamp() WHERE id = '".$id."'";
    $result_success1 = mysqli_query($conn, $sql_success1) or die(mysqli_error());

    
    if($conn->query($sql_success1)== TRUE){
        echo "<script>";
        echo "window.location.href='../invoice.php';";
        echo "</script>";
    }else{
        echo "ERROR".$sql."<BR>".$conn->error;
        
    }
}  


?>
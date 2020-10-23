<?php session_start(); require_once __DIR__.'/path/connectpdo.php'; 
 require_once __DIR__.'/path/connect.php'; 
$invoice = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php require_once __DIR__.'/path/head.php'; ?>
    <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper"><?php require_once __DIR__.'/path/navbar.php'; ?>

        <?php require_once __DIR__.'/path/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="container-fluid">
                <div class="card mt-4">
                    <div class="card-header">

                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                aria-labelledby="custom-tabs-four-home-tab">
                                <table id="example1" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>รูปสินค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>จำนวน</th>
                                            <th>ราคา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $someArray = [];
                                        $i = 0;
                                        $query = "SELECT list FROM invoice WHERE invoice = '".$invoice."'";
                                        $result = $conn->query($query);
                                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            
                                        $user = json_decode($row['list'], true);
                            
                                        foreach($user['cart_id'] as $key => $cart_id){
                                            $someArray[$i] = $cart_id;
                                            $i = $i+1;
                                        }

                                        foreach($someArray as $index){
                                            $sql1 = "SELECT *,SUM(price) as sum FROM cart WHERE id = '".$index."'";
                                            $stmt1 = $db->prepare($sql1);
                                            $stmt1->execute();
                                            while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                                                $id = $row1['id'];
                                                $product_id = $row1['product_id'];
                                                $sum  = $row1['sum'];
                                                $amount  = $row1['amount'];
        
                                            $sql = "SELECT * FROM product WHERE pro_id = '".$product_id."'";
                                            $stmt = $db->prepare($sql);
                                            $stmt->execute();
                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                                $pro_id = $row['pro_id'];
                                                $pro_price  = $row['pro_price'];
                                                $pro_name = $row['pro_name']; 
                                                $pro_img = $row['pro_img']; 
                                        }   
                                    
                                    ?>
                                        <tr>
                                            <td><img src="img/<?=$pro_img?>" style="width: 100px; height: 100px;"></td>
                                            <td><?=$pro_name?></td>                                      
                                            <td><?=$amount?></td>
                                            <td><?=$sum?></td>
        
                                        </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <?php require_once __DIR__.'/path/script.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>

<script>
$(function() {
    $("#example1").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});
$(function() {
    $("#example3").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $('#example4').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});
$(function() {
    $("#example5").DataTable({
        "responsive": true,
        "autoWidth": false,
    });
    $('#example6').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
    });
});
</script>


</html>
<?php session_start(); require_once __DIR__.'/path/connectpdo.php'; ?>
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
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                    href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                    aria-selected="true">รายการสั่งซื้อทั้งหมด</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                                    aria-selected="false">โอนผ่านธนาคาร</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-cash-tab" data-toggle="pill"
                                    href="#custom-tabs-four-cash" role="tab" aria-controls="custom-tabs-four-cash"
                                    aria-selected="false">เก็บเงินปลายทาง</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                aria-labelledby="custom-tabs-four-home-tab">
                                <table id="example1" class="table">
                                    <thead>
                                        <tr>
                                            <th>หมายเลขการสั่งซื้อ</th>
                                            <th>สลิป</th>
                                            <th>ประเภท</th>
                                            <th>ขนส่งที่จัดส่ง</th>
                                            <th>ราคารวมทั้งหมด</th>
                                            <th>หมายเลขพัสดุ</th>
                                            <th>ชื่อผู้รับ</th>
                                            <th>สถานะ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $sql = "SELECT * FROM invoice ORDER BY id DESC";
                                        $stmt=$db->prepare($sql);
                                        $stmt->execute();
                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $invoice = $row['invoice']; 
                                            $id  = $row['id']; 
                                            $type = $row['type']; 
                                            $slip = $row['slip']; 
                                            $price = $row['price']; 
                                            $user_id = $row['user_id'];   
                                            $status = $row['status']; 
                                            $shipping_id = $row['shipping_id']; 
                                            $tracking_number = $row['tracking_number'];   
                                            $i++;   

                                            $price = number_format($price);
                                            
                                        $sql_type = "SELECT * FROM member WHERE mem_id = :user_id";
                                        $stmt_type=$db->prepare($sql_type);
                                        $stmt_type->bindparam(':user_id', $user_id);
                                        $stmt_type->execute();
                                        $row_type=$stmt_type->fetch(PDO::FETCH_ASSOC);
                                            $mem_firstname = $row_type['mem_firstname']; 
                                            $mem_lastname = $row_type['mem_lastname']; 

                                        $sql_type1 = "SELECT * FROM shipping WHERE shipping_id = :shipping_id";
                                        $stmt_type1=$db->prepare($sql_type1);
                                        $stmt_type1->bindparam(':shipping_id', $shipping_id);
                                        $stmt_type1->execute();
                                        $row_type1=$stmt_type1->fetch(PDO::FETCH_ASSOC);
                                                $ship_id = $row_type1['ship_id']; 
                                                $shipping_name = $row_type1['shipping_name'];     
                                    ?>
                                        <tr>
                                            <td><?=$invoice?></td>
                                            <td><a href="#" id="pop"><img src="slip/<?=$slip?>" id="imageresource" style="width:100px; height:100px;"></a></td>
                                            <td><?php if($type == '1'){ echo '<font style="color: Green">โอนเงิน</font>';}else{echo '<font style="color: Green">เก็บเงินปลายทาง</font>';}?>
                                            </td>
                                            <td><?=$shipping_name?></td>
                                            <td><?=$price?> ฿</td>
                                            <td>
                                                <?php if($tracking_number == NULL){ ?>
                                                <button type='button' class='btn btn-sm btn-secondary mb-4'
                                                    data-toggle='modal'
                                                    data-target='#tracking_number' data-id="<?=$id?>">เพิ่มหมายเลขพัสดุ</button>
                                                <?php }else{ ?>
                                                <?=$tracking_number?>
                                                <?php } ?>
                                            </td>
                                            <td><?=$mem_firstname?> <?=$mem_lastname?></td>
                                            <td><?php if($status == '0' || $status == '1'){ echo '<font style="color: orange">รอการอนุมัติ</font>';}else{echo '<font style="color: Green">อนุมัติ</font>';}?>
                                            </td>
                                            <td> 
                                            <?php if($status == 0 || $status == '1'){ ?>
                                                 <a href="controller/success.php?id=<?=$id?>" onclick="return confirm('คุณต้องการอนุมัติรายการนี้ ใช่หรือไม่ ?')" class="btn btn-sm btn-success mb-4"><i class="fas fa-check"></i></a>
                                                 <a href="inv.detail.php?id=<?=$invoice?>" class="btn btn-sm btn-info mb-4">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php }else{ ?> 
                                                <a href="inv.detail.php?id=<?=$invoice?>" class="btn btn-sm btn-info mb-4">
                                                    <i class="fas fa-edit"></i>
                                                </a> 
                                            <?php } ?>      
                                            </td>
                                        </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                aria-labelledby="custom-tabs-four-profile-tab">
                                <table id="example3" class="table">
                                    <thead>
                                        <tr>
                                            <th>หมายเลขการสั่งซื้อ</th>
                                            <th>สลิป</th>
                                            <th>ประเภท</th>
                                            <th>ขนส่งที่จัดส่ง</th>
                                            <th>ราคารวมทั้งหมด</th>
                                            <th>หมายเลขพัสดุ</th>
                                            <th>ชื่อผู้รับ</th>
                                            <th>สถานะ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $sql = "SELECT * FROM invoice WHERE type = '1' ORDER BY id DESC";
                                        $stmt=$db->prepare($sql);
                                        $stmt->execute();
                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $invoice = $row['invoice']; 
                                            $id  = $row['id']; 
                                            $type = $row['type']; 
                                            $slip = $row['slip']; 
                                            $price = $row['price']; 
                                            $user_id = $row['user_id'];   
                                            $status = $row['status']; 
                                            $shipping_id = $row['shipping_id']; 
                                            $tracking_number = $row['tracking_number'];   
                                            $i++;   
                                            
                                        $sql_type = "SELECT * FROM member WHERE mem_id = :user_id";
                                        $stmt_type=$db->prepare($sql_type);
                                        $stmt_type->bindparam(':user_id', $user_id);
                                        $stmt_type->execute();
                                        $row_type=$stmt_type->fetch(PDO::FETCH_ASSOC);
                                            $mem_firstname = $row_type['mem_firstname']; 
                                            $mem_lastname = $row_type['mem_lastname']; 
                                            $sql_type1 = "SELECT * FROM shipping WHERE shipping_id = :shipping_id";
                                            $stmt_type1=$db->prepare($sql_type1);
                                            $stmt_type1->bindparam(':shipping_id', $shipping_id);
                                            $stmt_type1->execute();
                                            $row_type1=$stmt_type1->fetch(PDO::FETCH_ASSOC);
                                                    $ship_id = $row_type1['ship_id']; 
                                                    $shipping_name = $row_type1['shipping_name']; 
                                    ?>
                                        <tr>
                                            <td><?=$invoice?></td>
                                            <td><img src="slip/<?=$slip?>" style="width:100px; height:100px;"></td>
                                            <td><?php if($type == '1'){ echo '<font style="color: Green">โอนเงิน</font>';}else{echo '<font style="color: Green">เก็บเงินปลายทาง</font>';}?>
                                            </td>
                                            <td><?=$shipping_name?></td>
                                            <td><?=$price?></td>
                                            <td>
                                                <?php if($tracking_number == NULL){ ?>
                                                <button type='button' class='btn btn-sm btn-secondary mb-4'
                                                    data-toggle='modal'
                                                    data-target='#tracking_number' data-id="<?=$id?>">เพิ่มหมายเลขพัสดุ</button>
                                                <?php }else{ ?>
                                                <?=$tracking_number?>
                                                <?php } ?>
                                            </td>
                                            <td><?=$mem_firstname?> <?=$mem_lastname?></td>
                                            <td><?php if($status == '0'){ echo '<font style="color: orange">รอการอนุมัติ</font>';}else{echo '<font style="color: Green">อนุมัติ</font>';}?>
                                            </td>
                                            <td> 
                                            <?php if($status == 0){ ?>
                                                 <a href="controller/success.php?id=<?=$id?>" onclick="return confirm('คุณต้องการอนุมัติรายการนี้ ใช่หรือไม่ ?')" class="btn btn-sm btn-success mb-4"><i class="fas fa-check"></i></a>
                                                 <a href="inv.detail.php?id=<?=$invoice?>" class="btn btn-sm btn-info mb-4">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php }else{ ?> 
                                                <a href="inv.detail.php?id=<?=$invoice?>" class="btn btn-sm btn-info mb-4">
                                                    <i class="fas fa-edit"></i>
                                                </a> 
                                            <?php } ?>   
                                            </td>
                                        </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-cash" role="tabpanel"
                                aria-labelledby="custom-tabs-four-cash-tab">
                                    <table id="example5" class="table">
                                    <thead>
                                        <tr>
                                            <th>หมายเลขการสั่งซื้อ</th>
                                            <th>ประเภท</th>
                                            <th>ขนส่งที่จัดส่ง</th>
                                            <th>ราคารวมทั้งหมด</th>
                                            <th>หมายเลขพัสดุ</th>
                                            <th>ชื่อผู้รับ</th>
                                            <th>สถานะ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $sql = "SELECT * FROM invoice WHERE type = '2' ORDER BY id DESC";
                                        $stmt=$db->prepare($sql);
                                        $stmt->execute();
                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $invoice = $row['invoice']; 
                                            $id  = $row['id']; 
                                            $type = $row['type']; 
                                            $price = $row['price']; 
                                            $user_id = $row['user_id'];   
                                            $status = $row['status']; 
                                            $tracking_number = $row['tracking_number'];   
                                            $i++;   
                                            
                                        $sql_type = "SELECT * FROM member WHERE mem_id = :user_id";
                                        $stmt_type=$db->prepare($sql_type);
                                        $stmt_type->bindparam(':user_id', $user_id);
                                        $stmt_type->execute();
                                        $row_type=$stmt_type->fetch(PDO::FETCH_ASSOC);
                                            $mem_firstname = $row_type['mem_firstname']; 
                                            $mem_lastname = $row_type['mem_lastname']; 

                                            $sql_type1 = "SELECT * FROM shipping WHERE shipping_id = :shipping_id";
                                            $stmt_type1=$db->prepare($sql_type1);
                                            $stmt_type1->bindparam(':shipping_id', $shipping_id);
                                            $stmt_type1->execute();
                                            $row_type1=$stmt_type1->fetch(PDO::FETCH_ASSOC);
                                                    $ship_id = $row_type1['ship_id']; 
                                                    $shipping_name = $row_type1['shipping_name'];     
                                    ?>
                                        <tr>
                                            <td><?=$invoice?></td>
                                            <td><?php if($type == '1'){ echo '<font style="color: Green">โอนเงิน</font>';}else{echo '<font style="color: Green">เก็บเงินปลายทาง</font>';}?>
                                            </td>
                                            <td><?=$shipping_name?></td>
                                            <td><?=$price?></td>
                                            <td>
                                                <?php if($tracking_number == NULL){ ?>
                                                <button type='button' class='btn btn-sm btn-secondary mb-4'
                                                    data-toggle='modal'
                                                    data-target='#tracking_number' data-id="<?=$id?>">เพิ่มหมายเลขพัสดุ</button>
                                                <?php }else{ ?>
                                                <?=$tracking_number?>
                                                <?php } ?>
                                            </td>
                                            <td><?=$mem_firstname?> <?=$mem_lastname?></td>
                                            <td><?php if($status == '0'){ echo '<font style="color: orange">รอการอนุมัติ</font>';}else{echo '<font style="color: Green">อนุมัติ</font>';}?>
                                            </td>
                                            <td> 
                                            <?php if($status == 0){ ?>
                                                 <a href="controller/success.php?id=<?=$id?>" onclick="return confirm('คุณต้องการอนุมัติรายการนี้ ใช่หรือไม่ ?')" class="btn btn-sm btn-success mb-4"><i class="fas fa-check"></i></a>
                                                 <a href="inv.detail.php?id=<?=$invoice?>" class="btn btn-sm btn-info mb-4">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            <?php }else{ ?> 
                                                <a href="inv.detail.php?id=<?=$invoice?>" class="btn btn-sm btn-info mb-4">
                                                    <i class="fas fa-edit"></i>
                                                </a> 
                                            <?php } ?>   
                                            </td>
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

    <div class="modal fade" id="tracking_number" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="tracking" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Tracking_number</label>
                                <input type="text" class="form-control" id="tracking_number" name="tracking_number"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="do" value="update">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
      </div>
      <div class="modal-body">
      <img src="" id="imagepreview"  style="width: 100%; height: 600px;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    $(document).ready(function() {
        $('#tracking_number').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)

            $.ajax({
                type: "POST",
                url: "controller/invController.php",
                data: {
                    id: id,
                    do: 'view_invoice'
                },
                dataType: "json",
                success: function(response) {
                    console.log(response)

                    var arr_input_key = ['id'
                    ]

                    $.each(response, function(indexInArray, valueOfElement) {
                        if (jQuery.inArray(indexInArray, arr_input_key) !== -1) {
                            if (valueOfElement != '') {
                                modal.find('input[name="' + indexInArray + '"]')
                                    .val(valueOfElement)
                            }
                        }

                        if (jQuery.inArray(indexInArray) !== -1) {
                            if (valueOfElement != '') {
                                modal.find('input[name="' + indexInArray + '"]')
                                    .attr('old-' + indexInArray, valueOfElement)
                            }
                        }
                    });

                    modal.find('#id').val(id)
                }
            });
        })
    });
    </script>

<script>
    $("#pop").on("click", function() {
   $('#imagepreview').attr('src', $('#imageresource').attr('src')); // here asign the image to the modal when the user click the enlarge link
   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
});
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


<script>
$(document).ready(function(e) {
    $("#tracking").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "controller/invController.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response)
                if (response == "Error") {
                    swal("", {
                        icon: "warning",
                    });
                }
                if (response == "Success") {
                    swal("", {
                        icon: "success",
                    });
                    setTimeout(function() {
                        window.location.href = "invoice.php";
                    }, 1500);
                }
            },
            error: function() {}
        });
    }));
});
</script>

</html>
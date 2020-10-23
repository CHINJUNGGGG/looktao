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
                                    aria-selected="true">ข้อมูลสินค้าทั้งหมด</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                    href="#custom-tabs-four-profile" role="tab" aria-controls="custom-tabs-four-profile"
                                    aria-selected="false">ประเภทสินค้า</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                aria-labelledby="custom-tabs-four-home-tab">
                                <button type="button" class="btn btn-primary mb-4" data-toggle="modal"
                                    data-target="#exampleModal">เพิ่มข้อมูลสินค้า</button>
                                <table id="example1" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ประเภท</th>
                                            <th>รูปสินค้า</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>ราคา</th>
                                            <th>คงเหลือ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $sql = "SELECT * FROM product";
                                        $stmt=$db->prepare($sql);
                                        $stmt->execute();
                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $id = $row['pro_id']; 
                                            $pro_name = $row['pro_name']; 
                                            $pro_price = $row['pro_price']; 
                                            $pro_quantity = $row['pro_quantity']; 
                                            $pro_type = $row['pro_type'];   
                                            $pro_img = $row['pro_img'];   
                                            $i++;   
                                            
                                        $sql_type = "SELECT type_name FROM type WHERE type_id = :pro_type";
                                        $stmt_type=$db->prepare($sql_type);
                                        $stmt_type->bindparam(':pro_type', $pro_type);
                                        $stmt_type->execute();
                                        $row_type=$stmt_type->fetch(PDO::FETCH_ASSOC);
                                            $type_name = $row_type['type_name']; 
                                    ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td><?=$type_name?></td>
                                            <td><img src="img/<?=$pro_img?>" style="width: 100px; height: 100px;"></td>
                                            <td><?=$pro_name?></td>
                                            <td><?=$pro_price?></td>
                                            <td><?=$pro_quantity?></td>
                                            <td> <button type="button" class="btn btn-sm btn-info mb-4"
                                                    data-toggle="modal" data-target="#view_product"
                                                    data-id="<?=$id?>"><i class="fas fa-edit"></i></button>
                                                <button type="button" class="btn btn-sm btn-warning mb-4"
                                                    data-toggle="modal" data-target="#amount_product"
                                                    data-id="<?=$id?>"><i class="fas fa-plus"></i></button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                aria-labelledby="custom-tabs-four-profile-tab">
                                <button type="button" class="btn btn-primary mb-4" data-toggle="modal"
                                    data-target="#exampleModal1">เพิ่มประเภทสินค้า</button>
                                <table id="example3" class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>ประเภท</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;
                                        $sql_type = "SELECT * FROM type";
                                        $stmt_type=$db->prepare($sql_type);
                                        $stmt_type->execute();
                                        while($row_type=$stmt_type->fetch(PDO::FETCH_ASSOC)){
                                            $type_name = $row_type['type_name']; 
                                            $id = $row_type['type_id']; 
                                            $type_img = $row_type['type_img']; 
                                            $i++;
                                    ?>
                                        <tr>
                                            <td><?=$i?></td>
                                            <td><?=$type_name?></td>
                                            <td> <button type="button" class="btn btn-sm btn-info mb-4"
                                                    data-toggle="modal" data-target="#view_type" data-id="<?=$id?>"><i
                                                        class="fas fa-edit"></i></button></td>
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

    <div class="modal fade" id="amount_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="amount_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlInput1">จำนวนสินค้าใหม่</label>
                                <input type="number" class="form-control" id="exampleFormControlInput1"
                                    name="pro_quantity" id="pro_quantity" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn"
                            style="color: #fff !important; background-color: #e7ab3c !important;">บันทึก</button>
                        <input type="hidden" name="do" value="amount">
                        <input type="hidden" name="pro_id" id="pro_id">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_product" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">ชื่อสินค้า*</label>
                                <input type="text" class="form-control" id="pro_name" name="pro_name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">ราคา*</label>
                                <input type="text" class="form-control" id="pro_price" name="pro_price" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">จำนวน*</label>
                                <input type="number" class="form-control" id="pro_quantity" name="pro_quantity"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">ประเภทสินค้า*</label>
                                <select id="type" class="form-control" name="pro_type" required>
                                    <option>เลือก..</option>
                                    <?php
                                        $sql = "SELECT * FROM type";
                                        $stmt=$db->prepare($sql);
                                        $stmt->execute();
                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $type_id = $row['type_id'];
                                            $type_name = $row['type_name'];
                                            echo '<option value='.$type_id.'>'.$type_name.'</option>';
                                        }    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">รายละเอียด</label>
                                <textarea class="form-control" name="pro_detail" col="8" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">รูปภาพ</label>
                                <input type="file" class="form-control" id="pro_img" name="pro_img"
                                    onchange="readURL1(this);">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <img class="output3" src="#">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <input type="hidden" name="do" value="add">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view_product" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_product" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-12">
                                <img id="output1" name="edit" src="#" style="width: 470px; height: 300px;">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">ชื่อสินค้า*</label>
                                <input type="text" class="form-control" id="pro_name" name="pro_name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">ราคา*</label>
                                <input type="text" class="form-control" id="pro_price" name="pro_price" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">จำนวน*</label>
                                <input type="number" class="form-control" id="pro_quantity" name="pro_quantity"
                                    required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">ประเภทสินค้า*</label>
                                <select id="type" class="form-control" name="pro_type" required>
                                    <option>เลือก..</option>
                                    <?php
                                        $sql = "SELECT * FROM type";
                                        $stmt=$db->prepare($sql);
                                        $stmt->execute();
                                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                            $type_id = $row['type_id'];
                                            $type_name = $row['type_name'];
                                            echo '<option value='.$type_id.'>'.$type_name.'</option>';
                                        }    
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">รายละเอียด</label>
                                <textarea class="form-control" name="pro_detail" col="8" rows="10"></textarea>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">รูปภาพ</label>
                                <input type="file" class="form-control" id="pro_img" name="pro_img"
                                    onchange="readURL(this);">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <img id="output2" src="#" style="width: 470px; height: 300px;">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <input type="hidden" name="do" value="edit_product">
                        <input type="hidden" name="pro_id" id="pro_id">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_type" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">ประเภท*</label>
                                <input type="text" class="form-control" id="type_name" name="type_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <input type="hidden" name="do" value="type_add">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view_type" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_type" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">ประเภทสินค้า*</label>
                                <input type="text" class="form-control" id="type_name" name="type_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-primary">บันทึก</button>
                        <input type="hidden" name="do" value="edit_type">
                        <input type="hidden" name="type_id" id="type_id">
                    </div>
                </form>
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
    $('#view_type').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)

        $.ajax({
            type: "POST",
            url: "controller/typeController.php",
            data: {
                id: id,
                do: 'view_type'
            },
            dataType: "json",
            success: function(response) {
                console.log(response)

                var arr_input_key = ['type_name', 'type_id']

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

$(document).ready(function() {
    $('#amount_product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)

        $.ajax({
            type: "POST",
            url: "controller/productController.php",
            data: {
                id: id,
                do: 'amount_product'
            },
            dataType: "json",
            success: function(response) {
                console.log(response)
                var arr_input_key = ['pro_id', 'pro_quantity']

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
$(document).ready(function() {
    $('#view_product').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)

        $.ajax({
            type: "POST",
            url: "controller/productController.php",
            data: {
                id: id,
                do: 'view_product'
            },
            dataType: "json",
            success: function(response) {
                console.log(response)

                var arr_input_key = ['pro_name', 'pro_price', 'pro_detail', 'pro_quantity',
                    'pro_id'
                ]
                var arr_select_key = ['pro_type']

                $.each(response, function(indexInArray, valueOfElement) {
                    if (jQuery.inArray(indexInArray, arr_input_key) !== -1) {
                        if (valueOfElement != '') {
                            modal.find('input[name="' + indexInArray + '"]')
                                .val(valueOfElement)
                        }
                    }
                    if (jQuery.inArray(indexInArray, arr_input_key) !== -1) {
                        if (valueOfElement != '') {
                            modal.find('textarea[name="' + indexInArray + '"]')
                                .val(valueOfElement)
                        }
                    }
                    if (jQuery.inArray(indexInArray, arr_select_key) !== -1) {
                        if (valueOfElement != '') {
                            if (indexInArray == 'pro_type') {
                                modal.find('select[name="pro_type"]').val(
                                    valueOfElement)
                            } else {
                                modal.find('select[name="' + indexInArray + '"]')
                                    .val(valueOfElement)
                            }
                        }
                    }
                    if (jQuery.inArray(indexInArray) !== -1) {
                        if (valueOfElement != '') {
                            modal.find('input[name="' + indexInArray + '"]')
                                .attr('old-' + indexInArray, valueOfElement)
                        }
                    }
                    if (indexInArray === 'pro_img') {
                        modal.find('img[name="edit"]').attr('src', 'img/' +
                            valueOfElement)
                    }
                });

                modal.find('#id').val(id)
            }
        });
    })
});
</script>

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
</script>


<script>
$(document).ready(function(e) {
    $("#add_product").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "controller/productController.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response)
                if (response == "Error") {
                    swal("โปรดอัพโหลดเฉพาะไฟล์รูปภาพเท่านั้น", {
                        icon: "warning",
                    });
                }
                if (response == "Success") {
                    swal("", {
                        icon: "success",
                    });
                    setTimeout(function() {
                        window.location.href = "product.php";
                    }, 1500);
                }
            },
            error: function() {}
        });
    }));
});

$(document).ready(function(e) {
    $("#add_type").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "controller/typeController.php",
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
                        window.location.href = "product.php";
                    }, 1500);
                }
            },
            error: function() {}
        });
    }));
});
$(document).ready(function(e) {
    $("#edit_type").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "controller/typeController.php",
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
                        window.location.href = "product.php";
                    }, 1500);
                }
            },
            error: function() {}
        });
    }));
});
$(document).ready(function(e) {
    $("#amount_form").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "controller/productController.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response)
                if (response == "Error") {
                    swal("Please complete all information.", {
                        icon: "warning",
                    });
                }
                if (response == "Success") {
                    swal("Add amount product successfully.", {
                        icon: "success",
                    });
                    setTimeout(function() {
                        window.location.href = "product.php";
                    }, 2000);
                }
            },
            error: function() {}
        });
    }));
});

$(document).ready(function(e) {
    $("#edit_product").on('submit', (function(e) {
        e.preventDefault();
        $.ajax({
            url: "controller/productController.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response)
                if (response == "Error") {
                    swal("โปรดอัพโหลดเฉพาะไฟล์รูปภาพเท่านั้น", {
                        icon: "warning",
                    });
                }
                if (response == "Success") {
                    swal("", {
                        icon: "success",
                    });
                    setTimeout(function() {
                        window.location.href = "product.php";
                    }, 1500);
                }
            },
            error: function() {}
        });
    }));
});
</script>
<script>
function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.output3')
                .attr('src', e.target.result)
                .width(470)
                .height(300);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.output4')
                .attr('src', e.target.result)
                .width(470)
                .height(300);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function readURL3(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('.output5')
                .attr('src', e.target.result)
                .width(470)
                .height(300);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#output2')
                .attr('src', e.target.result)
                .width(470)
                .height(300);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

</html>
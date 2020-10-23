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
                        <h3 class="card-title">ข้อมูลพนักงาน</h3>
                    </div>
                    <div class="card-body">
                    <button type="button" class="btn btn-primary mb-4" data-toggle="modal"
                                    data-target="#exampleModal">เพิ่มข้อมูล</button>
                        <table id="example1" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>อีเมล</th>
                                    <th><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                    $sql = "SELECT * FROM member WHERE mem_level = 1";
                                    $stmt=$db->prepare($sql);
                                    $stmt->execute();
                                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                        $id  = $row['mem_id']; 
                                        $mem_firstname = $row['mem_firstname']; 
                                        $mem_lastname = $row['mem_lastname']; 
                                        $mem_email = $row['mem_email']; 
                                        $i++;   
                                ?>        
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$mem_firstname?> <?=$mem_lastname?></td>
                                    <td><?=$mem_email?></td>
                                    <td><button type="button" class="btn btn-sm btn-info mb-4" data-toggle="modal"
                                            data-target="#view_member" data-id="<?=$id?>"><i class="fas fa-search-plus"></i></button></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
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
                <form id="user" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mem_firstname">ชื่อ</label>
                                <input type="text" class="form-control" id="mem_firstname" name="mem_firstname">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mem_lastname">นามสกุล</label>
                                <input type="text" class="form-control" id="mem_lastname" name="mem_lastname">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mem_email">อีเมล</label>
                                <input type="email" class="form-control" id="mem_email" name="mem_email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mem_tel">รหัสผ่าน</label>
                                <input type="password" class="form-control" id="mem_password" name="mem_password">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <button type="sunmit" class="btn btn-primary">เพิ่ม</button>
                        <input type="hidden" name="do" value="user">
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


    <script>
    $(document).ready(function() {
        $('#view_member').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var modal = $(this)

            $.ajax({
                type: "POST",
                url: "controller/memberController.php",
                data: {
                    id: id,
                    do: 'view_member'
                },
                dataType: "json",
                success: function(response) {
                    console.log(response)

                    var arr_input_key = ['mem_firstname', 'mem_lastname', 'mem_email',
                        'mem_tel', 'mem_address'
                    ]

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

    $(document).ready(function(e) {
        $("#user").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: "controller/userController.php",
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
                            window.location.href = "user.php";
                        }, 1500);
                    }
                },
                error: function() {}
            });
        }));
    });

    </script>
</body>
</html>
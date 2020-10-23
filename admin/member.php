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
                        <h3 class="card-title">ข้อมูลสมาชิกทั้งหมด</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>เบอร์โทรศัพท์</th>
                                    <th>อีเมล</th>
                                    <th>ที่อยู่</th>
                                    <th><i class="fas fa-cogs"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $i = 0;
                                    $sql = "SELECT * FROM member WHERE mem_level = 0";
                                    $stmt=$db->prepare($sql);
                                    $stmt->execute();
                                    while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                        $id  = $row['mem_id']; 
                                        $mem_firstname = $row['mem_firstname']; 
                                        $mem_lastname = $row['mem_lastname']; 
                                        $mem_email = $row['mem_email']; 
                                        $mem_address = $row['mem_address'];   
                                        $mem_tel = $row['mem_tel'];   
                                        $i++;   
                                ?>        
                                <tr>
                                    <td><?=$i?></td>
                                    <td><?=$mem_firstname?> <?=$mem_lastname?></td>
                                    <td><?=$mem_tel?></td>
                                    <td><?=$mem_email?></td>
                                    <td><?=$mem_address?></td>
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

    <div class="modal fade" id="view_member" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <div class="form-group col-md-6">
                                <label for="mem_firstname">ชื่อ</label>
                                <input type="text" class="form-control" id="mem_firstname" name="mem_firstname" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mem_lastname">นามสกุล</label>
                                <input type="text" class="form-control" id="mem_lastname" name="mem_lastname" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="mem_email">อีเมล</label>
                                <input type="text" class="form-control" id="mem_email" name="mem_email" disabled>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mem_tel">เบอร์โทรศัพท์</label>
                                <input type="text" class="form-control" id="mem_tel" name="mem_tel" disabled>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="mem_address">ที่อยู่</label>
                                <textarea class="form-control" name="mem_address" cols="8" rows="6" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                        <input type="hidden" name="mem_id" id="mem_id">
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
    </script>
</body>
</html>
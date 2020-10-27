<?php
session_start();
include('public/connectpdo.php');
$user_id = $_SESSION['mem_id'];
// echo($user_id);
// die();
$sql2 = "SELECT mem_address FROM member WHERE mem_id = :user_id ";
$stmt2 = $db->prepare($sql2);
$stmt2->bindparam(':user_id', $user_id);
$stmt2->execute();
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$address = $row2['mem_address'];

?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <?php require_once __DIR__ . '/resource/head.php'; ?>
</head>
<style>
    .form-control:disabled,
    .form-control[readonly] {
        background-color: #fff;
        opacity: 1;
    }
</style>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <?php require_once __DIR__ . '/resource/navbar.php'; ?>

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text product-more">
                        <a href="index.php"><i class="fa fa-home"></i> Home</a>
                        <a href="shop.php?id=1">Shop</a>
                        <span>Buyer</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <div class="container-fluid px-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cart-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Invoice</th>
                                    <th style="width:100px !important;">Price(Total)</th>
                                    <th>Datetime</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="mt-4">
                                <?php

                                $sql3 = "SELECT * FROM invoice WHERE user_id = :user_id AND status = 0 ORDER BY id ASC";
                                $stmt3 = $db->prepare($sql3);
                                $stmt3->bindparam(':user_id', $user_id);
                                $stmt3->execute();
                                while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                                    $id = $row3['id'];
                                    $invoice = $row3['invoice'];
                                    $user_id = $row3['user_id'];
                                    $price = $row3['price'];
                                    $status = $row3['status'];
                                    $tracking_number = $row3['tracking_number'];
                                    $slip = $row3['slip'];
                                    $create_at = $row3['create_at'];

                                    // $price = number_format($price);


                                ?>
                                    <tr class="p-4">
                                        <td class="align-self-center"><?= $invoice ?></td>
                                        <td>฿ <?= $price ?></td>
                                        <td><?= $create_at ?></td>
                                        <td>
                                            <?php
                                            if ($status == 0) {
                                                echo '<h6 style="color: orange"><b>Waiting Slip</b></h6>';
                                            } else if ($status == 1) {
                                                echo '<h6 style="color: orange"><b>Waiting Approve</b></h6>';
                                            } else if ($status == 3) {
                                                echo '<h6 style="color: red"><b>Slip was wrong</b></h6>';
                                            } else {
                                                echo '<h6 style="color: green"><b>Success</b></h6>';
                                            }
                                            ?>
                                        </td>

                                        <td>
                                            <?php
                                            if ($status == 0) {
                                                echo '<button type="button" id="pay" style="background-color: #838383 !important; width:185px; border-color: #838383 !important;" class="site-btn" data-toggle="modal" data-target="#slipModal" data-id="' . $id . '">Upload Slip</button>
                                                    <a href="list.php?id=' . $id . '"><button type="button" style="background-color: #000; border-color: #000 !important; width:185px;" class="site-btn">Detail</button></a>';
                                            } else if ($status == 1) {
                                                echo ' <a href="list.php?id=' . $id . '"><button type="button" style="background-color: #000; border-color: #000 !important; width:185px;" class="site-btn">Detail</button></a>';
                                            } else if ($status == 3) {
                                                echo '<button type="button" id="pay" class="site-btn" data-toggle="modal" style="background-color: #838383 !important; width:185px; border-color: #838383 !important;" data-target="#slipModal" data-id="' . $id . '">Upload Slip</button>
                                                    <a href="list.blade.php?id=' . $id . '"><button type="button" style="background-color: #000; width:185px; border-color: #000 !important;" class="site-btn">Detail</button></a>';
                                            } else {
                                                echo ' <a href="list.php?id=' . $id . '"><button type="button" style="background-color: #000; width:185px; border-color: #000 !important;" class="site-btn">Detail</button></a>';
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="slipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLongTitle" style="color: red;">**ราคารวมค่าจัดส่งเรียบร้อยแล้ว</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <form id="mobile" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="shipping_id">Transport*</label>
                            <select class="form-control readers" name="shipping_id" id="shipping_id">
                                <?php
                                $sql5 = "SELECT * FROM shipping";
                                $stmt5 = $db->prepare($sql5);
                                $stmt5->execute();
                                while ($row5 = $stmt5->fetch(PDO::FETCH_ASSOC)) {
                                    $shipping_id = $row5['shipping_id'];
                                    $shipping_name = $row5['shipping_name'];
                                    $price5 = $row5['price'];
                                ?>
                                    <option value="<?=$shipping_id?>">
                                        <?= $shipping_name ?> <?= $price5 ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            ฿ <input type="text" name="price" id="price" style="border: none;" readonly> 
                        </div>
                        <div class="form-group">
                            <label for="address">Address<font style="color: red">*</font></label>
                            <textarea class="form-control" name="address" id="address" rows="5" cols="5"><?= $address ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="slip" class="btn btn-primary col-12">Choose Silp</label>
                            <input type="file" class="form-control" name="slip" id="slip" onchange="readURL(this);" style="visibility:hidden;">
                        </div>
                        <div class="form-group">
                            <img src="#" id="output">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" name="submit" id="submit" class="btn btn-primary">Upload</button>
                            <input type="hidden" name="do" value="mobile">
                            <input type="hidden" name="id" id="id">
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
                        <img src="" id="imagepreview" style="width: 100%; height: 600px;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>




        <?php require_once __DIR__ . '/resource/script.php'; ?>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
        <script>
            var basePrice = +($('#price').html()).replace(/[^0-9\.]+/g, "");
            $(".readers").change(function() {
                newPrice = basePrice;
                $(".readers option:selected").each(function() {
                    newPrice += +$(this).attr('data-price')
                });
                $("#price").html("฿" + newPrice.toFixed(2));
            });
        </script>
        <script type="text/javascript">
            $("#pop").on("click", function() {
                $('#imagepreview').attr('src', $('#imageresource').attr('src')); // here asign the image to the modal when the user click the enlarge link
                $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
            });
            $(document).ready(function() {
                $("#pay").click(function() {
                    $("#second").hide();
                    $("#first").hide();
                });

                $("#exampleRadios1").click(function() {
                    $("#second").show();
                    $("#first").hide();
                });

                $("#exampleRadios2").click(function() {
                    $("#second").hide();
                    $("#first").show();
                });
            });
            $("#slip").change(function() {
                filename = this.slip[0].name
                console.log(filename);
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function(e) {
                $("#register_form").on('submit', (function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "controller/registerController.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            console.log(response)
                            if (response == "Error") {
                                swal("Your Email has already been registered for an account with the website.", {
                                    icon: "warning",
                                });
                            }
                            if (response == "Success") {
                                swal("Registered successfully. Please update personal profile.", {
                                    icon: "success",
                                });
                                setTimeout(function() {
                                    window.location.href = "profile.php";
                                }, 3000);
                            }
                        },
                        error: function() {}
                    });
                }));
            });

            $(document).ready(function(e) {
                $("#login_form").on('submit', (function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "controller/loginController.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            console.log(response)
                            if (response == "Error") {
                                swal("Your email or password is wrong.", {
                                    icon: "warning",
                                });
                            }
                            if (response == "Success") {
                                swal("Login successfully.", {
                                    icon: "success",
                                });
                                setTimeout(function() {
                                    window.location.href = "index.php";
                                }, 3000);
                            }
                        },
                        error: function() {}
                    });
                }));
            });
        </script>
        <script>
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#output')
                            .attr('src', e.target.result)
                            .width(470)
                            .height(500);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#slipModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget)
                    var id = button.data('id')
                    var modal = $(this)

                    $.ajax({
                        type: "POST",
                        url: "controller/invoiceController.php",
                        data: {
                            id: id,
                            do: 'view_invoice'
                        },
                        dataType: "json",
                        success: function(response) {
                            console.log(response)

                            var arr_input_key = ['id', 'price']

                            $.each(response, function(indexInArray, valueOfElement) {
                                if (jQuery.inArray(indexInArray, arr_input_key) !== -
                                    1) {
                                    if (valueOfElement != '') {
                                        modal.find('input[name="' + indexInArray + '"]')
                                            .val(valueOfElement)
                                    }
                                }
                                if (jQuery.inArray(indexInArray, arr_input_key) !== -
                                    1) {
                                    if (valueOfElement != '') {
                                        modal.find('textarea[name="' + indexInArray +
                                                '"]')
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
        <script type="text/javascript">
            $(document).ready(function(e) {
                $("#mobile").on('submit', (function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "controller/invoiceController.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            console.log(response)
                            if (response == "Error") {
                                swal("Please upload jpg,png,gif,jpeg.", {
                                    icon: "warning",
                                });
                            }
                            if (response == "Success") {
                                swal("Upload successfully.", {
                                    icon: "success",
                                });
                                setTimeout(function() {
                                    window.location.href = "his.php";
                                }, 2000);
                            }
                        },
                        error: function() {}
                    });
                }));
            });

            $(document).ready(function(e) {
                $("#cash").on('submit', (function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "controller/invoiceController.php",
                        type: "POST",
                        data: new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(response) {
                            console.log(response)
                            if (response == "Error") {
                                swal("Product not is amount.", {
                                    icon: "warning",
                                });
                            }
                            if (response == "Success") {
                                swal("Upload successfully.", {
                                    icon: "success",
                                });
                                setTimeout(function() {
                                    window.location.href = "his.php";
                                }, 2000);
                            }
                        },
                        error: function() {}
                    });
                }));
            });
        </script>
</body>

</html>
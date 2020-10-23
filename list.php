<?php
session_start();
include('public/connectpdo.php');
include('public/connect.php');
$user_id = $_SESSION['mem_id'];
$invoice = $_GET['id'];

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
                        <a href="history.php">History</a>
                        <span>Detail</span>
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
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php
                                    $someArray = [];
                                    $i = 0;
                                    $query = "SELECT list FROM invoice WHERE id = '".$invoice."'";
                                    $result = $conn->query($query);
                                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        
                                    $user = json_decode($row['list'], true);
                        
                                    foreach($user['cart_id'] as $key => $cart_id){
                                        $someArray[$i] = $cart_id;
                                        $i = $i+1;
                                    }

                                    foreach($someArray as $index){
                                        $sql6 = "SELECT * FROM cart WHERE user_id = '".$user_id."' AND id = '".$index."'";
                                        $stmt6 = $db->prepare($sql6);
                                        $stmt6->execute();
                                        while ($row6 = $stmt6->fetch(PDO::FETCH_ASSOC)) {
                                            $id4 = $row6['id'];
                                            $product_id4 = $row6['product_id'];
                                            $price4  = $row6['price'];
                                            $amount4  = $row6['amount'];
    
                                        $sql5 = "SELECT * FROM product WHERE pro_id = '".$product_id4."'";
                                        $stmt5 = $db->prepare($sql5);
                                        $stmt5->execute();
                                        $row5 = $stmt5->fetch(PDO::FETCH_ASSOC);
                                            $pro_id5 = $row5['pro_id'];
                                            $pro_price5  = $row5['pro_price'];
                                            $pro_name5 = $row5['pro_name']; 
                                            $pro_img5 = $row5['pro_img']; 
                                    }   
                                  
                                ?>
                                    <td class="cart-pic first-row">
                                        <img src="admin/img/<?=$pro_img5?>" alt="" style="width: 150px; height: 150px;">
                                        <div class="cart__product__item__title">
                                            <h6 style="margin-top: 42px !important;"><?=$pro_name5?></h6>
                                        </div>
                                    </td>
                                    <td class="cart-pic first-row">฿ <?=$pro_price5?></td>
                                    <td class="qua-col first-row">
                                    <div class="quantity">
                                                <div class="pro-qty">
                                                    <input type="text" value="<?=$amount4?>" style="border: none !important;" disabled>
                                                </div>
                                            </div>
                                    </td>
                                    <td class="cart-pic first-row">฿ <?=$price4?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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


    <div class="modal fade" id="slipModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="exampleModalLongTitle" style="color: red;">**ราคายังไม่รวมค่าจัดส่ง
                        ให้ลูกค้าเอายอดทั้งหมด + กับราคาขนส่งพร้อมแนบสลิป</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                            value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Cash on Delivery
                        </label>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                            value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                            Mobile-Banking
                        </label>
                    </div>
                    <div id="first">
                        <form id="mobile" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="shipping_id">Transport*</label>
                                <select class="form-control" name="shipping_id">
                                    <option>Choose</option>
                                    <?php
                                                                    $sql5 = "SELECT * FROM shipping";
                                                                    $stmt5=$db->prepare($sql5);
                                                                    $stmt5->execute();
                                                                    while($row5=$stmt5->fetch(PDO::FETCH_ASSOC)){
                                                                        $shipping_id = $row5['shipping_id'];
                                                                        $shipping_name = $row5['shipping_name'];
                                                                        $price5 = $row5['price'];
                                                                ?>
                                    <option value="<?=$shipping_id?>">
                                        <?=$shipping_name?> <?=$price5?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Address<font style="color: red">*</font></label>
                                <textarea class="form-control" name="address" id="address" rows="5"
                                    cols="5"><?=$address?></textarea>
                            </div>
                            <div class="form-group">
                                <label for="slip" class="btn btn-primary col-12">Choose Silp</label>
                                <input type="file" class="form-control" name="slip" id="slip" onchange="readURL(this);"
                                    style="visibility:hidden;">
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
                    <div id="second">
                        <form id="cash" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="shipping_id">Transport*</label>
                                <select class="form-control" name="shipping_id">
                                    <option>Choose</option>
                                    <?php
                                                                    $sql5 = "SELECT * FROM shipping";
                                                                    $stmt5=$db->prepare($sql5);
                                                                    $stmt5->execute();
                                                                    while($row5=$stmt5->fetch(PDO::FETCH_ASSOC)){
                                                                        $shipping_id = $row5['shipping_id'];
                                                                        $shipping_name = $row5['shipping_name'];
                                                                        $price5 = $row5['price'];
                                                                ?>
                                    <option value="<?=$shipping_id?>">
                                        <?=$shipping_name?> <?=$price5?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">Address<font style="color: red">*</font></label>
                                <textarea class="form-control" name="address" id="address" rows="5"
                                    cols="5"><?=$address?></textarea>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Upload</button>
                                <input type="hidden" name="do" value="cash">
                                <input type="hidden" name="id" id="id">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>





        <?php require_once __DIR__ . '/resource/script.php'; ?>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
            integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
        </script>
        <script type="text/javascript">
        $("#pop").on("click", function() {
            $('#imagepreview').attr('src', $('#imageresource').attr(
            'src')); // here asign the image to the modal when the user click the enlarge link
            $('#imagemodal').modal(
            'show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
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

                        var arr_input_key = ['id']

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
                                window.location.href = "history.php";
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
                                window.location.href = "history.php";
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
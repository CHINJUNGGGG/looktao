<?php
session_start();
include('public/connectpdo.php');
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <?php require_once __DIR__ . '/resource/head.php'; ?>
</head>
<style>
  .form-control:disabled, .form-control[readonly] {
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
                    <div class="breadcrumb-text">
                        <a href="index.php"><i class="fa fa-home"></i> Home</a>
                        <span>Shop</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="product-shop spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-8 order-2 order-lg-1 produts-sidebar-filter">
                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <ul class="filter-catagories">
                            <?php
                        
                            $sql = "SELECT * FROM type";
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                $t_id = $row['type_id'];
                                $name = $row['type_name'];

                            ?>
                            <li><a href="shop.php?id=<?=$t_id?>"><?=$name?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 order-1 order-lg-2">
                    <div class="product-list">
                        <div class="row">
                        <?php
                        
                        $sql1 = "SELECT * FROM product";
                        $stmt1 = $db->prepare($sql1);
                        $stmt1->bindparam(':test', $test);
                        $stmt1->execute();
                        while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                            $pro_id = $row1['pro_id'];
                            $pro_name = $row1['pro_name'];
                            $pro_quantity = $row1['pro_quantity'];
                            $pro_price = $row1['pro_price'];
                            $pro_img = $row1['pro_img'];

                        ?>
                            <div class="col-lg-4 col-sm-6">
                                <div class="product-item">
                                    <div class="pi-pic">
                                        <img src="admin/img/<?=$pro_img?>" alt="">
                                        <div class="sale pp-sale">Sale</div>
                                        <ul>
                                            <li class="quick-view"><a href="product_detail.php?id=<?=$pro_id?>">+ View</a></li>
                                        </ul>
                                    </div>
                                    <div class="pi-text">
                                        <a href="product_detail.php?id=<?=$pro_id?>">
                                            <h5><?=$pro_name?></h5>
                                        </a>
                                        <div class="product-price">
                                            ฿<?=$pro_price?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <?php require_once __DIR__ . '/resource/script.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
                                window.location.href = "profile.blade.php";
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
                                window.location.href = "index.blade.php";
                            }, 3000);
                        }
                    },
                    error: function() {}
                });
            }));
        });

            $(document).ready(function() {
                $('#exampleModalCenter').on('show.bs.modal', function(event) {
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
                            var arr_input_key = ['id', 'price', 'amount']

                            $.each(response, function(indexInArray, valueOfElement) {
                                if (jQuery.inArray(indexInArray, arr_input_key) !== -1) {
                                    if (valueOfElement != '') {
                                        modal.find('input[name="' + indexInArray + '"]')
                                            .val(valueOfElement)
                                    }
                                }
                                if (jQuery.inArray(indexInArray, arr_input_key) !== -1) {
                                    if (valueOfElement != '') {
                                        modal.find('input[max="' + indexInArray + '"]')
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
</body>

</html>
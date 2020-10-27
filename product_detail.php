<?php
session_start();
include('public/connectpdo.php');
$test = $_GET['id'];
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

    <section class="product-shop spad page-details">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="filter-widget">
                        <h4 class="fw-title">Categories</h4>
                        <ul class="filter-catagories">
                            <?php
                            $sql = "SELECT * FROM type";
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $t_id = $row['type_id'];
                                $name = $row['type_name'];

                            ?>
                                <li><a href="shop.php?id=<?= $t_id ?>"><?= $name ?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-6">
                            <?php

                            $sql1 = "SELECT * FROM product WHERE pro_id = :test";
                            $stmt1 = $db->prepare($sql1);
                            $stmt1->bindparam(':test', $test);
                            $stmt1->execute();
                            $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                $pro_id = $row1['pro_id'];
                                $pro_name = $row1['pro_name'];
                                $pro_quantity = $row1['pro_quantity'];
                                $pro_price = $row1['pro_price'];
                                $pro_img = $row1['pro_img'];
                                $pro_detail = $row1['pro_detail'];

                            ?>
                            <div class="product-pic-zoom">
                                <img class="product-big-img" src="admin/img/<?= $pro_img ?>" alt="">
                                <div class="zoom-icon">
                                    <i class="fa fa-search-plus"></i>
                                </div>
                            </div>
                            <!-- <div class="product-thumbs">
                                <div class="product-thumbs-track ps-slider owl-carousel">
                                    <div class="pt active" data-imgbigurl="img/product-single/product-1.jpg"><img src="img/product-single/product-1.jpg" alt=""></div>
                                    <div class="pt" data-imgbigurl="img/product-single/product-2.jpg"><img src="img/product-single/product-2.jpg" alt=""></div>
                                    <div class="pt" data-imgbigurl="img/product-single/product-3.jpg"><img src="img/product-single/product-3.jpg" alt=""></div>
                                    <div class="pt" data-imgbigurl="img/product-single/product-3.jpg"><img src="img/product-single/product-3.jpg" alt=""></div>
                                </div>
                            </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="product-details">
                                <div class="pd-title">
                                    <h3><?= $pro_name ?></h3>
                                    <a href="#" class="heart-icon"><i class="icon_heart_alt"></i></a>
                                </div>
                                <div class="pd-desc">
                                    <h4>฿<?= $pro_price ?></h4>
                                </div>
                                <div class="pd-desc">
                                    <h4 style="color: #000 !important; font-size: 14px !important;"><?= $pro_detail ?></h4>
                                </div>
                                <form id="cart" method="POST" enctype="multipart/form-data">
                                    <div class="quantity" style="margin-top: 190px;">
                                        <div class="pro-qty d-flex justify-content-center">
                                            <input type="number" name="amount" value="1" max="<?=$pro_quantity?>">
                                        </div>
                                        <?php
                                        if (isset($_SESSION['mem_id'])) {
                                        ?>
                                        <button type="submit" class="primary-btn pd-cart" style="border-color: #fa6800 !important;">Add To Cart</button>
                                        <input type="hidden" name="product_id" value="<?=$pro_id?>">
                                        <input type="hidden" name="do" value="cart">
                                        <?php
                                        }else{
                                            echo '<button data-toggle="modal" data-target="#exampleModal1" class="primary-btn pd-cart" style="border-color: #e7ab3c !important;">Add To Cart</button>';
                                        }
                                        ?>
                                    </div>
                                </form>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="related-products spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Related Products</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="product-slider owl-carousel">
                    <?php
                    $sql2 = "SELECT * FROM product WHERE pro_type = :test";
                    $stmt2 = $db->prepare($sql2);
                    $stmt2->bindparam(':test', $test);
                    $stmt2->execute();
                    while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
                        $pro_id1 = $row2['pro_id'];
                        $pro_name1 = $row2['pro_name'];
                        $pro_quantity = $row2['pro_quantity'];
                        $pro_price1 = $row2['pro_price'];
                        $pro_img1 = $row2['pro_img'];

                    ?>
                        <div class="product-item">
                            <div class="pi-pic">
                                <img src="admin/img/<?= $pro_img1 ?>" alt="" style="height: 200px; width: 150px; object-fit: contain;">
                                <ul>
                                    <!-- <li class="w-icon active"><a href="#" data-toggle="modal" data-target="#exampleModalCenter" data-id="<?= $id ?>"><i class="icon_bag_alt"></i></a></li> -->
                                    <li class="quick-view"><a href="product_detail.php?id=<?=$pro_id1?>">+ View</a></li>
                                </ul>
                            </div>
                            <div class="pi-text">
                                <a href="product.detail.blade.php?id=<?=$id?>">
                                    <h5><?= $pro_name1 ?></h5>
                                </a>
                                <div class="product-price">
                                    ฿<?= $pro_price1 ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>


    <?php require_once __DIR__ . '/resource/script.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
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

        $(document).ready(function(e) {
            $("#cart").on('submit', (function(e) {
                e.preventDefault();
                $.ajax({
                    url: "controller/cartController.php",
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
                            swal("Add to cart successfully.", {
                                icon: "success",
                            });
                            setTimeout(function() {
                                window.location.href = "cart.php";
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
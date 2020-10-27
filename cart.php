<?php
session_start();
$user_id = $_SESSION['mem_id'];
include('public/connectpdo.php');
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
    <?php require_once __DIR__ . '/resource/head.php'; ?>
</head>

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
                        <span>Shopping Cart</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb Section Begin -->

    <!-- Shopping Cart Section Begin -->
    <section class="shopping-cart spad">
        <form id="cart_form" method="POST" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th class="p-name">Product Name</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                $sql = "SELECT * FROM cart WHERE user_id = :user_id AND status = 0";
                                $stmt = $db->prepare($sql);
                                $stmt->bindparam(':user_id', $user_id);
                                $stmt->execute();
                                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    $id = $row['id'];
                                    $product_id = $row['product_id'];
                                    $amount = $row['amount'];
                                    $price = $row['price'];

                                $sql1 = "SELECT * FROM product WHERE pro_id = :product_id";
                                $stmt1 = $db->prepare($sql1);
                                $stmt1->bindparam(':product_id', $product_id);
                                $stmt1->execute();
                                $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                                    $pro_id2 = $row1['pro_id'];
                                    $pro_name = $row1['pro_name'];
                                    $pro_quantity = $row1['pro_quantity'];
                                    $pro_price = $row1['pro_price'];
                                    $pro_img = $row1['pro_img'];

                                    $sum = $amount * $pro_price;
            

                                ?>
                                    <tr>
                                        <td class="cart-pic first-row"><img src="admin/img/<?= $pro_img ?>" alt=""></td>
                                        <td class="cart-title first-row">
                                            <h5><?=$pro_name?></h5>
                                        </td>
                                        <td class="p-price first-row">฿<?=$pro_price?></td>
                                        <td class="qua-col first-row">
                                            <div class="quantity">
                                                <input type="number" name="amount[]" value="<?=$amount?>" max="<?=$pro_quantity?>" style="width: 80px;" class="form-control">                                      
                                            </div>
                                        </td>
                                        <td class="total-price first-row">฿<?=$price?></td>
                                        <td class="close-td first-row"><a href="controller/delete.product.php?id=<?=$id?>" style="color: #000;" onclick="return confirm('Are you sure ?')"><i class="ti-close"></i></a></td>
                                        <input type="hidden" name="cart_id[]" value="<?=$id?>">
                                        <input type="hidden" name="product_id[]" value="<?=$pro_id2?>">
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php

                        $sql2 = "SELECT *,SUM(price) as sum FROM cart WHERE user_id = :user_id AND status = 0";
                        $stmt2 = $db->prepare($sql2);
                        $stmt2->bindparam(':user_id', $user_id);
                        $stmt2->execute();
                        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                            $id = $row2['id'];
                            $price2 = $row2['sum'];
                            $amount = $row2['amount'];

                            $price2 = number_format($price2);
                        
                        ?>
                        <div class="row">
                            <div class="col-lg-4">
                            </div>
                            <div class="col-lg-4 offset-lg-4">
                                <div class="proceed-checkout">
                                    <ul>
                                        <li class="subtotal">Subtotal <span>฿<?=$price2?></span></li>
                                        <li class="cart-total">Total <span>฿<?=$price2?></span></li>
                                    </ul>
                                    <button type="submit" class="proceed-btn" style="width: 360px">PROCEED TO CHECK OUT</button>
                                    <input type="hidden" name="do" value="invoice">
                                    <input type="hidden" name="price" value="<?=$price2?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>    
    </section>


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
            $("#cart_form").on('submit', (function(e) {
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
                            swal("Invoice successfully.", {
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
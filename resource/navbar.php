<?php 
         
$sql4 = "SELECT SUM(price) as sum FROM cart WHERE user_id = '".$_SESSION['mem_id']."' AND status = 0";
$stmt4 = $db->prepare($sql4);
$stmt4->bindparam(':user_id', $user_id);
$stmt4->execute();
$row4 = $stmt4->fetch(PDO::FETCH_ASSOC);
    $sum1 = $row4['sum'];
?>    
    <header class="header-section">
        <div class="header-top">
            <div class="container">
                <?php
                if (isset($_SESSION['mem_id'])) {
                    if ($_SESSION['mem_level'] == 0) {
                        echo '<div class="ht-left">
                                <div class="mail-service">
                                    <i class="fa fa-user"></i>
                                    <b>'.$_SESSION['mem_email'].'</b>
                                </div>
                                <div class="phone-service">
                                    <a href="profile.php"  style="color: black !important;"><i class="fa fa-id-card"></i><b>Profile</b></a>
                                </div>
                             </div>
                             <div class="ht-right">
                                <a href="logout.php" class="login-panel"><i class="fa fa-sign-out"></i><b>Logout</b></a>
                             </div>';
                    } else {
                        echo '
                                <div class="ht-left">
                                    <div class="mail-service">
                                        <i class=" fa fa-user"></i>
                                        <b>'.$_SESSION['mem_firstname'].' '. $_SESSION['mem_lastname'].'</b>
                                    </div>
                                    <div class="phone-service">
                                        <a href="profile.php" style="color: black !important;"><i class="fa fa-id-card"></i><b>Profile</b></a>
                                    </div>
                                </div>
                                <div class="ht-right">
                                    <a href="logout.php" class="login-panel"><i class="fa fa-sign-out"></i><b>Logout</b></a>
                                </div>';
                    }
                ?>
                <?php
                } else {
                    echo
                        '<div class="ht-right">
                        <a href="#" class="login-panel" style="margin-left: 18px !important;" data-toggle="modal" data-target="#exampleModal">Register</a>
                        <a href="#" class="login-panel" data-toggle="modal" data-target="#exampleModal1">Login</a>
                     </div>';
                }
                ?>
            </div>
        </div>
        <div class="container">
            <div class="inner-header">
                <div class="row">
                    <div class="col-lg-2 col-md-2">
                        <div class="logo">
                            <a href="index.php">
                                <img src="assets/img/Logoo.png" alt="" style="margin-top: -40px;">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10 text-right col-md-3">
                        <ul class="nav-right d-flex justify-content-end">
                            <li class="cart-icon">
                                <a href="#">
                                    <i class="icon_bag_alt"></i>
                                    <?php

                                    $sql2 = "SELECT COUNT(id) as cart_id FROM cart WHERE user_id = '".$_SESSION['mem_id']."' AND status = 0";
                                    $stmt2 = $db->prepare($sql2);
                                    $stmt2->execute();
                                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                        $count = $row2['cart_id'];
                                    
                                    ?>
                                    <span><?=$count?></span>
                                </a>
                                <div class="cart-hover">
                                    <div class="select-items">
                                        <table>
                                            <tbody>
                                            <?php

                                                $sql = "SELECT * FROM cart WHERE user_id = '".$_SESSION['mem_id']."' AND status = 0";
                                                $stmt = $db->prepare($sql);
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
                                                    $id1 = $row1['pro_id'];
                                                    $pro_name = $row1['pro_name'];
                                                    $pro_quantity = $row1['pro_quantity'];
                                                    $pro_type = $row1['pro_type'];
                                                    $pro_price = $row1['pro_price'];
                                                    $pro_img = $row1['pro_img'];

                                                    $sum = $amount * $price1;

                                            ?>
                                                <tr>
                                                    <td class="si-pic"><img src="admin/img/<?= $pro_img ?>" alt="" style="width: 75px; height: 75px;"></td>
                                                    <td class="si-text">
                                                        <div class="product-selected">
                                                            <p>฿<?=$pro_price?> x <?=$amount?></p>
                                                            <h6><?=$pro_name?></h6>
                                                        </div>
                                                    </td>
                                                    <td class="si-close">
                                                        <i class="ti-close"></i>
                                                    </td>
                                                </tr>
                                            <?php } ?>    
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="select-total">
                                        <span>total:</span>
                                        <h5>฿<?=$sum1?></h5>
                                    </div>
                                    <div class="select-button">
                                        <a href="cart.php" class="primary-btn checkout-btn">Check Out</a>
                                    </div>
                                </div>
                            </li>
                            <li class="cart-price">฿<?=$sum1?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-item">
            <div class="container">
                <div class="nav-depart">
                    <div class="depart-btn">
                        <i class="ti-menu"></i>
                        <span>All Category</span>
                        <ul class="depart-hover">
                             <?php
                                $sql = "SELECT * FROM type";
                                $stmt=$db->prepare($sql);
                                $stmt->execute();
                                while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                                    $type_id = $row['type_id'];
                                    $type_name = $row['type_name'];
                            ?>
                            <li><a href="shop.php?id=<?=$type_id?>"><?=$type_name?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <nav class="nav-menu mobile-menu">
                    <ul>
                        <li class=""><a href="index.php">Home</a></li>
                        <?php if (isset($_SESSION['mem_id'])) { ?>
                        <li class=""><a href="product.php">Product</a></li>
                        <li class=""><a href="cart.php">Cart</a></li>
                        <li class=""><a href="history.php">Buyer</a></li>
                        <li class=""><a href="his.php">history</a></li>
                        <?php 
                        }else{
                            echo "";
                        }
                        ?>

                    </ul>
                </nav>
                <div id="mobile-menu-wrap"></div>
            </div>
        </div>
    </header>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>Register Form<b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/registerController.php" id="register_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="exampleFormControlInput1">Firstname</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="mem_firstname" id="mem_firstname" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleFormControlInput1">Lastname</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="mem_lastname" id="mem_lastname" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlInput1">E-mail</label>
                                <input type="email" class="form-control" id="exampleFormControlInput1" name="mem_email" id="mem_email" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleFormControlInput1">Password</label>
                                <input type="password" class="form-control" id="exampleFormControlInput1" name="mem_password" id="mem_password" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleFormControlInput1">tel</label>
                                <input type="text" class="form-control" id="exampleFormControlInput1" name="mem_tel" id="mem_tel" required>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleFormControlInput1">Address</label>
                                <textarea class="form-control" id="exampleFormControlInput1" name="mem_address" id="mem_address" cols="12" rows="5" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn" style="color: #fff !important; background-color: #e7ab3c !important;">Register</button>
                        <input type="hidden" name="do" value="register">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><b>Login Form<b></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="controller/loginController.php" id="login_form" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Email address</label>
                            <input type="email" class="form-control" id="exampleFormControlInput1" name="mem_email" id="test1@mem_email.com" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlInput1">Password</label>
                            <input type="password" class="form-control" id="exampleFormControlInput1" name="mem_password" id="mem_password" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-toggle="modal" data-target="#exampleModal" data-dismiss="modal" class="btn" style="color: #fff !important; background-color: #000 !important;">Register</button>
                        <button type="submit" class="btn" style="color: #fff !important; background-color: #e7ab3c !important;">Login</button>
                        <input type="hidden" name="do" value="login">
                    </div>
                </form>
            </div>
        </div>
    </div>
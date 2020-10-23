<?php session_start(); 
include('public/connectpdo.php');
$id = $_SESSION['mem_id'];
$sql = "SELECT * FROM member WHERE mem_id = :id";
$stmt=$db->prepare($sql);
$stmt->bindparam(':id', $id);
$stmt->execute();
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$mem_id = $row['mem_id'];
$mem_firstname = $row['mem_firstname'];
$mem_lastname = $row['mem_lastname'];
$mem_tel = $row['mem_tel'];
$mem_email = $row['mem_email'];
$mem_address = $row['mem_address']
?>
<!DOCTYPE html>
<html lang="zxx">

<head>
   <?php require_once __DIR__.'/resource/head.php'; ?>
</head>

<body>
    <div id="preloder">
        <div class="loader"></div>
    </div>
    
    <?php require_once __DIR__.'/resource/navbar.php'; ?>

    <div class="breacrumb-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-text">
                        <a href="index.blade.php"><i class="fa fa-home"></i> Home</a>
                        <span>Profile</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-section spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mt-4">
                    <div class="contact-title">
                        <div class="bi-pic">
                            <img src="img/blog/blog-1.jpg" alt="">
                        </div>
                    </div>
                    <div class="contact-widget ">
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-location-pin"></i>
                            </div>
                            <div class="ci-text">
                                <span>Address:</span>
                                <p><?php if($mem_address == NULL){ echo'<p>You have not entered this information yet.</p>'; }else{ echo''.$mem_address.''; } ?></p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-mobile"></i>
                            </div>
                            <div class="ci-text">
                                <span>Phone:</span>
                                <p><?php if($mem_tel == NULL){ echo'<p>You have not entered this tel yet.</p>'; }else{ echo''.$mem_tel.''; } ?></p>
                            </div>
                        </div>
                        <div class="cw-item">
                            <div class="ci-icon">
                                <i class="ti-email"></i>
                            </div>
                            <div class="ci-text">
                                <span>Email:</span>
                                <p><?php if($mem_email == NULL){ echo'<p>You have not entered this information yet.</p>'; }else{ echo''.$mem_email.''; } ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="contact-form">
                        <div class="leave-comment">
                            <h4>Profile</h4>
                            <form id="update_profile" method="POST" enctype="multipart/form-data" class="comment-form">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input type="text" name="mem_firstname" id="mem_firstname" value="<?=$mem_firstname?>">
                                    </div>
                                    <div class="col-lg-6">
                                        <input type="text" name="mem_lastname" id="mem_lastname" placeholder="lastname" value="<?=$mem_lastname?>">
                                    </div>
                                    <div class="col-lg-12">
                                        <input type="tel" name="mem_tel" id="mem_tel"  placeholder="Tel" value="<?=$mem_tel?>">
                                    </div>
                                    <div class="col-lg-12">
                                        <textarea name="mem_address" placeholder="mem_address"><?=$mem_address?></textarea>
                                        <button type="submit" class="site-btn" style="background-color: #fa6800; border:#fa6800;">Update</button>
                                        <input type="hidden" name="do" value="update">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php require_once __DIR__.'/resource/script.php'; ?>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#update_profile").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: "controller/profileController.php",
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
                        swal("Update successfully.", {
                            icon: "success",
                        });
                        setTimeout(function() {
                            window.location.href = "index.php";
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
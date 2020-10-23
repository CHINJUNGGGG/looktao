<?php
session_start();
include('public/connectpdo.php');
include('public/connect.php');
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
   

    <section class="hero-section">
        <div class="hero-items owl-carousel">
            <div class="single-hero-items set-bg" data-setbg="img/hero-1.jpg">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                        </div>
                    </div>
                    <div class="off-card">
                    </div>
                </div>
            </div>
        </div>
    </section>

  <?php require_once __DIR__.'/resource/script.php'; ?>
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
                            swal("Registered successfully.", {
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
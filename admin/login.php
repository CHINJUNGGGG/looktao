<?php session_start(); require_once __DIR__.'/path/connectpdo.php'; ?>
<!DOCTYPE html>
<html>

<head><?php require_once __DIR__.'/path/head.php'; ?></head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="../../index2.html"><b>Lootao</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form id="login_form" method="post" enctype="multipart/form-data">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" name="mem_email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Password" name="mem_password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">

                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            <input type="hidden" name="do" value="login">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require_once __DIR__.'/path/script.php'; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
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
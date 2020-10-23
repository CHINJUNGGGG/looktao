<?php 
if (isset($_SESSION['mem_id'])){ 
    
}else{
    echo "<script>";
    echo "alert('กรุณาล็อคอินเข้าสู่ระบบ');";
    echo "window.location.href='login.php';";
    echo "</script>";
} ?>  




<aside class="main-sidebar sidebar-light-primary elevation-4">
    <a href="index.php" class="brand-link">
        <span class="brand-text font-weight-light">LOOKTAO</span>
    </a>


    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block"><?php echo $_SESSION['mem_firstname']; ?> <?php echo $_SESSION['mem_lastname']; ?></a>
            </div>
        </div>


        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            หน้าหลัก

                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="member.php" class="nav-link">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                            ข้อมูลสมาชิก
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="product.php" class="nav-link">
                        <i class="nav-icon fas fa-store-alt"></i>
                        <p>
                            ข้อมูลสินค้า
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="invoice.php" class="nav-link">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>
                            ข้อมูลรายละเอียดการสั่งซื้อ
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="tracking.php" class="nav-link">
                        <i class="nav-icon fas fa-truck"></i>
                        <p>
                            ข้อมูลราคาขนส่ง
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="user.php" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            ข้อมูลแอดมิน
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" data-toggle="modal" data-target="#report_month" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            รายงานยอดขายประจำเดือน
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout.php" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            ออกจากระบบ
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<div class="modal fade" id="report_month" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="report_month.php" method="POST" enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputState">เลือกวันที่ต้องการค้นหา</label>
                            <input type="date" name="month" class="form-control">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary">พิมพ์</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
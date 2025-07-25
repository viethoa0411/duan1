<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div>
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <main class="content">
            <h2>Chào mừng đến trang quản trị</h2>
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Tổng quan</h5>
                                <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card card-stats p-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Tổng sản phẩm</h6>
                                <h4>1,234</h4>
                            </div>
                            <i class="bi bi-box-seam display-5 text-primary"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stats p-3 border-start-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Đơn hàng</h6>
                                <h4>567</h4>
                            </div>
                            <i class="bi bi-cart-check display-5 text-success"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stats p-3 border-start-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Người dùng</h6>
                                <h4>289</h4>
                            </div>
                            <i class="bi bi-people display-5 text-warning"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-stats p-3 border-start-danger">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6>Doanh thu</h6>
                                <h4>$12K</h4>
                            </div>
                            <i class="bi bi-currency-dollar display-5 text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
                </div>
            </div>
                        <div class="card">
                <div class="card-header fw-bold">Đơn hàng gần đây</div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Khách hàng</th>
                                <th>Ngày</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1001</td>
                                <td>Nguyễn Văn A</td>
                                <td>22/07/2025</td>
                                <td>$120</td>
                                <td><span class="badge bg-success">Hoàn tất</span></td>
                            </tr>
                            <tr>
                                <td>1002</td>
                                <td>Trần Thị B</td>
                                <td>21/07/2025</td>
                                <td>$80</td>
                                <td><span class="badge bg-warning text-dark">Đang xử lý</span></td>
                            </tr>
                            <tr>
                                <td>1003</td>
                                <td>Phạm Văn C</td>
                                <td>20/07/2025</td>
                                <td>$60</td>
                                <td><span class="badge bg-danger">Hủy</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>


    </div>
</div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
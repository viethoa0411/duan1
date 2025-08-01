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
                                        <h4> <?= $totalProducts ?></h4>
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
                                        <h4><?= $totalOrders ?></h4>
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
                                        <h4><?= $totalUsers ?></h4>
                                    </div>
                                    <i class="bi bi-people display-5 text-warning"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats p-3 border-start-danger">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6>Doanh thu tháng</h6>
                                        <h4><?= $month ?>/<?= $year ?>: <?= number_format($revenue, 0, ',', '.') ?> VNĐ</h4>
                                    </div>
                                    <i class="bi bi-currency-dollar display-5 text-danger"></i>
                                </div>
                            </div>
                            <form method="GET" class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <label for="month" class="form-label">Chọn tháng</label>
                                    <select name="month" id="month" class="form-select">
                                        <option value="">-- Tất cả --</option>
                                        <?php for ($m = 1; $m <= 12; $m++): ?>
                                            <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>>Tháng <?= $m ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="year" class="form-label">Chọn năm</label>
                                    <input type="number" name="year" id="year" value="<?= $year ?>" class="form-control" min="2000" max="<?= date('Y') ?>">
                                </div>
                                <div class="col-12 mt-2">
                                    <button type="submit" class="btn btn-primary w-100">Xem doanh thu</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            <h3>Biểu đồ doanh thu 12 tháng gần nhất</h3>
            <canvas id="revenueChart"></canvas>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const ctx = document.getElementById('revenueChart').getContext('2d');

                // Dữ liệu từ PHP
                const labels = <?= json_encode(array_map(fn($row) => $row['month'] . '/' . $row['year'], $revenueData)) ?>;
                const data = <?= json_encode(array_map(fn($row) => (int)$row['total_revenue'], $revenueData)) ?>;

                new Chart(ctx, {
                    type: 'bar', // Có thể đổi sang 'line'
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Doanh thu (VNĐ)',
                            data: data,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString('vi-VN') + ' VNĐ';
                                    }
                                }
                            }
                        }
                    }
                });
            </script>

            <div class="card">
                <div class="card-header fw-bold">Đơn hàng gần đây</div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Ngày</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($orders)): ?>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['order_code']) ?></td>
                                        <td><?= htmlspecialchars($order['user_name']) ?></td>
                                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                                        <td><?= number_format($order['total_amount'], 0, ',', '.') ?>₫</td>
                                        <td><?= htmlspecialchars($order['status_name']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL_ADMIN . '?act=orders/detail&id=' . $order['id'] ?>" class="btn btn-primary btn-sm">Xem</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="text-center">Không có đơn hàng nào.</td>
                                </tr>
                            <?php endif; ?>
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
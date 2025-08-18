<?php require './views/admin/layouts/header.php'; ?>
<?php if (!empty($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['success_message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<div class="container-fluid">
    <div>
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <main class="content">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Chi tiết đơn hàng #<?= htmlspecialchars($orders['order_code']) ?></h2>

                <form action="<?= BASE_URL_ADMIN . '?act=orders/update' ?>" method="post" class="d-flex align-items-center"
                    onsubmit="return confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này không?');">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($orders['id']) ?>">

                    <select name="status_id" class="form-select form-select-sm me-2" style="width: 200px;">
                        <?php foreach ($liststatus as $status): ?>
                            <option
                                <?php
                                if (
                                    $orders['status_id'] > $status['id']
                                    || $orders['status_id'] == 9
                                    || $orders['status_id'] == 10
                                    || $orders['status_id'] == 11
                                    || ($orders['status_id'] == 8 && $status['id'] == 11)
                                ) {
                                    echo 'disabled';
                                }
                                ?>

                                <?= $status['id'] == $orders['status_id'] ? 'selected' : '' ?>
                                value="<?= $status['id']; ?>"><?= $status['name'] ?></option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-sm btn-primary"> Cập nhật</button>
                </form>
            </div>

            <?php
            $status = $orders['status_id'] ?? 0;
            if ($status == 1) {
                $colorAlerts = 'primary';
            } elseif ($status >= 2 && $status <= 9) {
                $colorAlerts = 'warning';
            } elseif ($status == 10) {
                $colorAlerts = 'success';
            } else {
                $colorAlerts = 'danger';
            }
            ?>

            <div class="row">
                <!-- Thông tin người đặt hàng -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Thông tin người đặt hàng</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="fw-bold">Họ tên:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['user_name'] ?? '') ?></span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-bold">Email:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['user_email'] ?? '') ?></span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-bold">Điện thoại:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['user_phone'] ?? '') ?></span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-bold">Ngày đặt:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['order_date']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-bold">Ghi chú:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['note']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-bold">Trạng thái:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['status_name']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-bold">Phương thức thanh toán:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['payment_method_name']) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Thông tin người nhận -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header text-white alert alert-<?= $colorAlerts; ?>" role="alert">
                            <h5 class="mb-0">Thông tin người nhận</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="fw-bold">Họ tên:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['consignee']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-bold">Điện thoại:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['phone']) ?></span>
                            </li>
                            <li class="list-group-item">
                                <span class="fw-bold">Địa chỉ:</span>
                                <span class="text-muted"><?= htmlspecialchars($orders['address']) ?></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>





            <h5>Sản phẩm đã đặt</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $total = 0;
                    $ship = 50000; // phí ship cố định
                    foreach ($orderItems as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($item['product_image']) ?>" width="60"></td>
                            <td><?= htmlspecialchars($item['product_name']) ?></td>
                            <td><?= number_format($item['price']) ?>đ</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($subtotal) ?>đ</td>
                            <td></td>
                        </tr>
                    <?php endforeach; ?>

                    <tr>
                        <td colspan="4" align="right"><strong>Phí ship:</strong></td>
                        <td><?= number_format($ship) ?>đ</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="4" align="right"><strong>Tổng cộng:</strong></td>
                        <td><?= number_format($total + $ship) ?>đ</td>
                        <td></td>
                    </tr>

                </tbody>
            </table>

            <a href="<?= BASE_URL_ADMIN . '?act=orders' ?>" class="btn btn-secondary">Quay Lại</a>

        </main>


    </div>
</div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
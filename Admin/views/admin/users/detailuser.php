<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">
            <div class="col py-3">
                <h2>Chi tiết Khách hàng</h2>

                <?php if (!empty($user)): ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Tên người dùng</th>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                        </tr>
                        <tr>
                            <th>SĐT</th>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                        </tr>
                        <tr>
                            <th>Địa chỉ</th>
                            <td><?= htmlspecialchars($user['address']) ?></td>
                        </tr>
                        <tr>
                            <th>Quyền</th>
                            <td><?= htmlspecialchars($user['role_name'] ?? 'Không xác định') ?></td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td><?= htmlspecialchars($user['created_at'] ?? 'Không rõ') ?></td>
                        </tr>
                        <tr>
                            <th>Ngày cập nhật</th>
                            <td><?= htmlspecialchars($user['updated_at'] ?? 'Không rõ') ?></td>
                        </tr>
                    </table>

                    <!-- Lịch sử mua hàng -->
                    <h4 class="mt-4">Lịch sử mua hàng</h4>
                    <?php if (!empty($orders)): ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Ngày đặt</th>
                                    <th>Tổng tiền</th>
                                    <th>Phương thức thanh toán</th>
                                    <th>Trạng thái</th>
                                    <th>Chi tiết</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($orders as $order): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($order['order_code']) ?></td>
                                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                                        <td><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                                        <td><?= htmlspecialchars($order['payment_method_name']) ?></td>
                                        <td><?= htmlspecialchars($order['status_name']) ?></td>
                                        <td>
                                            <a href="<?= BASE_URL_ADMIN . '?act=orders/detail&id=' . $order['id'] ?>" class="btn btn-info btn-sm">Xem</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Khách hàng này chưa có đơn hàng nào.</p>
                    <?php endif; ?>

                <?php else: ?>
                    <div class="alert alert-warning">Không tìm thấy người dùng.</div>
                <?php endif; ?>

                <a href="<?= BASE_URL_ADMIN . '?act=users' ?>" class="btn btn-secondary mt-3">Danh sách khách hàng</a>
            </div>
        </main>
    </div>
</div>

<?php include './views/admin/layouts/footer.php'; ?>

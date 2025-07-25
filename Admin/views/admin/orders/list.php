<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">

        <!-- Main content -->
            <div class="col py-3">
                <h2>Danh sách đơn hàng </h2>
                <table class="table table-bordered">
                    <tr>
                        <th>ID</th>
                        <th>Tên người dùng</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th> 
                        <th>Tổng số tiền </th>
                        <th>Địa chỉ</th> 
                        <th>Phương thức thanh toán</th>
                        <th>Trạng thái thanh toán</th>
                        <th>ID giảm giá</th>
                        <th>Hành động</th>
                    </tr>
                    <tr>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><?= htmlspecialchars($order['id']) ?></td>
                                <td><?= htmlspecialchars($order['user_name']) ?></td>
                                <td><?= htmlspecialchars($order['order_date']) ?></td>
                                <td><?= htmlspecialchars($order['status']) ?></td>
                                <td><?= htmlspecialchars($order['total_amount']) ?></td>
                                <td><?= htmlspecialchars($order['address']) ?></td>
                                <td><?= htmlspecialchars($order['payment_method']) ?></td>
                                <td><?= htmlspecialchars($order['payment_status']) ?></td>
                                <td><?= ($order['discount_id']) ?></td>
                                <td>
                                    <a href="<?= BASE_URL_ADMIN . '?act=products/detail&id=' . $product['id'] ?>" class="btn btn-primary btn-sm">Xem</a>
                                </td>
                            </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="4">Không có đơn hàng nào.</td>
                </tr>
            <?php endif; ?>
            </tr>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">

            <!-- Main content -->
            <div class="col py-3">
                <h2>Danh sách đơn hàng </h2>
               <form method="GET" action="" class="mb-3 d-flex" style="max-width: 400px;">
                <input type="hidden" name="act" value="orders">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm kiếm đơn hàng" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                <button type="submit" class="btn btn-outline-primary">Tìm</button>
            </form>

                <table class="table table-bordered">
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Tên người Nhận</th>
                        <th>Số điện toại</th>
                        <th>Tổng số tiền </th>
                        <th>Địa chỉ</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                    <tr>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['order_code']) ?></td>
                        <td><?= htmlspecialchars($order['consignee']) ?></td>
                        <td><?= htmlspecialchars($order['phone']) ?></td>
                        <td><?= htmlspecialchars($order['total_amount']) ?></td>
                        <td><?= htmlspecialchars($order['address']) ?></td>
                        <td><?= htmlspecialchars($order['order_date']) ?></td>
                        <td><?= htmlspecialchars($order['status_name']) ?></td>
                        <td>
                            <a href="<?= BASE_URL_ADMIN . '?act=orders/detail&id=' . $order['id'] ?>" class="btn btn-primary btn-sm">Xem</a>
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
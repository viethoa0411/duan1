<?php require_once './views/clients/layouts/header.php' ?>
<?php
// Đảm bảo biến $orderItems đã được truyền từ Controller

$tongTien = 0;
$phiVanChuyen = 50000;

if (!empty($orderItems)) {
    foreach ($orderItems as $item) {
        $tongTien += $item['total_price'];
    }
}

$tongThanhToan = $tongTien + $phiVanChuyen;
?>

<body class="bg-light">
    <div class="container py-5">
        <h2 class="mb-4 text-center text-primary">Chi tiết đơn hàng #<?= htmlspecialchars($order['order_code'] ?? '') ?></h2>

        <!-- Thông tin đơn hàng -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-info text-white">
                <strong>Trạng thái đơn hàng</strong>
            </div>
            <div class="card-body">
                <p class="mb-0">
                    <i class="bi bi-info-circle-fill text-info me-2"></i>
                    <span class="badge bg-secondary px-3 py-2">
                        <?= htmlspecialchars($order['status_name'] ?? 'Không rõ') ?>
                    </span>
                </p>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-success text-white">
                <strong>Sản phẩm đã đặt</strong>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach ($orderItems as $item): ?>
                    <li class="list-group-item d-flex align-items-center">
                        <?php
                        $imagePath = 'admin/uploads/' . ($item['image'] ?? 'default.jpg');
                        ?>
                        <img src="<?= htmlspecialchars($imagePath) ?>"
                            alt="<?= htmlspecialchars($item['product_name'] ?? 'Không rõ') ?>"
                            class="img-thumbnail me-3"
                            style="width: 80px; height: 80px; object-fit: cover;">



                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?= htmlspecialchars($item['product_name']) ?></h6>
                            <small class="text-muted d-block">
                                <?= !empty($item['color']) ? "Màu: " . htmlspecialchars($item['color']) . ", " : "" ?>
                                <?= !empty($item['size']) ? "Size: " . htmlspecialchars($item['size']) : "" ?>
                            </small>
                            <span class="text-muted">
                                <?= number_format($item['price']) ?> VNĐ x <?= $item['quantity'] ?>
                            </span>
                        </div>

                        <strong class="text-danger"><?= number_format($item['total_price']) ?> VNĐ</strong>
                    </li>
                    <div class="card-body text-end">
                        <p><strong>Tổng cộng:</strong> <?= number_format($tongTien) ?> VNĐ</p>
                        <p><strong>Phí vận chuyển:</strong> <?= number_format($phiVanChuyen) ?> VNĐ</p>
                        <h5><strong>Thanh toán: <span class="text-danger"><?= number_format($tongThanhToan) ?> VNĐ</span></strong></h5>
                    </div>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Thông tin người nhận -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <strong>Thông tin người nhận</strong>
            </div>
            <div class="card-body">
                <p><strong>Họ tên:</strong> <?= htmlspecialchars($order['consignee']) ?></p>
                <p><strong>SĐT:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                <p><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['address']) ?></p>
                <p><strong>Ghi chú:</strong> <?= !empty($order['note']) ? htmlspecialchars($order['note']) : 'Không có' ?></p>
            </div>
        </div>

        <!-- Nút hủy đơn hàng -->
        <div class="mt-3">
            <a href="<?= BASE_URL . '?act=remote-order&id=' . $order['id'] ?>"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?');">
                Hủy đơn hàng
            </a>

        </div>


    </div>
</body>

<?php require_once './views/clients/layouts/footer.php' ?>
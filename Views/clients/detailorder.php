<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-light">
    <?php require_once './views/clients/layouts/header.php' ?>

    <?php
    // Khởi tạo
    $tongTien = 0;
    $phiVanChuyen = 50000;

    if (!empty($orderItems)) {
        foreach ($orderItems as $item) {
            // Chọn giá hợp lệ
            $donGia = (!empty($item['sale_price']) && $item['sale_price'] > 0)
                ? $item['sale_price']
                : $item['original_price'];

            $thanhTien = $donGia * $item['quantity'];
            $tongTien += $thanhTien;
        }
    }

    $tongThanhToan = $tongTien + $phiVanChuyen;
    ?>

    <div class="container py-5">
        <h2 class="mb-4 text-center text-primary">
            Chi tiết đơn hàng #<?= htmlspecialchars($order['order_code'] ?? '') ?>
        </h2>

        <!-- Trạng thái đơn hàng -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-info text-white">
                <strong>Trạng thái đơn hàng</strong>
            </div>
            <div class="card-body">
                <span class="badge bg-secondary px-3 py-2 fs-6">
                    <?= htmlspecialchars($order['status_name'] ?? 'Không rõ') ?>
                </span>
            </div>
        </div>

        <!-- Danh sách sản phẩm -->
        <div class="card shadow-sm mb-4 border-0">
            <div class="card-header bg-success text-white">
                <strong>Sản phẩm đã đặt</strong>
            </div>
            <ul class="list-group list-group-flush">
                <?php foreach ($orderItems as $item): ?>
                    <?php
                    $imagePath = !empty($item['image']) ? $item['image'] : 'uploads/products/default.jpg';
                    $donGia = (!empty($item['sale_price']) && $item['sale_price'] > 0)
                        ? $item['sale_price']
                        : $item['original_price'];
                    $thanhTien = $donGia * $item['quantity'];
                    ?>
                    <li class="list-group-item d-flex align-items-center">
                        <img src="/duan1/admin/<?= htmlspecialchars($imagePath) ?>"
                             alt="<?= htmlspecialchars($item['product_name'] ?? 'Không rõ') ?>"
                             class="img-thumbnail me-3"
                             style="width: 80px; height: 80px; object-fit: cover;">

                        <div class="flex-grow-1">
                            <h6 class="mb-1"><?= htmlspecialchars($item['product_name']) ?></h6>
                            <small class="text-muted d-block mb-1">
                                <?= !empty($item['color']) ? "Màu: " . htmlspecialchars($item['color']) . ", " : "" ?>
                                <?= !empty($item['size']) ? "Size: " . htmlspecialchars($item['size']) : "" ?>
                            </small>

                            <!-- Hiển thị giá -->
                            <?php if (!empty($item['sale_price']) && $item['sale_price'] > 0): ?>
                                <div>
                                    <span class="text-muted text-decoration-line-through">
                                        <?= number_format($item['original_price']) ?> VNĐ
                                    </span>
                                    <span class="text-danger fw-bold ms-2">
                                        <?= number_format($item['sale_price']) ?> VNĐ
                                    </span>
                                </div>
                            <?php else: ?>
                                <div>
                                    <span class="text-muted">
                                        <?= number_format($item['original_price']) ?> VNĐ
                                    </span>
                                </div>
                            <?php endif; ?>

                            <!-- Giá khi đặt -->
                            <small class="text-success d-block">
                                Giá khi đặt: <?= number_format($donGia) ?> VNĐ
                            </small>

                            <!-- Số lượng -->
                            <span class="badge bg-light text-dark">
                                x <?= $item['quantity'] ?>
                            </span>
                        </div>

                        <!-- Thành tiền -->
                        <strong class="text-danger"><?= number_format($thanhTien) ?> VNĐ</strong>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="card-footer text-end bg-white">
                <p class="mb-1"><strong>Tổng cộng:</strong> <?= number_format($tongTien) ?> VNĐ</p>
                <p class="mb-1"><strong>Phí vận chuyển:</strong> <?= number_format($phiVanChuyen) ?> VNĐ</p>
                <h5 class="mb-0">
                    <strong>Thanh toán:
                        <span class="text-danger"><?= number_format($tongThanhToan) ?> VNĐ</span>
                    </strong>
                </h5>
            </div>
        </div>

        <!-- Thông tin người nhận -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white">
                <strong>Thông tin người nhận</strong>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Họ tên:</strong> <?= htmlspecialchars($order['consignee']) ?></p>
                <p class="mb-1"><strong>SĐT:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                <p class="mb-1"><strong>Địa chỉ giao hàng:</strong> <?= htmlspecialchars($order['address']) ?></p>
                <p class="mb-0"><strong>Ghi chú:</strong> <?= !empty($order['note']) ? htmlspecialchars($order['note']) : 'Không có' ?></p>
            </div>
        </div>

        <!-- Nút thao tác -->
        <div class="mt-3 d-flex gap-2">
            <a href="<?= BASE_URL . '?act=remote-order&id=' . $order['id'] ?>"
               class="btn btn-danger btn-sm"
               onclick="return confirm('Bạn có chắc muốn hủy đơn hàng này không?');">
                <i class="bi bi-x-circle"></i> Hủy đơn hàng
            </a>

            <a href="<?= BASE_URL . '?act=refund-order&id=' . $order['id'] ?>"
               class="btn btn-warning btn-sm"
               onclick="return confirm('Bạn có chắc muốn hoàn hàng không?');">
                <i class="bi bi-arrow-counterclockwise"></i> Hoàn hàng
            </a>
        </div>
    </div>

    <?php require_once './views/clients/layouts/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

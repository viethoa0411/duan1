<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 15px;
        }

        .order-summary .list-group-item {
            display: flex;
            align-items: center;
        }

        .order-summary .list-group-item .product-info {
            flex-grow: 1;
        }

        .order-summary .list-group-item .product-info h6 {
            margin: 0;
        }

        .order-summary .list-group-item .product-info small {
            color: #6c757d;
        }

        .sticky-top {
            top: 20px;
        }

        .old-price {
            text-decoration: line-through;
            color: #6c757d;
            font-size: 0.9rem;
            margin-right: 5px;
        }

        .sale-price {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<?php require_once './views/clients/layouts/header.php'; ?>

<body>
    <?php
    $shippingFee = 50000;
    $discount = 0; // mặc định chưa có giảm giá
    $totalPrice = 0;

    // Tính tổng tiền hàng
    foreach ($checkoutItems as $item) {
        $price_sale = $item['price_sale'] ?? 0;
        $price      = $item['price'] ?? 0;
        $finalPrice = ($price_sale > 0) ? $price_sale : $price;

        $subtotal = $finalPrice * ($item['quantity'] ?? 1);
        $totalPrice += $subtotal;
    }
    $finalTotalPrice = $totalPrice + $shippingFee - $discount;
    ?>


    <div class="container my-5">
        <h1 class="text-center mb-4">Thanh toán</h1>
        <div class="row g-4">
            <!-- Form thông tin khách hàng -->
            <div class="col-lg-7">
                <form action="<?= BASE_URL ?>?act=place-order" method="POST">
                    <div class="card p-4">
                        <h4 class="mb-3">Thông tin giao hàng</h4>
                        <div class="mb-3">
                            <label for="name" class="form-label">Họ và tên</label>
                            <input type="text" class="form-control" id="consignee" name="consignee"
                                value="<?= $_SESSION['user_client']['name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone"
                                value="<?= $_SESSION['user_client']['phone'] ?? ''; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input class="form-control" id="address" name="address"
                                value="<?= $_SESSION['user_client']['address'] ?? ''; ?>">
                        </div>
                        <div class="mb-3">
                            <label for="note" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="card p-4 mt-4">
                        <h4 class="mb-3">Phương thức thanh toán</h4>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="cod" value="cod"
                                checked>
                            <label class="form-check-label" for="cod">
                                Thanh toán khi nhận hàng (COD)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="online" value="online">
                            <label class="form-check-label" for="online">
                                Chuyển khoản ngân hàng (Online)
                            </label>
                        </div>
                    </div>

                    <!-- Hidden fields -->
                    <input type="hidden" name="final_total_amount" value="<?= $finalTotalPrice; ?>">
                    <input type="hidden" name="shipping_fee" value="<?= $shippingFee; ?>">
                    <?php foreach ($checkoutItems as $item): ?>
                        <input type="hidden" name="selected_products[]" value="<?= $item['cart_id'] ?>">
                    <?php endforeach; ?>

                    <button class="btn btn-primary btn-lg mt-4 w-100" type="submit">Xác nhận đặt hàng</button>
                </form>
            </div>

            <!-- Tóm tắt đơn hàng -->
            <div class="col-lg-5">
                <div class="card p-4 sticky-top">
                    <h3>Đơn hàng của bạn</h3>
                    <ul class="list-group list-group-flush">
                        <?php
                        $totalPrice = 0;
                        foreach ($checkoutItems as $item):
                            $price_sale = $item['price_sale'] ?? 0;
                            $price      = $item['price'] ?? 0;
                            $finalPrice = ($price_sale > 0) ? $price_sale : $price;

                            $subtotal = $finalPrice * ($item['quantity'] ?? 1);
                            $totalPrice += $subtotal;
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($item['product_name']) ?></h6>
                                    <div class="text-muted small">Size: <?= htmlspecialchars($item['size_name']) ?></div>
                                    <div class="text-muted small">Màu sắc: <?= htmlspecialchars($item['color_name']) ?></div>
                                    <div class="text-muted small">Số lượng: x<?= $item['quantity'] ?></div>
                                </div>
                                <span class="fw-semibold text-primary">
                                    <?php if ($price_sale > 0): ?>
                                        <span class="old-price"><?= number_format($price, 0, ',', '.') ?>đ</span>
                                        <span class="sale-price"><?= number_format($price_sale, 0, ',', '.') ?>đ</span>
                                    <?php else: ?>
                                        <?= number_format($price, 0, ',', '.') ?>đ
                                    <?php endif; ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between">
                            <span>Tổng tiền hàng</span>
                            <span><?= number_format($totalPrice, 0, ',', '.') ?> VNĐ</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Phí vận chuyển</span>
                            <span><?= number_format($shippingFee, 0, ',', '.') ?> VNĐ</span>
                        </div>
                        <?php if ($discount > 0): ?>
                            <div class="d-flex justify-content-between text-success">
                                <span>Giảm giá</span>
                                <span>-<?= number_format($discount, 0, ',', '.') ?> VNĐ</span>
                            </div>
                        <?php endif; ?>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Tổng thanh toán</span>
                            <span class="text-danger"><?= number_format($finalTotalPrice, 0, ',', '.') ?> VNĐ</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <?php require_once './views/clients/layouts/footer.php' ?>
</body>

</html>
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
    </style>
</head>

<body>
    <?php
    $shippingFee = 20000;
    $totalPrice = 0;
    foreach ($checkoutItems as $item) {
        $subtotal = $item['price_sale'] * $item['quantity'];
        $totalPrice += $subtotal;
    }
    $finalTotalPrice = $totalPrice + $shippingFee;
    ?>
    <div class="container my-5">
        <h1 class="text-center mb-4">Thanh toán</h1>
        <div class="row g-4">
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
                            <input class="form-control" id="address" name="address" rows="3"
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

                    <input type="hidden" name="final_total_amount" value="<?= $finalTotalPrice; ?>">
                    <input type="hidden" name="shipping_fee" value="<?= $shippingFee; ?>">
                    <?php foreach ($checkoutItems as $item): ?>
                        <input type="hidden" name="selected_products[]" value="<?= $item['cart_id'] ?>">
                    <?php endforeach; ?>

                    <button class="btn btn-primary btn-lg mt-4 w-100" type="submit">Xác nhận đặt hàng</button>
                </form>
            </div>
            <div class="col-lg-5">
                <div class="card p-4 sticky-top">
                    <h3>Đơn hàng của bạn</h3>
                    <ul class="list-group list-group-flush">
                        <?php
                        $totalPrice = 0;
                        foreach ($checkoutItems as $item):
                            $subtotal = $item['price_sale'] * $item['quantity'];
                            $totalPrice += $subtotal;
                        ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="my-0"><?= $item['product_name'] ?></h6>
                                    <small class="text-muted">x<?= $item['quantity'] ?></small>
                                </div>
                                <span class="text-muted"><?= number_format($subtotal, 0, ',', '.') ?> VNĐ</span>
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
                            <span><?= number_format(20000, 0, ',', '.') ?> VNĐ</span>
                        </div>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Mã giảm giá/Voucher" aria-label="Mã giảm giá/Voucher">
                            <button class="btn btn-outline-secondary" type="button" id="apply-voucher">Áp dụng</button>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Tổng thanh toán</span>
                            <span class="text-danger"><?= number_format($totalPrice + 20000, 0, ',', '.') ?> VNĐ</span>
                        </div>
                    </div>
                    <input type="hidden" name="final_total_amount" value="<?= $totalPrice + 20000 ?>">
                </div>
            </div>
            </form>

        </div>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
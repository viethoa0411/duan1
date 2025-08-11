<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng của bạn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>
    <?php
    require_once PATH_ROOT . 'views/clients/layouts/header.php';
    ?>
    <div class="container-custom">
        <h1 class="cart-title">Giỏ hàng của bạn</h1>

        <?php if (empty($cartItems)): ?>
            <div class="empty-cart-container">
                <i class="bi bi-cart-x-fill"></i>
                <p>Giỏ hàng của bạn đang trống.</p>
                <a href="<?= BASE_URL ?>index.php" class="btn btn-primary mt-3">
                    <i class="bi bi-shop me-2"></i>Tiếp tục mua sắm
                </a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th style="width: 5%;"></th>
                        <th style="width: 20%;">Sản phẩm</th>
                        <th class="text-center" style="width: 15%;">Hình ảnh</th>
                        <th class="text-end" style="width: 15%;">Giá</th>
                        <th class="text-center" style="width: 15%;">Số lượng</th>
                        <th class="text-end" style="width: 15%;">Thành tiền</th>
                        <th class="text-center" style="width: 15%;">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totalPrice = 0;
                    foreach ($cartItems as $item):
                        $subtotal = $item['price_sale'] * $item['quantity'];
                        $totalPrice += $subtotal;
                    ?>
                        <tr>
                            <td class="text-center">
                                <input type="checkbox" class="product-checkbox" data-price="<?= $subtotal ?>" name="selected_products[]" value="<?= $item['cart_id'] ?>" form="checkout_form" checked>
                            </td>
                            <td>
                                <?= $item['product_name']; ?>
                                <br>
                                <small class="text-muted">Size: <?= $item['size_name']; ?>, Màu: <?= $item['color_name']; ?></small>
                            </td>
                            <td class="text-center">
                                <?php
                                $imageSrc = BASE_URL . 'admin/' . ltrim($item['product_image'], '/');
                                ?>
                                <img src="<?= $imageSrc; ?>" alt="<?= $item['product_name']; ?>" class="cart-item-image">
                            </td>
                            <td class="text-end"><?= number_format($item['price_sale'], 0, ',', '.'); ?> VNĐ</td>
                            <td class="text-center">
                                <form action="<?= BASE_URL ?>?act=update-cart" method="POST" style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <input type="hidden" name="cart_id" value="<?= $item['cart_id']; ?>">
                                    <input
                                        type="number"
                                        name="quantity"
                                        value="<?= $item['quantity']; ?>"
                                        min="1"
                                        max="<?= $item['stock']; ?>"
                                        style="width: 70px; padding: 6px 10px; border: 1px solid #ccc; border-radius: 6px; text-align: center; font-size: 14px;">
                                    <button
                                        type="submit"
                                        title="Cập nhật số lượng"
                                        style="background-color: #198754; color: white; border: none; padding: 6px 10px; border-radius: 6px; cursor: pointer;">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </form>
                            </td>
                            <td class="text-end"><?= number_format($subtotal, 0, ',', '.'); ?> VNĐ</td>
                            <td class="text-center">
                                <a href="<?= BASE_URL ?>?act=remove-from-cart&cart_id=<?= $item['cart_id']; ?>" class="remove-button" title="Xóa sản phẩm">
                                    <i class="bi bi-trash-fill"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary-section">
                <div class="cart-summary-box">
                    <div class="summary-row">
                        <span class="summary-label">Tổng thanh toán:</span>
                        <?php $finalTotalPrice = $totalPrice ?>
                        <span id="totalPrice" class="summary-total-price">
                            <?= number_format($finalTotalPrice, 0, ',', '.'); ?> VNĐ
                        </span>

                    </div>
                </div>
            </div>

            <div class="cart-action-buttons">
                <a href="<?= BASE_URL ?>index.php" class="btn-custom btn-continue-shopping">
                    <i class="bi bi-arrow-left me-2"></i>Tiếp tục mua sắm
                </a>
                <form id="checkout_form" action="<?= BASE_URL ?>?act=cart-to-checkout" method="POST" style="flex-grow: 1;">
                    <button type="submit" class="btn-custom btn-checkout">
                        Tiến hành đặt hàng
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <?php
    require_once PATH_ROOT . 'views/clients/layouts/footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function formatCurrency(number) {
            return new Intl.NumberFormat('vi-VN', {
                style: 'currency',
                currency: 'VND'
            }).format(number);
        }

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.product-checkbox').forEach(cb => {
                if (cb.checked) {
                    total += parseFloat(cb.dataset.price);
                }
            });
            const totalEl = document.getElementById('totalPrice');
            if (totalEl) {
                totalEl.textContent = formatCurrency(total);
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Lắng nghe checkbox thay đổi để cập nhật tổng
            document.querySelectorAll('.product-checkbox').forEach(cb => {
                cb.addEventListener('change', updateTotal);
            });

            // Cập nhật tổng lần đầu khi tải trang
            updateTotal();
        });
    </script>

    <style>
        /* ... CSS của bạn ... */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        .container-custom {
            width: 90%;
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1.cart-title {
            font-size: 2.5em;
            color: #333;
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            padding-bottom: 15px;
        }

        h1.cart-title::after {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background-color: #007bff;
            border-radius: 5px;
        }

        .cart-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
            overflow: hidden;
            border-radius: 8px;
            border: 1px solid #dee2e6;
        }

        .cart-table th,
        .cart-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        .cart-table th {
            background-color: #e9ecef;
            font-weight: bold;
            color: #495057;
            text-transform: uppercase;
            font-size: 0.9em;
        }

        .cart-table tbody tr:last-child td {
            border-bottom: none;
        }

        .cart-table td.text-center {
            text-align: center;
        }

        .cart-table td.text-end {
            text-align: right;
        }

        .cart-item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .quantity-control input {
            width: 60px;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            text-align: center;
            font-size: 1em;
            -moz-appearance: textfield;
        }

        .quantity-control input::-webkit-outer-spin-button,
        .quantity-control input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .quantity-control button {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .quantity-control button:hover {
            background-color: #218838;
        }

        .remove-button {
            padding: 8px 12px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .remove-button:hover {
            background-color: #c82333;
        }

        .cart-summary-section {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .cart-summary-box {
            width: 100%;
            max-width: 400px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 25px;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .summary-label {
            font-size: 1.1em;
            color: #555;
            font-weight: bold;
        }

        .summary-value {
            font-size: 1.1em;
            color: #333;
            font-weight: bold;
        }

        .summary-total-price {
            font-size: 1.8em;
            color: #dc3545;
            font-weight: bold;
        }

        .cart-action-buttons {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            margin-top: 30px;
        }

        /* Chỉnh sửa chính */
        .cart-action-buttons a,
        .cart-action-buttons form {
            flex: 1;
            /* Cả hai phần tử con trực tiếp đều có chiều rộng bằng nhau */
        }

        .cart-action-buttons .btn-custom {
            padding: 15px 20px;
            font-size: 1.1em;
            border-radius: 8px;
            text-decoration: none;
            text-align: center;
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
            width: 100%;
            /* Đảm bảo nút bên trong form chiếm toàn bộ chiều rộng */
        }

        .btn-continue-shopping {
            background-color: #6c757d;
            color: white;
            border: 1px solid #6c757d;
        }

        .btn-continue-shopping:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-checkout {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .btn-checkout:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .empty-cart-container {
            text-align: center;
            padding: 50px;
            background-color: #e9ecef;
            border-radius: 8px;
            margin-top: 30px;
            color: #6c757d;
            font-size: 1.2em;
        }

        .empty-cart-container .bi {
            font-size: 4em;
            margin-bottom: 20px;
            color: #adb5bd;
        }

        @media (max-width: 768px) {
            .container-custom {
                width: 95%;
                margin: 20px auto;
                padding: 15px;
            }

            h1.cart-title {
                font-size: 2em;
                margin-bottom: 30px;
            }

            .cart-table th,
            .cart-table td {
                padding: 10px;
                font-size: 0.9em;
            }

            .cart-item-image {
                width: 70px;
                height: 70px;
            }

            .quantity-control input {
                width: 50px;
                padding: 6px;
            }

            .quantity-control button,
            .remove-button {
                padding: 6px 10px;
                font-size: 0.8em;
            }

            .cart-action-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .cart-action-buttons .btn-custom {
                padding: 12px 15px;
                font-size: 1em;
            }

            .cart-summary-section {
                justify-content: center;
            }

            .cart-summary-box {
                max-width: 100%;
            }
        }
    </style>
</body>

</html>
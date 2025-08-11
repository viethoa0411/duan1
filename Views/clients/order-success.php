<?php
require_once './core/function.php'; // Kết nối DB nếu cần

$orderId = $_SESSION['last_order_id'] ?? null;
$order_code = '';
$order = [];

if ($orderId) {
    $stmt = $conn->prepare("SELECT * FROM orders WHERE id = ?");
    $stmt->execute([$orderId]);
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($order) {
        $order_code = $order['order_code'] ?? '';
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #f5f5f5;
        }

        .order-success-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .order-success-box {
            background-color: #fff;
            padding: 40px 50px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 100%;
        }

        .order-success-box .bi {
            font-size: 5rem;
            color: #00bfa5;
            margin-bottom: 20px;
        }

        .order-success-box h1 {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 15px;
        }

        .order-success-box p {
            font-size: 1.1rem;
            color: #666;
            line-height: 1.6;
        }

        .order-success-box .order-code {
            font-size: 1.2rem;
            color: #333;
            margin-bottom: 25px;
        }

        .order-success-box .btn-group {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 25px;
        }

        .btn-primary-custom {
            background-color: #00bfa5;
            border-color: #00bfa5;
            color: #fff;
            padding: 12px 25px;
            font-size: 1rem;
            font-weight: bold;
            border-radius: 6px;
        }

        .btn-primary-custom:hover {
            background-color: #00a490;
            border-color: #00a490;
        }

        .btn-outline-secondary-custom {
            color: #6c757d;
            border-color: #6c757d;
            padding: 12px 25px;
            font-size: 1rem;
            border-radius: 6px;
        }

        .btn-outline-secondary-custom:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <?php require_once 'views/clients/layouts/header.php'; ?>
    <div class="container order-success-container">
        <div class="order-success-box">
            <i class="bi bi-check-circle-fill"></i>
            <h1>Đặt hàng thành công!</h1>
            <p>
                Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi. Đơn hàng của bạn đang được xử lý. Bạn có thể kiểm tra chi tiết đơn hàng hoặc tiếp tục mua sắm.
            </p>
            <div class="btn-group">
                <a href="<?= BASE_URL . '?act=detailorder&id=' . $orderId ?>" class="btn btn-outline-secondary-custom">
                    Xem chi tiết đơn hàng
                </a>

                <a href="<?= BASE_URL ?>" class="btn btn-primary-custom">
                    Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
    <?php require_once 'views/clients/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
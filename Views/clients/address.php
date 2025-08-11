<?php
// Nếu bạn muốn lấy thông tin cũ của user từ DB, có thể query tại đây
// Ví dụ: $user = getUserInfo($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Địa chỉ nhận hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .checkout-container {
            max-width: 600px;
            margin: 50px auto;
        }
        .checkout-box {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container checkout-container">
    <h2 class="mb-4 text-center text-primary">
        <a href="<?= BASE_URL . '?act=address' ?>"></a>
        <i class="bi bi-geo-alt-fill"></i> Địa chỉ nhận hàng
    </h2>

    <div class="checkout-box">
        <form action="<?= BASE_URL ?>?act=save-address" method="POST">
            <!-- Họ và tên -->
            <div class="mb-3">
                <label for="fullname" class="form-label fw-bold">Họ và tên <span class="text-danger">*</span></label>
                <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Nhập họ và tên" required>
            </div>

            <!-- Số điện thoại -->
            <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Số điện thoại <span class="text-danger">*</span></label>
                <input type="tel" name="phone" id="phone" class="form-control" placeholder="Nhập số điện thoại" pattern="[0-9]{10}" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Nhập email (không bắt buộc)">
            </div>

            <!-- Địa chỉ -->
            <div class="mb-3">
                <label for="address" class="form-label fw-bold">Địa chỉ nhận hàng <span class="text-danger">*</span></label>
                <input type="text" name="address" id="address" class="form-control" placeholder="Số nhà, tên đường, phường/xã" required>
            </div>

            <!-- Tỉnh/Thành phố -->
            <div class="mb-3">
                <label for="city" class="form-label fw-bold">Tỉnh/Thành phố <span class="text-danger">*</span></label>
                <select name="city" id="city" class="form-select" required>
                    <option value="">-- Chọn Tỉnh/Thành phố --</option>
                    <option value="Hà Nội">Hà Nội</option>
                    <option value="TP. Hồ Chí Minh">TP. Hồ Chí Minh</option>
                    <option value="Đà Nẵng">Đà Nẵng</option>
                    <option value="Hải Phòng">Hải Phòng</option>
                    <option value="Cần Thơ">Cần Thơ</option>
                </select>
            </div>

            <!-- Ghi chú -->
            <div class="mb-3">
                <label for="note" class="form-label fw-bold">Ghi chú</label>
                <textarea name="note" id="note" rows="3" class="form-control" placeholder="VD: Giao ngoài giờ hành chính, gọi trước khi giao..."></textarea>
            </div>

            <!-- Nút hành động -->
            <div class="d-flex justify-content-between">
                <a href="<?= BASE_URL ?>?act=cart" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Quay lại giỏ hàng
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle-fill"></i> Xác nhận địa chỉ
                </button>
            </div>
        </form>
    </div>
</div>

</body>
</html>

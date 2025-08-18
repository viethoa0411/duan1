<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Shop Quần Áo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<style>
    .table-lg td, .table-lg th {
        padding: 1rem 1.2rem; /* tăng padding */
        font-size: 1.1rem;    /* chữ to hơn */
    }

</style>


<body>
    <?php require_once './views/clients/layouts/header.php' ?>

    <div class="container py-5">
        <h2 class="mb-4 text-center text-uppercase fw-bold">Lịch sử mua hàng</h2>

        <?php if (!empty($orders)) : ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered align-middle shadow-sm table-lg">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Mã đơn hàng</th>
                            <th>Ngày đặt</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($orders as $item): ?>
                            <tr class="text-center">
                                <td class="fw-bold"><?= htmlspecialchars($item['order_code']) ?></td>
                                <td><?= date('H:i d/m/Y', strtotime($item['order_date'])) ?></td>
                                <td class="text-danger fw-semibold">
                                    <?= number_format($item['total_amount'], 0, ',', '.') ?>đ
                                </td>
                                <td>
                                    <?php
                                    $status = strtolower($item['status_name']);
                                    $badgeClass = 'secondary';
                                    $icon = 'fa-clock'; // default

                                    if (strpos($status, 'chờ') !== false) {
                                        $badgeClass = 'warning';
                                        $icon = 'fa-hourglass-half';
                                    } elseif (strpos($status, 'đang') !== false) {
                                        $badgeClass = 'info';
                                        $icon = 'fa-truck';
                                    } elseif (strpos($status, 'thành công') !== false || strpos($status, 'hoàn thành') !== false) {
                                        $badgeClass = 'success';
                                        $icon = 'fa-check-circle';
                                    } elseif (strpos($status, 'hủy') !== false) {
                                        $badgeClass = 'danger';
                                        $icon = 'fa-times-circle';
                                    }
                                    ?>
                                    <span class="badge bg-<?= $badgeClass ?>">
                                        <i class="fa <?= $icon ?>"></i> <?= htmlspecialchars($item['status_name']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= BASE_URL . '?act=detailorder&id=' . $item['id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="fa fa-eye"></i> Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else : ?>
            <div class="alert alert-info text-center">
                Bạn chưa có đơn hàng nào.
            </div>
        <?php endif; ?>
    </div>


    <?php require_once './views/clients/layouts/footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
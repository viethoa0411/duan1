<?php require_once './views/clients/layouts/header.php' ?>

<div class="container py-5">
    <h2 class="mb-4 text-center text-uppercase fw-bold">Lịch sử mua hàng</h2>

    <?php if (!empty($orders)) : ?>
        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle shadow">
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
                            <td><?= date('d/m/Y', strtotime($item['order_date'])) ?></td>
                            <td class="text-danger fw-semibold"><?= number_format($item['total_amount'], 0, ',', '.') ?>đ</td>
                            <td>
                                <?php
                                $status = strtolower($item['status_name']);
                                $badgeClass = 'secondary';

                                if (strpos($status, 'chờ') !== false) {
                                    $badgeClass = 'warning';
                                } elseif (strpos($status, 'đang') !== false) {
                                    $badgeClass = 'info';
                                } elseif (strpos($status, 'hoàn thành') !== false || strpos($status, 'thành công') !== false) {
                                    $badgeClass = 'success'; // xanh lá
                                } elseif (strpos($status, 'hủy') !== false) {
                                    $badgeClass = 'danger';
                                }
                                ?>
                                <span class="badge bg-<?= $badgeClass ?>">
                                    <?= htmlspecialchars($item['status_name']) ?>
                                </span>

                            </td>
                            <td>
                                <a href="<?= BASE_URL . '?act=detailorder&id=' . $item['id'] ?>" class="btn btn-sm btn-primary">
                                    Xem chi tiết
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
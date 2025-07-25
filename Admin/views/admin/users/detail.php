<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">
            <div class="col py-3">
                <h2>Chi tiết người dùng</h2>

                <?php if (!empty($user)): ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>ID</th>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                        </tr>
                        <tr>
                            <th>Tên người dùng</th>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                        </tr>
                        <tr>
                            <th>SĐT</th>
                            <td><?= htmlspecialchars($user['phone']) ?></td>
                        </tr>
                        <tr>
                            <th>Địa chỉ</th>
                            <td><?= htmlspecialchars($user['address']) ?></td>
                        </tr>
                        <tr>
                            <th>Quyền</th>
                            <td><?= htmlspecialchars($user['role_name'] ?? 'Không xác định') ?></td>
                        </tr>
                        <tr>
                            <th>Ngày tạo</th>
                            <td><?= htmlspecialchars($user['created_at'] ?? 'Không rõ') ?></td>
                        </tr>
                        <tr>
                            <th>Ngày cập nhật</th>
                            <td><?= htmlspecialchars($user['updated_at'] ?? 'Không rõ') ?></td>
                        </tr>
                    </table>
                <?php else: ?>
                    <div class="alert alert-warning">Không tìm thấy người dùng.</div>
                <?php endif; ?>

                <a href="<?= BASE_URL_ADMIN . '?act=users' ?>" class="btn btn-secondary mt-3">Quay lại danh sách</a>
            </div>
        </main>
    </div>
</div>

<?php include './views/admin/layouts/footer.php'; ?>

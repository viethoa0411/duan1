<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">

            <!-- Main content -->
            <div class="col py-3">
                <h2>Danh sách tài khoản quản trị</h2>
                <a href="<?= BASE_URL_ADMIN . '?act=accounts/add' ?>" class="btn btn-success mb-3">Thêm quản trị viên</a>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên quản trị </th>
                            <th>Email</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php if (!empty($accounts)): ?>
                                <?php foreach ($accounts as $account): ?>
                        <tr>
                            <td><?= htmlspecialchars($account['name']) ?></td>
                            <td><?= htmlspecialchars($account['email']) ?></td>
                            <td>
                                <?php if ($account['status'] == 1): ?>
                                    <span class="badge bg-success">Hoạt động</span>
                                <?php else: ?>
                                    <span class="badge bg-secondary">Không hoạt động</span>
                                <?php endif; ?>

                            </td>
                            <td><a href="<?= BASE_URL_ADMIN . '?act=accounts/detail&id=' . $account['id'] ?>" class="btn btn-primary btn-sm">Xem</a>
                            
                                <a href="<?= BASE_URL_ADMIN . '?act=accounts/toggleStatus&id=' . $account['id'] ?>"
                                    class="btn btn-warning btn-sm"
                                    onclick="return confirm('Bạn có chắc chắn muốn thay đổi trạng thái tài khoản này không?');">
                                    <?= $account['status'] == 1 ? 'Xóa quyền' : 'Kích hoạt'; ?>
                                </a>

                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Không có người dùng nào.</td>
                    </tr>
                <?php endif; ?>
                </tr>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
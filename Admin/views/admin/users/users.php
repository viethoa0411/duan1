<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">

        <!-- Main content -->
            <div class="col py-3">
                <h2>Danh sách khách hàng</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Tên khách hàng</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['phone'])?></td>
                                        <td><a href="<?= BASE_URL_ADMIN . '?act=users/detail&id=' . $user['id']?>"  class="btn btn-primary btn-sm">Xem</a></td>

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



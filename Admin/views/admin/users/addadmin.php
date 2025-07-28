<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div>
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <main class="content">
            <div class="container mt-5">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Thêm tài khoản Quản trị</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form action="<?=BASE_URL_ADMIN . '?act=add/admin'?>" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ tên</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($old['name'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($old['phone'] ?? '') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea class="form-control" id="address" name="address" rows="2"><?= htmlspecialchars($old['address'] ?? '') ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Thêm tài khoản</button>
                            <a href="<?= BASE_URL_ADMIN ?>?act=accounts" class="btn btn-secondary">Quay lại</a>
                        </form>
                    </div>
                </div>


        </main>


    </div>
</div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
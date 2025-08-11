<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin tài khoản</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .avatar-container {
            text-align: center;
        }

        .avatar-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
        }
    </style>
</head>

<body class="bg-light">
    <?php require_once PATH_ROOT . 'views/clients/layouts/header.php'; ?>

    <div class="container my-5">
        <h2 class="mb-4">Thông tin khách hàng</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <div class="card p-4">
            <div class="row">
                <div class="col-md-4 avatar-container">
                    <img src="<?= BASE_URL ?>public/images/default-avatar.png" class="avatar-img mb-3" alt="Avatar">
                    <h4><?= $user['name'] ?></h4>
                    <p>
                        <button id="show_change_password_btn" class="btn btn-sm btn-outline-primary mt-2">
                            Đổi mật khẩu
                        </button>
                    </p>
                </div>

                <div class="col-md-8">
                    <div id="profile_form_container">
                        <form action="<?= BASE_URL . '?act=post_update_profile' ?>" method="POST">
                            <h4 class="mb-3">Cập nhật thông tin</h4>
                            <div class="mb-3">
                                <label for="name" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= $user['phone'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea class="form-control" id="address" name="address" rows="3" required><?= $user['address'] ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                        </form>
                    </div>

                    <div id="change_password_form_container" class="d-none">
                        <form action="<?= BASE_URL . '?act=post_change_password' ?>" method="POST">
                            <h4 class="mb-3">Đổi mật khẩu</h4>
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Mật khẩu cũ</label>
                                <input type="password" name="old_password" id="old_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Mật khẩu mới</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Xác nhận mật khẩu mới</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Đổi mật khẩu</button>
                            <button type="button" id="cancel_change_password_btn" class="btn btn-secondary">Hủy</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once PATH_ROOT . 'views/clients/layouts/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const profileForm = document.getElementById('profile_form_container');
        const changePasswordForm = document.getElementById('change_password_form_container');
        const showChangePasswordBtn = document.getElementById('show_change_password_btn');
        const cancelChangePasswordBtn = document.getElementById('cancel_change_password_btn');

        showChangePasswordBtn.addEventListener('click', () => {
            profileForm.classList.add('d-none');
            changePasswordForm.classList.remove('d-none');
        });

        cancelChangePasswordBtn.addEventListener('click', () => {
            profileForm.classList.remove('d-none');
            changePasswordForm.classList.add('d-none');
        });
    </script>
</body>

</html>
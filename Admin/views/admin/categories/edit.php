<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <div class="col p-0">
            <!-- Header -->
            <div class="bg-primary text-white py-3 px-4">
                <h4 class="mb-0">✏️ Chỉnh sửa danh mục</h4>
            </div>

            <!-- Body -->
            <div class="p-4">
                <form action="<?= BASE_URL_ADMIN . '?act=categories/update' ?>" method="POST">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($category['id']) ?>">

                    <!-- Tên danh mục -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Tên danh mục <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name"
                            class="form-control"
                            value="<?= htmlspecialchars($category['name']) ?>" required>
                    </div>

                    <!-- Mô tả -->
                    <div class="mb-3">
                        <label for="description" class="form-label fw-semibold">Mô tả</label>
                        <textarea name="description" id="description"
                            class="form-control" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
                    </div>

                    <!-- Nút hành động -->
                    <div class="d-flex justify-content-between">
                        <a href="<?= BASE_URL_ADMIN . '?act=categories' ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left-circle"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-success" name="update_category">
                            <i class="bi bi-save"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
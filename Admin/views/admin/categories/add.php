<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <div class="col py-3">
            <div class="container mt-4 d-flex justify-content-center">
                <div class="card shadow-lg border-0 w-50">
                    <div class="card-header bg-primary text-white text-center">
                        <h4><i class="bi bi-folder-plus"></i> Thêm danh mục mới</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="<?= BASE_URL_ADMIN . '?act=categories/add' ?>" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label fw-bold">Tên danh mục <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên danh mục" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label fw-bold">Mô tả</label>
                                <textarea name="description" id="description" class="form-control" rows="4" placeholder="Nhập mô tả (không bắt buộc)"></textarea>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="<?= BASE_URL_ADMIN . '?act=categories' ?>" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left-circle"></i> Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Thêm mới
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
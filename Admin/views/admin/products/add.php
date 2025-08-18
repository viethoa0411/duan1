<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">
            <div class="col p-0">
                <div class="bg-success text-white py-3 px-4 d-flex align-items-center">
                    <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i> Thêm sản phẩm mới</h4>
                </div>

                <form action="?act=add/products" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="row g-4">

                        <!-- Tên sản phẩm -->
                        <div class="col-lg-6">
                            <label class="form-label fw-semibold">Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <!-- Giá -->
                        <div class="col-lg-3">
                            <label class="form-label fw-semibold">Giá</label>
                            <input type="number" name="price" class="form-control" min="0" required>
                        </div>

                        <!-- Giá khuyến mãi -->
                        <div class="col-lg-3">
                            <label class="form-label fw-semibold">Giá khuyến mãi</label>
                            <input type="number" name="price_sale" class="form-control" min="0">
                        </div>

                        <!-- Danh mục -->
                        <div class="col-lg-3">
                            <label class="form-label fw-semibold">Danh mục</label>
                            <select name="category_id" class="form-select" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php foreach ($categories as $category): ?>
                                    <option value="<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Mô tả -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Mô tả</label>
                            <textarea name="description" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold"> Ảnh sản phẩm</label>
                            <input type="file" name="image" class="form-control">
                        </div>

                        <!-- Ảnh sản phẩm -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Album ảnh sản phẩm</label>
                            <input type="file" name="image_list[]" accept="image/*" multiple class="form-control">
                        </div>
                    </div>

                    <!-- Nút -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="<?= BASE_URL_ADMIN . '?act=products' ?>" class="btn btn-outline-secondary me-2">
                            Quay lại
                        </a>
                        <button type="submit" name="add_product" class="btn btn-success">
                            Thêm sản phẩm
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>


<?php include './views/admin/layouts/footer.php'; ?>
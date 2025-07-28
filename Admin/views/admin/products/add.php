<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">

            <!-- Main content -->
            <div class="col py-3">
                <div class="container mt-4 d-flex justify-content-center">
                    <div class="card shadow-lg border-0 w-75">
                        <div class="card-header bg-success text-white text-center">
                            <h4><i  class="bi bi-box-seam me-2"></i> Thêm sản phẩm mới</h4>
                        </div>
                        <div class="card-body p-4">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                            <?php endif; ?>

                            <form action="?act=add/products" method="POST" enctype="multipart/form-data">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên sản phẩm" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="price" class="form-label fw-bold">Giá <span class="text-danger">*</span></label>
                                        <input type="number" name="price" id="price" class="form-control" placeholder="VD: 250000" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="price_sale" class="form-label fw-bold">Giá khuyến mãi</label>
                                        <input type="number" name="price_sale" id="price_sale" class="form-control" placeholder="VD: 200000">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="quantity" class="form-label fw-bold">Số lượng <span class="text-danger">*</span></label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" required>
                                    </div>
                                    <div class="col-md-9">
                                        <label for="description" class="form-label fw-bold">Mô tả <span class="text-danger">*</span></label>
                                        <textarea name="description" id="description" rows="2" class="form-control" placeholder="Mô tả sản phẩm..." required></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="image_list" class="form-label fw-bold">Ảnh sản phẩm (tối đa 10 ảnh):</label>
                                        <input type="file" name="image_list[]" id="image_list" accept="image/*" multiple class="form-control" onchange="previewImages(event)">
                                        <div id="image-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                        <select name="category_id" id="category_id" class="form-select" required>
                                            <option value="">-- Chọn danh mục --</option>
                                            <?php if (!empty($categories)) foreach ($categories as $category): ?>
                                                <option value="<?= htmlspecialchars($category['id']) ?>">
                                                    <?= htmlspecialchars($category['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="<?= BASE_URL_ADMIN . '?act=products' ?>" class="btn btn-secondary me-2">
                                        <i class="bi bi-arrow-left-circle"></i> Quay lại
                                    </a>
                                    <button type="submit" name="add_product" class="btn btn-success">
                                        <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <script>
                    function previewImages(event) {
                        const files = event.target.files;
                        const previewContainer = document.getElementById("image-preview");
                        previewContainer.innerHTML = "";

                        for (let i = 0; i < files.length; i++) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const img = document.createElement("img");
                                img.src = e.target.result;
                                img.className = "rounded border";
                                img.style.width = "100px";
                                img.style.height = "100px";
                                img.style.objectFit = "cover";
                                previewContainer.appendChild(img);
                            }
                            reader.readAsDataURL(files[i]);
                        }
                    }
                </script>

            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
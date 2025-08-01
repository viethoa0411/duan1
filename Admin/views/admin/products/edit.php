<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">

            <!-- Main content -->
            <div class="col p-0">
                <!-- Tiêu đề -->
                <div class="bg-warning text-dark py-3 px-4">
                    <h4 class="mb-0"><i class="bi bi-pencil-square"></i> Sửa sản phẩm</h4>
                </div>

                <!-- Nội dung form -->
                <div class="p-4">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL_ADMIN . '?act=products/update' ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
                        <input type="hidden" name="old_image_list" value='<?= htmlspecialchars($product['image_list']) ?>'>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($product['name']) ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label for="category_id" class="form-label fw-bold">Danh mục <span class="text-danger">*</span></label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    <option value="">-- Chọn danh mục --</option>
                                    <?php foreach ($listCategory as $cat): ?>
                                        <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="price" class="form-label fw-bold">Giá <span class="text-danger">*</span></label>
                                <input type="number" name="price" id="price" class="form-control" value="<?= htmlspecialchars($product['price']) ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label for="quantity" class="form-label fw-bold">Số lượng <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="quantity" class="form-control" value="<?= htmlspecialchars($product['quantity']) ?>" required>
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">Mô tả <span class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" rows="2"><?= htmlspecialchars($product['description']) ?></textarea>
                            </div>

                            <!-- Ảnh sản phẩm -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold">Ảnh sản phẩm (ảnh đầu tiên là ảnh đại diện):</label>
                                <?php
                                $imageList = !empty($product['image_list']) ? json_decode($product['image_list'], true) : [];
                                if (is_array($imageList) && count($imageList) > 0):
                                ?>
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        <?php foreach ($imageList as $index => $img): ?>
                                            <div class="text-center">
                                                <img src="<?= htmlspecialchars($img) ?>" width="80" height="80" class="rounded border" style="object-fit:cover;">
                                                <?php if ($index === 0): ?>
                                                    <small class="text-success d-block mt-1">Ảnh đại diện</small>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <input type="file" name="image_list[]" id="image_list" class="form-control" multiple onchange="previewImages(event)">
                                <small class="text-muted">Chọn ảnh mới nếu muốn thay thế. Ảnh đầu tiên được chọn sẽ là ảnh đại diện.</small>
                                <div id="image-preview" class="mt-2 d-flex flex-wrap gap-2"></div>
                            </div>
                        </div>

                        <!-- Nút -->
                        <div class="d-flex justify-content-end mt-4">
                            <a href="<?= BASE_URL_ADMIN . '?act=products' ?>" class="btn btn-secondary me-2">
                                <i class="bi bi-arrow-left-circle"></i> Quay lại
                            </a>
                            <button type="submit" name="update_product" class="btn btn-warning text-white">
                                <i class="bi bi-save"></i> Cập nhật
                            </button>
                        </div>
                    </form>
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
                            img.style.width = "80px";
                            img.style.height = "80px";
                            img.style.objectFit = "cover";
                            previewContainer.appendChild(img);
                        }
                        reader.readAsDataURL(files[i]);
                    }
                }
            </script>

        </main>
    </div>
</div>

<?php include './views/admin/layouts/footer.php'; ?>
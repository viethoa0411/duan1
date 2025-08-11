<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">
            <div class="col p-0">
                <!-- Tiêu đề -->
                <div class="bg-success text-white py-3 px-4 d-flex align-items-center">
                    <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i> Thêm sản phẩm mới</h4>
                </div>

                <!-- Form -->
                <form action="?act=add/products" method="POST" enctype="multipart/form-data" class="p-4">
                    <div class="row g-4">
                        
                        <!-- Tên sản phẩm -->
                        <div class="col-lg-6 col-md-12">
                            <label for="name" class="form-label fw-semibold">
                                <i class="bi bi-tag"></i> Tên sản phẩm <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="name" id="name" class="form-control form-control-lg" placeholder="Nhập tên sản phẩm" required>
                        </div>

                        <!-- Giá -->
                        <div class="col-lg-3 col-md-6">
                            <label for="price" class="form-label fw-semibold">
                                <i class="bi bi-cash-stack"></i> Giá <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="price" id="price" class="form-control form-control-lg" placeholder="VD: 250000" required>
                        </div>

                        <!-- Giá khuyến mãi -->
                        <div class="col-lg-3 col-md-6">
                            <label for="price_sale" class="form-label fw-semibold">
                                <i class="bi bi-tag-fill"></i> Giá khuyến mãi
                            </label>
                            <input type="number" name="price_sale" id="price_sale" class="form-control form-control-lg" placeholder="VD: 200000">
                        </div>

                        <!-- Số lượng -->
                        <div class="col-lg-3 col-md-6">
                            <label for="quantity" class="form-label fw-semibold">
                                <i class="bi bi-stack"></i> Số lượng <span class="text-danger">*</span>
                            </label>
                            <input type="number" name="quantity" id="quantity" class="form-control form-control-lg" required>
                        </div>

                        <!-- Danh mục -->
                        <div class="col-lg-3 col-md-6">
                            <label for="category_id" class="form-label fw-semibold">
                                <i class="bi bi-list-ul"></i> Danh mục <span class="text-danger">*</span>
                            </label>
                            <select name="category_id" id="category_id" class="form-select form-select-lg" required>
                                <option value="">-- Chọn danh mục --</option>
                                <?php if (!empty($categories)) foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['id']) ?>">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Trạng thái -->
                        <div class="col-lg-3 col-md-6">
                            <label for="status" class="form-label fw-semibold">
                                <i class="bi bi-toggle-on"></i> Trạng thái
                            </label>
                            <select name="status" id="status" class="form-select form-select-lg">
                                <option value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                        </div>

                        <!-- Mô tả -->
                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold">
                                <i class="bi bi-card-text"></i> Mô tả <span class="text-danger">*</span>
                            </label>
                            <textarea name="description" id="description" rows="3" class="form-control form-control-lg" placeholder="Mô tả sản phẩm..." required></textarea>
                        </div>

                        <!-- Ảnh sản phẩm -->
                        <div class="col-12">
                            <label for="image_list" class="form-label fw-semibold">
                                <i class="bi bi-images"></i> Ảnh sản phẩm (tối đa 10 ảnh)
                            </label>
                            <input type="file" name="image_list[]" id="image_list" accept="image/*" multiple class="form-control form-control-lg" onchange="previewImages(event)">
                            <div id="image-preview" class="mt-3 d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>

                    <!-- Nút -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="<?= BASE_URL_ADMIN . '?act=products' ?>" class="btn btn-outline-secondary btn-lg me-2">
                            <i class="bi bi-arrow-left-circle"></i> Quay lại
                        </a>
                        <button type="submit" name="add_product" class="btn btn-success btn-lg shadow-sm">
                            <i class="bi bi-plus-circle"></i> Thêm sản phẩm
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<!-- Preview ảnh + Kiểm tra giá -->
<script>
function previewImages(event) {
    const files = event.target.files;
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    if (files.length > 10) {
        alert('Chỉ được chọn tối đa 10 ảnh!');
        event.target.value = '';
        return;
    }
    Array.from(files).forEach(file => {
        const reader = new FileReader();
        reader.onload = e => {
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.width = '120px';
            img.style.height = '120px';
            img.classList.add('rounded', 'border');
            preview.appendChild(img);
        };
        reader.readAsDataURL(file);
    });
}

document.getElementById('price_sale').addEventListener('input', function () {
    const price = parseFloat(document.getElementById('price').value) || 0;
    const sale = parseFloat(this.value) || 0;
    if (sale > price) {
        alert('Giá khuyến mãi không được lớn hơn giá gốc!');
        this.value = '';
    }
});
</script>

<?php include './views/admin/layouts/footer.php'; ?>

<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">
            <div class="col p-0">
                <div class="bg-success text-white py-3 px-4 d-flex align-items-center">
                    <h4 class="mb-0"><i class="bi bi-box-seam me-2"></i> Thêm biến thể sản phẩm</h4>
                </div>

                <form action="<?= BASE_URL_ADMIN . '?act=variant/add' ?>" method="POST" enctype="multipart/form-data" class="p-4">

                    <!-- Hidden input giữ ID sản phẩm -->
                    <input type="hidden" name="id" value="<?= htmlspecialchars($products['id'] ?? '') ?>">

                    <div class="row g-4">
                        <!-- Tên sản phẩm -->
                        <div class="col-lg-12">
                            <label class="form-label fw-semibold">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" value="<?= htmlspecialchars($products['name'] ?? '') ?>" readonly>
                        </div>

                        <!-- Chọn Size -->
                        <div class="mb-3">
                            <label class="form-label">Chọn Size</label><br>
                            <?php foreach ($sizes as $size): ?>
                                <label class="me-3">
                                    <input type="checkbox" name="sizes[]" value="<?= htmlspecialchars($size['id']) ?>">
                                    <?= htmlspecialchars($size['name']) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <!-- Chọn Màu -->
                        <div class="mb-3">
                            <label class="form-label">Chọn Màu</label><br>
                            <?php foreach ($colors as $color): ?>
                                <label class="me-3">
                                    <input type="checkbox" name="colors[]" value="<?= htmlspecialchars($color['id']) ?>">
                                    <?= htmlspecialchars($color['name']) ?>
                                </label>
                            <?php endforeach; ?>
                        </div>

                        <!-- Bảng biến thể -->
                        <div class="mb-3">
                            <label class="form-label">Biến thể & số lượng</label>
                            <div id="variant-table">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            <th>Màu</th>
                                            <th>Số lượng</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- Nút -->
                    <div class="d-flex justify-content-end mt-4">
                        <a href="<?= BASE_URL_ADMIN . '?act=products' ?>" class="btn btn-outline-secondary me-2">
                            Quay lại
                        </a>
                        <button type="submit" name="add_variant" class="btn btn-success">
                            Thêm biến thể
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    const sizeCheckboxes = document.querySelectorAll('input[name="sizes[]"]');
    const colorCheckboxes = document.querySelectorAll('input[name="colors[]"]');
    const variantTableBody = document.querySelector('#variant-table tbody');

    function updateVariants() {
        variantTableBody.innerHTML = '';
        sizeCheckboxes.forEach(size => {
            if (size.checked) {
                colorCheckboxes.forEach(color => {
                    if (color.checked) {
                        variantTableBody.innerHTML += `
                        <tr>
                            <td>${size.nextSibling.textContent.trim()}</td>
                            <td>${color.nextSibling.textContent.trim()}</td>
                            <td>
                                <input type="number" name="variant_stock[${size.value}][${color.value}]" min="0" value="0" class="form-control">
                            </td>
                        </tr>
                    `;
                    }
                });
            }
        });
    }

    sizeCheckboxes.forEach(cb => cb.addEventListener('change', updateVariants));
    colorCheckboxes.forEach(cb => cb.addEventListener('change', updateVariants));
</script>

<?php include './views/admin/layouts/footer.php'; ?>
<?php require './views/clients/layouts/header.php'; ?>

<div class="container my-5">
    <div class="row">
        <!-- Breadcrumb -->
        <nav class="container mt-4" aria-label="breadcrumb">
            <ol class="breadcrumb bg-light p-2 rounded">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>">Trang chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
            </ol>
        </nav>

        <!-- Phần Ảnh -->
        <div class="col-md-5">
            <?php
            $imagePath = str_replace('uploads/products/', '', $product['image']);
            $mainImage = $product['image'] ?? 'https://via.placeholder.com/300?text=No+Image';
            $imageList = json_decode($product['image_list'] ?? '[]', true);
            ?>

            <!-- ✅ KHỐI 1: ẢNH CHÍNH + ẢNH PHỤ -->
            <div class="p-3 bg-light border rounded shadow-sm mb-4" style="max-width: 700px; margin: 0 auto;">
                <!-- Ảnh chính -->
                <img id="mainImage"
                    src="/duan1/admin/uploads/products/<?= htmlspecialchars($imagePath) ?>"
                    style="width: 100%; height: 450px; object-fit: cover;"
                    class="rounded img-fluid mb-3"
                    alt="Ảnh sản phẩm">

                <!-- Danh sách ảnh phụ -->
                <?php if (!empty($imageList)): ?>
                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                        <?php foreach ($imageList as $imgPath): ?>
                            <img src="/duan1/admin/<?= htmlspecialchars($imgPath) ?>"
                                class="img-thumbnail border"
                                style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                onclick="changeMainImage(this.src)">
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center">Không có ảnh phụ.</p>
                <?php endif; ?>
            </div>

            <!-- ✅ KHỐI 2: MÔ TẢ SẢN PHẨM -->
            <div class="p-3 bg-light border rounded shadow-sm" style="max-width: 700px; margin: 0 auto;">
                <h5 class="fw-bold">Mô tả sản phẩm</h5>
                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>
        </div>


        <!-- End Phần Ảnh -->

        <!-- Thông tin sản phẩm -->
        <div class="col-md-7 ms-auto">
            <div class="card shadow-sm p-4 rounded-4 border-0">
                <h2 class="fw-bold mb-3"><?= htmlspecialchars($product['name']) ?></h2>

                <div class="d-flex align-items-baseline mb-3 flex-wrap">
                    <?php if (!empty($product['price_sale'])): ?>
                        <!-- Có giá khuyến mãi -->
                        <p class="fw-bold fs-4 text-danger mb-0 me-3">
                            <?= number_format($product['price_sale'], 0, ',', '.') ?> VNĐ
                        </p>
                        <p class="text-decoration-line-through text-muted mb-0">
                            <?= number_format($product['price'], 0, ',', '.') ?> VNĐ
                        </p>
                    <?php else: ?>
                        <!-- Chỉ có giá gốc -->
                        <p class="fw-bold fs-4 text-dark mb-0">
                            <?= number_format($product['price'], 0, ',', '.') ?> VNĐ
                        </p>
                    <?php endif; ?>
                </div>

                <?php if (!empty($productVariants)): ?>
                    <div class="mb-4">
                        <h5 class="fw-bold">Chọn Kích Cỡ:</h5>
                        <div id="size-options" class="d-flex flex-wrap gap-2"></div>
                    </div>

                    <div class="mb-4">
                        <h5 class="fw-bold">Chọn Màu Sắc:</h5>
                        <div id="color-options" class="d-flex flex-wrap gap-2"></div>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Sản phẩm này chưa có biến thể.</div>
                <?php endif; ?>

                <form action="?act=cart_add" method="POST" class="add-to-cart-form mt-4">
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                    <input type="hidden" name="variant_id" id="selected-variant-id">

                    <div class="mb-3 d-flex align-items-center flex-wrap gap-3">
                        <label for="quantity" class="fw-semibold mb-0">Số lượng:</label>

                        <div class="input-group" style="max-width: 150px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(-1)">−</button>
                            <input type="text" id="quantity" name="quantity" value="1" readonly class="form-control text-center">
                            <button class="btn btn-outline-secondary" type="button" onclick="changeQuantity(1)">+</button>
                        </div>

                        <div id="stock-info" class="text-muted small ms-2"></div>
                    </div>


                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm" id="add-to-cart-btn" disabled>
                            <i class="bi bi-cart-plus me-2"></i>Thêm vào giỏ hàng
                        </button>
                        <a href="#" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-lightning-fill me-2"></i>Mua ngay
                        </a>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <!-- End Thông tin sản phẩm -->



<!--   Hiển thị bình luận -->
<div class="card shadow-sm rounded-2 border-1 my-5">
    <div class="card-header bg-white border-bottom-0 text-center py-2">

        <div class="fs-4 fw-bold text-center pb-3 px-5" style="width: max-content;margin: 30px auto;border-bottom: 2px solid orangered;">
            Bình luận
        </div>
        <i class="bi bi-chat-dots-fill me-2"></i>

    </div>

    <div class="card-body px-4">
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $r): ?>
                <div class="border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <strong class="text-dark"><?= htmlspecialchars($r['user_name']) ?></strong>
                        <small class="text-muted"><?= date('d/m/Y H:i', strtotime($r['create_at'])) ?></small>
                    </div>
                    <div class="text-warning mb-1">
                        <?= str_repeat('★', $r['rating']) ?>
                        <?= str_repeat('☆', 5 - $r['rating']) ?>
                    </div>
                    <p class="mb-0 text-secondary"><?= nl2br(htmlspecialchars($r['comment'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert alert-secondary text-center mb-0">
                Chưa có bình luận nào cho sản phẩm này.
            </div>
        <?php endif; ?>
    </div>
</div>

<!--  End Hiển thị bình luận -->

<!-- Sản phẩm cùng danh mục -->
<div class="card shadow-sm rounded-1 border-1 m my-5">
    <div class="card-header bg-white border-bottom-0 text-center px-3 pt-3 pb-5">

        <div class="fs-4 fw-bold text-center pb-3 px-5" style="width: max-content;margin: 30px auto;border-bottom: 2px solid orangered;">
            Sản phẩm tương tự
        </div>
        <div class="row row-cols-1 row-cols-md-4 g-4">
            <?php foreach ($relatedProducts as $related): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="/duan1/admin/<?= htmlspecialchars($related['image']) ?>"
                            class="card-img-top"
                            style="height: 300px; object-fit: cover;"
                            alt="<?= htmlspecialchars($related['name']) ?>">
                        <div class="card-body">
                            <a href="?act=detail&id=<?= $related['id'] ?>"
                                class="fw-bold text-decoration-none"
                                style="color: #212529; transition: color 0.3s;"
                                onmouseover="this.style.color='#e74c3c'"
                                onmouseout="this.style.color='#212529'">
                                <?= htmlspecialchars($product['name']) ?>
                            </a>
                            <p class="text-danger fw-semibold mb-2">
                                <?= number_format($related['price'], 0, ',', '.') ?> VNĐ
                            </p>
                            <a href="?act=detail&id=<?= $related['id'] ?>" class="btn btn-outline-primary btn-sm">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if (empty($relatedProducts)): ?>
                <p>Không có sản phẩm liên quan.</p>
            <?php endif; ?>
        </div>
        <!-- End Sản phẩm cùng danh mục -->


    </div>
</div>
</div>

<?php require './views/clients/layouts/footer.php'; ?>

<script>
    function changeQuantity(change) {
        const input = document.getElementById('quantity');
        let current = parseInt(input.value) || 1;
        current += change;
        if (current < 1) current = 1;
        input.value = current;
    }


    function changeMainImage(src) {
        const mainImage = document.getElementById('mainImage');
        if (mainImage) {
            mainImage.src = src;
        }
    }
    document.addEventListener('DOMContentLoaded', function() {
        // Biến thể sản phẩm từ PHP sang JS
        const productVariants = <?= json_encode($productVariants) ?>;

        const sizeOptionsDiv = document.getElementById('size-options');
        const colorOptionsDiv = document.getElementById('color-options');
        const stockInfo = document.getElementById('stock-info');
        const addToCartBtn = document.getElementById('add-to-cart-btn');
        const selectedVariantId = document.getElementById('selected-variant-id');
        const quantityInput = document.getElementById('quantity');

        let selectedSize = null;
        let selectedColor = null;

        if (productVariants && productVariants.length > 0) {
            // Lấy danh sách kích cỡ và màu sắc duy nhất
            const uniqueSizes = [...new Set(productVariants.map(v => v.size_name))];
            const uniqueColors = [...new Set(productVariants.map(v => v.color_name))];

            // Render các nút kích cỡ
            uniqueSizes.forEach(size => {
                const button = document.createElement('button');
                button.textContent = size;
                button.classList.add('btn', 'btn-outline-secondary');
                button.addEventListener('click', () => {
                    selectedSize = size;
                    handleSelectionChange();
                });
                sizeOptionsDiv.appendChild(button);
            });

            // Render các nút màu sắc
            uniqueColors.forEach(color => {
                const button = document.createElement('button');
                button.textContent = color;
                button.classList.add('btn', 'btn-outline-secondary');
                button.addEventListener('click', () => {
                    selectedColor = color;
                    handleSelectionChange();
                });
                colorOptionsDiv.appendChild(button);
            });
        }

        function handleSelectionChange() {
            // Cập nhật trạng thái nút (active)
            updateButtonState(sizeOptionsDiv, selectedSize);
            updateButtonState(colorOptionsDiv, selectedColor);

            if (selectedSize && selectedColor) {
                // Tìm biến thể phù hợp
                const selectedVariant = productVariants.find(v =>
                    v.size_name === selectedSize && v.color_name === selectedColor
                );

                if (selectedVariant) {
                    stockInfo.textContent = `Có sẵn: ${selectedVariant.stock}`;
                    addToCartBtn.disabled = selectedVariant.stock <= 0;
                    selectedVariantId.value = selectedVariant.variant_id;
                    quantityInput.max = selectedVariant.stock;
                    quantityInput.value = 1;
                } else {
                    stockInfo.textContent = 'Biến thể này không có sẵn.';
                    addToCartBtn.disabled = true;
                    selectedVariantId.value = '';
                    quantityInput.max = 0;
                    quantityInput.value = 1;
                }
            } else {
                stockInfo.textContent = '';
                addToCartBtn.disabled = true;
                selectedVariantId.value = '';
                quantityInput.max = null;
            }
        }

        function updateButtonState(container, selectedValue) {
            Array.from(container.children).forEach(btn => {
                if (btn.textContent === selectedValue) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }
    });
</script>

</body>

</html>
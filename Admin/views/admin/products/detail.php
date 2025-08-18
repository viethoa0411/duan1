<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">
            <div class="card shadow-sm">
                <div class="bg-success text-white p-3">
                    <h4 class="mb-0"><i class="bi bi-box"></i> Chi tiết sản phẩm</h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($product)): ?>
                        <div class="row">
                            <!-- Hình ảnh -->
                            <div class="col-md-4 text-center">
                                <?php
                                $mainImage = $product['image'] ?? 'https://via.placeholder.com/300?text=No+Image';
                                $imageList = json_decode($product['image_list'] ?? '[]', true);
                                ?>
                                <div class="mb-3 border rounded shadow-sm" style="width: 100%; height: 350px;">
                                    <img id="mainImage"
                                        src="<?= htmlspecialchars($mainImage) ?>"
                                        alt="Ảnh sản phẩm"
                                        style="width: 100%; height: 100%; object-fit: contain;">
                                </div>
                                <?php if (!empty($imageList)): ?>
                                    <div class="d-flex flex-wrap gap-2 justify-content-center">
                                        <?php foreach ($imageList as $imgPath): ?>
                                            <img src="<?= htmlspecialchars($imgPath) ?>"
                                                class="img-thumbnail"
                                                style="width: 70px; height: 70px; object-fit: cover; cursor: pointer;"
                                                onclick="changeMainImage('<?= htmlspecialchars($imgPath) ?>')">
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Thông tin -->
                            <div class="col-md-8">
                                <table class="table table-borderless">
                                    <tr>
                                        <th>ID:</th>
                                        <td><?= htmlspecialchars($product['id']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tên sản phẩm:</th>
                                        <td><?= htmlspecialchars($product['name']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Danh mục:</th>
                                        <td><?= htmlspecialchars($product['category_name'] ?? 'Chưa có') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Giá:</th>
                                        <td><?= number_format($product['price']) ?> đ</td>
                                    </tr>
                                    <tr>
                                        <th>Giá giảm:</th>
                                        <td><?= !empty($product['price_sale']) ? number_format($product['price_sale']) . ' đ' : 'Không có' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Số lượng tồn kho</th>
                                        <td><?= htmlspecialchars($totalStock) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Mô tả:</th>
                                        <td><?= nl2br(htmlspecialchars($product['description'] ?? 'không có mô tả')) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ngày tạo:</th>
                                        <td><?= htmlspecialchars($product['created_at']) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Ngày cập nhật:</th>
                                        <td><?= htmlspecialchars($product['updated_at']) ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Bảng biến thể -->
                        <?php if (!empty($variants)): ?>
                            <h5 class="mt-4">Danh sách biến thể</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>Màu</th>
                                        <th>Số lượng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($variants as $v): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($v['size_name']) ?></td>
                                            <td><?= htmlspecialchars($v['color_name']) ?></td>
                                            <td><?= htmlspecialchars($v['stock']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <!-- Nút quay lại -->
                        <a href="<?= BASE_URL_ADMIN . '?act=products' ?>" class="btn btn-secondary mt-3">
                            <i class="bi bi-arrow-left"></i> Quay lại
                        </a>

                    <?php else: ?>
                        <div class="alert alert-danger">Không tìm thấy sản phẩm.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Bình luận -->
            <div class="mt-4">
                <h5>Bình luận</h5>
                <?php if (!empty($reviews)): ?>
                    <ul class="list-group">
                        <?php foreach ($reviews as $review): ?>
                            <li class="list-group-item">
                                <strong><?= htmlspecialchars($review['user_name']) ?></strong>
                                (<?= $review['rating'] ?>/5):
                                <?= htmlspecialchars($review['comment']) ?>
                                <br>
                                <small class="text-muted"><?= htmlspecialchars($review['create_at']) ?></small>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>Chưa có bình luận nào.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</div>

<script>
    function changeMainImage(src) {
        document.getElementById('mainImage').src = src;
    }
</script>

<?php include './views/admin/layouts/footer.php'; ?>
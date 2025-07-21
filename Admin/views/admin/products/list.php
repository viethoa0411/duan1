<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <div class="col py-3">
            <h2>Danh sách sản phẩm</h2>
            <a href="<?=BASE_URL_ADMIN . '?act=formaddproduct'?>" class="btn btn-success mb-3">Thêm sản phẩm</a>
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá</th>
                    <th>Giá giảm</th>
                    <th>Số lượng</th>
                    <th>Ảnh</th>
                    <th>Ngày tạo</th>
                    <th>Ngày sửa</th>
                    <th>Hành động 1</th>
                    <th>Hành động 2</th>
                </tr>
                <tr>
                    <?php if (!empty($listProduct)): ?>
                        <?php foreach ($listProduct as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['id']) ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['price_sale']) ?></td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>

                    <td>
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Ảnh sản phẩm" width="80">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/80x80?text=No+Image" alt="Không có ảnh" width="80">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($product['created_at']) ?></td>
                    <td><?= htmlspecialchars($product['updated_at']) ?></td>
                    <td><a href="<?=BASE_URL_ADMIN . '?act=products/edit&id=' . $product['id']?>" class="btn btn-primary btn-sm">Sửa</a></td>
                    <td><a href="<?=BASE_URL_ADMIN . '?act=products/delete&id=' .$product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">Không có sản phẩm nào.</td>
            </tr>
        <?php endif; ?>
        </tr>
            </table>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
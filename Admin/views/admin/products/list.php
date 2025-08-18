<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">

            <!-- Main content -->
            <div class="col py-3">
                <h2>Danh sách sản phẩm</h2>
                <a href="<?= BASE_URL_ADMIN . '?act=formaddproduct' ?>" class="btn btn-success mb-3">Thêm sản phẩm</a>
                <form method="GET" action="">
                    <input type="hidden" name="act" value="products">
                    <div class="input-group mb-3" style="max-width: 400px;">
                        <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm sản phẩm "
                            value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                        <button type="submit" class="btn btn-outline-primary">Tìm</button>
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Giá</th>
                            <th>Giá giảm</th>
                            <th>Số lượng</th>
                            <th>Ảnh</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (!empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= htmlspecialchars($product['id']) ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['category_name'] ?? 'Chưa có danh mục') ?></td>
                                    <td><?= htmlspecialchars($product['price']) ?>đ</td>
                                    <td>
                                        <?php if (!empty($product['price_sale'])): ?>
                                            <?= htmlspecialchars($product['price_sale']) ?>đ
                                        <?php else: ?>
                                            Không có
                                        <?php endif; ?>
                                    <td><?= htmlspecialchars($product['total_stock']) ?></td>

                                    <td>

                                        <?php if (!empty($product['image'])): ?>
                                            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Ảnh sản phẩm" width="80">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/80x80?text=No+Image" alt="Không có ảnh" width="80">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= BASE_URL_ADMIN . '?act=products/detail&id=' . $product['id'] ?>" class="btn btn-primary btn-sm">Xem</a>
                                        <a href="<?= BASE_URL_ADMIN . '?act=products/edit&id=' . $product['id'] ?>" class="btn btn-warning btn-sm">Sửa</a>
                                        <a href="<?= BASE_URL_ADMIN . '?act=products/delete&id=' . $product['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                                        <a href="<?= BASE_URL_ADMIN . '?act=add/variant&id=' . $product['id'] ?>" class="btn btn-primary btn-sm">Thêm biến thể</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4" class="text-center text-danger">Không có danh mục nào</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
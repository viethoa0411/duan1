<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <div class="col py-3">
            <h2>Thêm sản phẩm mới</h2>

            <?php if (isset($error)): ?>
                <div style="color: red; margin-bottom: 10px;"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form action="<?=BASE_URL_ADMIN . '?act=add/products'?>" method="post" enctype="multipart/form-data">
                <div>
                    <label for="name">Tên sản phẩm:</label>
                    <input type="text" name="name" id="name" required>
                </div>
                <div>
                    <label for="price">Giá:</label>
                    <input type="number" name="price" id="price" required>
                </div>
                <div>
                    <label for="price_sale">Giá khuyến mãi:</label>
                    <input type="number" name="price_sale" id="price_sale">
                </div>
                <div>
                    <label for="quantity">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" required>
                </div>
                <div>
                    <label for="image">Ảnh sản phẩm:</label>
                    <input type="file" name="image" id="image">
                </div>
                <div>
                    <label for="category_id">Danh mục:</label>
                    <select name="category_id" id="category_id" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php if (!empty($listCategory)) foreach ($listCategory as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['id']) ?>">
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <button type="submit" name="add_product">Thêm sản phẩm</button>
                </div>
            </form>

        </div>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
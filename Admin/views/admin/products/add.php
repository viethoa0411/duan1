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

            <form action="<?=BASE_URL_ADMIN . '?act=add/products'?>" method="post" enctype="multipart/form-data" class="w-50">
                <div>
                    <label for="name" class="form-label">Tên sản phẩm:</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div>
                    <label for="price" class="form-label" >Giá:</label>
                    <input type="number" name="price" id="price" class="form-control" required>
                </div>
                <div>
                    <label for="price_sale" class="form-label">Giá khuyến mãi:</label>
                    <input type="number" name="price_sale" id="price_sale" class="form-control">
                </div>
                <div>
                    <label for="quantity"class="form-label">Số lượng:</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" required>
                </div>
                <div>
                    <label for="image" class="form-label">Ảnh sản phẩm:</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>
                <div>
                    <label for="category_id" class="form-label">Danh mục</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        <?php if (!empty($categories)) foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['id']) ?>">
                                <?= htmlspecialchars($category['name']) ?>
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
<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <div class="col py-3">
            <h2>Sửa sản phẩm</h2>
<?php if (isset($error)): ?>
    <div style="color: red; margin-bottom: 10px;"> <?= htmlspecialchars($error) ?> </div>
<?php endif; ?>
<form action="<?=BASE_URL_ADMIN . '?act=products/update'?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= htmlspecialchars($product['id']) ?>">
    <input type="hidden" name="old_image" value="<?= htmlspecialchars($product['image']) ?>">
    <div>
        <label for="name">Tên sản phẩm:</label>
        <input type="text" name="name" id="name" required value="<?= htmlspecialchars($product['name']) ?>">
    </div>
    <div>
        <label for="category_id">Danh mục:</label>
        <select name="category_id" id="category_id" required>
            <option value="">-- Chọn danh mục --</option>
            <?php foreach ($listCategory as $cat): ?>
                <option value="<?= htmlspecialchars($cat['id']) ?>" <?= $cat['id'] == $product['category_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($cat['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <label for="price">Giá:</label>
        <input type="number" name="price" id="price" required value="<?= htmlspecialchars($product['price']) ?>">
    </div>
    <div>
        <label for="price_sale">Giá khuyến mãi:</label>
        <input type="number" name="price_sale" id="price_sale" value="<?= htmlspecialchars($product['price_sale']) ?>">
    </div>
    <div>
        <label for="quantity">Số lượng:</label>
        <input type="number" name="quantity" id="quantity" required value="<?= htmlspecialchars($product['quantity']) ?>">
    </div>
    <div>
        <label for="image">Ảnh sản phẩm:</label>
        <?php if (!empty($product['image'])): ?>
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="Ảnh sản phẩm" width="80"><br>
        <?php endif; ?>
        <input type="file" name="image" id="image">
    </div>
    
    
    <div>
        <button type="submit" name="update_product" class="btn btn-primary">Cập nhật sản phẩm</button>
        <a href="BASE_URL_ADMIN . '?act=products'"><button class="btn btn-primary" >Quay lại</button></a>
    </div>
</form> 
        </div>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>



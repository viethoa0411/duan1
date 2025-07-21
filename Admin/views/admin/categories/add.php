<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>


        <!-- Main content -->
        <div class="col py-3">
            <h2>Thêm danh mục mới</h2>

            <form action="<?=BASE_URL_ADMIN . '?act=categories/add'?>" method="POST" class="w-50">
                <div class="mb-3">
                    <label for="name" class="form-label">Tên danh mục</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <a href="<?=BASE_URL_ADMIN . '?act=categories'?>" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>

<!-- Footer -->
<?php include './views/admin/layouts/footer.php'; ?>
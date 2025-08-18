<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>

        <main class="content">

            <!-- Main content -->
            <div class="col py-3">
                <h2>Danh sách danh mục</h2>
                <a href="<?= BASE_URL_ADMIN . '?act=formaddcategory' ?>" class="btn btn-success mb-3">Thêm danh mục</a>
                <form method="GET" action="" class="mb-3 d-flex gap-2 align-items-center" style="max-width: 400px;">
                    <input type="hidden" name="act" value="categories">
                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm danh mục" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                    <button type="submit" class="btn btn-outline-primary">Tìm</button>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($categories)) : ?>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category['id'] ?></td>
                                    <td><?= $category['name'] ?></td>
                                    <td><?= $category['description'] ?></td>
                                    <td>
                                        <a href="<?= BASE_URL_ADMIN . '?act=categories/edit&id=' . $category['id'] ?>" class="btn btn-primary btn-sm">Sửa</a>
                                        <a href="<?= BASE_URL_ADMIN . '?act=categories/delete&id=' . $category['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa danh mục này?')">Xóa</a>
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Danh sách danh mục</h2>
<a href="?controller=category&act=create" class="btn btn-success mb-3">Thêm mới</a>

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
                        <a href="?controller=category&act=edit&id=<?= $category['id'] ?>" class="btn btn-primary btn-sm">Sửa</a>
                        <a href="?controller=category&act=delete&id=<?= $category['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Xóa danh mục này?')">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr><td colspan="4" class="text-center text-danger">Không có danh mục nào</td></tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
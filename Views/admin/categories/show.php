<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Chi tiết danh mục</h2>

<table class="table table-bordered w-50">
    <tr>
        <th>ID</th>
        <td><?= $category['id'] ?></td>
    </tr>
    <tr>
        <th>Tên danh mục</th>
        <td><?=$category['name'] ?></td>
    </tr>
    <tr>
        <th>Mô tả</th>
        <td><?=$category['description']?></td>
    </tr>
</table>

<a href="?controller=category&act=edit&id=<?= $category['id'] ?>" class="btn btn-warning">Sửa</a>
<a href="?controller=category&act=dashboard" class="btn btn-secondary">Quay lại</a>

</body>
</html>
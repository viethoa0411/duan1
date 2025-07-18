<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Thêm danh mục mới</h2>

<form action="?controller=category&act=store" method="POST" class="w-50">
    <div class="mb-3">
        <label for="name" class="form-label">Tên danh mục</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Mô tả</label>
        <textarea name="description" id="description" class="form-control" rows="4"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Thêm mới</button>
    <a href="?controller=category&act=dashboard" class="btn btn-secondary">Quay lại</a>
</form>
</body>
</html>

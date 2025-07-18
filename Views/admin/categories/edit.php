<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa danh mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Chỉnh sửa danh mục</h2>
    <form action="?controller=category&act=update" method="POST" class="w-50">
        <input type="hidden" name="id" value="<?= $category['id'] ?>">
        
        <div class="mb-3">
            <label for="name" class="form-label">Tên danh mục</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Mô tả</label>
            <textarea name="description" id="description" class="form-control" rows="4"><?= htmlspecialchars($category['description']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-success">Cập nhật</button>
        <a href="?controller=category&act=index" class="btn btn-secondary">Quay lại</a>
    </form>
</div>
</body>
</html>

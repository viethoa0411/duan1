<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả tìm kiếm - Shop Quần Áo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>
<?php require 'views/clients/layouts/header.php'; ?>

<div class="container my-5">
    <h2 class="text-center mb-4">
        Kết quả tìm kiếm cho: 
        <span class="text-primary">"<?= htmlspecialchars($_GET['query'] ?? '') ?>"</span>
    </h2>

    <?php if (!empty($products)): ?>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <?php $imagePath = str_replace('uploads/products/', '', $product['image']); ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="/trang/admin/uploads/products/<?= htmlspecialchars($imagePath) ?>"  
                            style="width: 100%; height: 250px; object-fit: cover;" 
                            alt="<?= htmlspecialchars($product['name']) ?>">
                        <div class="card-body">
                            <h6>
                                <a href="index.php?act=detail&id=<?= $product['id'] ?>"
                                   class="fw-bold text-decoration-none text-dark"
                                   onmouseover="this.style.color='#e74c3c'"
                                   onmouseout="this.style.color='#212529'">
                                    <?= htmlspecialchars($product['name']) ?>
                                </a>
                            </h6>
                            <?php if (!empty($product['price_sale'])): ?>
                                <div class="fw-bold text-danger fs-5"><?= number_format($product['price_sale'], 0, ',', '.') ?> VNĐ</div>
                                <div class="text-muted text-decoration-line-through"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</div>
                            <?php else: ?>
                                <div class="fw-bold text-danger fs-5"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</div>
                            <?php endif; ?>
                            <div>
                                <strong>Danh mục:</strong> <?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center mt-4">
            <i class="fa-solid fa-circle-exclamation"></i> Không tìm thấy sản phẩm nào phù hợp.
        </div>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ
        </a>
    </div>
</div>

<?php require 'views/clients/layouts/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

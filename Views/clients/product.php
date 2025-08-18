<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Trang chủ - Shop Quần Áo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>

<body>
    <?php require 'views/clients/layouts/header.php'; ?>

    <div class="container">
        <form class="w-100" method="GET" action="">
            <input type="hidden" name="act" value="products">
            <div class="input-group shadow rounded w-100">
                <input type="text" name="keyword" class="form-control" placeholder="Nhập tên sản phẩm..."
                    value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                <button class="btn btn-primary" type="submit">Tìm</button>
            </div>
        </form>
    </div>


    <!-- Main Content -->
    <div class="container">
        <div class="fs-4 fw-bold text-center py-2 px-5" style="width: max-content;margin: 30px auto;border-bottom: 2px solid orangered;">
            Tất cả sản phẩm
        </div>
        <div class="row g-4">
            <?php foreach ($products as $product): ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm border-0">
                        <?php
                        // Tách để loại bỏ phần "uploads/products/" bị trùng (nếu có)
                        $imagePath = str_replace('uploads/products/', '', $product['image']);
                        ?>
                        <img src="/duan1/admin/uploads/products/<?= htmlspecialchars($imagePath) ?>"
                            style="width: 100%; height: 250px; object-fit: cover; display: block;" alt="Ảnh sản phẩm">
                        <div class="card-body">
                            <h6>
                                <a href=" <?= BASE_URL .   '?act=detail&id=' . $product['id'] ?>"
                                    class="fw-bold text-decoration-none"
                                    style="color: #212529; transition: color 0.3s;"
                                    onmouseover="this.style.color='#e74c3c'"
                                    onmouseout="this.style.color='#212529'">
                                    <?= htmlspecialchars($product['name']) ?>
                                </a>
                            </h6>
                            <?php if (!empty($product['price_sale'])): ?>
                                <div class="fw-bold text-danger fs-5">
                                    <?= number_format($product['price_sale'], 0, ',', '.') ?> VNĐ
                                </div>
                                <div class="text-muted text-decoration-line-through">
                                    <?= number_format($product['price'], 0, ',', '.') ?> VNĐ
                                </div>
                            <?php else: ?>
                                <div class="fw-bold text-danger fs-5">
                                    <?= number_format($product['price'], 0, ',', '.') ?> VNĐ
                                </div>
                            <?php endif; ?>

                            <div>
                                <strong>Danh mục:</strong> <?= htmlspecialchars($product['category_name'] ?? 'Chưa phân loại') ?></li>
                            </div>

                        </div>

                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
    <!-- Footer -->

    <?php require 'views/clients/layouts/footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
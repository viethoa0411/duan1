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

    <!-- Banner Carousel -->
    <div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./uploads/banner_1.png" class="d-block w-100 rounded-3" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="./uploads/banner_2.png" class="d-block w-100 rounded-3" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="./uploads/banner_3.png" class="d-block w-100 rounded-3" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="./uploads/banner_4.png" class="d-block w-100 rounded-3" alt="Banner 3">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle"></span>
            <span class="visually-hidden">Trước</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle"></span>
            <span class="visually-hidden">Tiếp</span>
        </button>
    </div>

    <div class="container">
      <form class="w-100" role="search" method="get" action="index.php">
        <input type="hidden" name="act" value="search">
        <div class="input-group shadow rounded w-100">
            <input type="text" class="form-control" name="query" placeholder="🔍 Tìm kiếm sản phẩm..." required>
            <button class="btn btn-primary" type="submit">Tìm</button>
        </div>
      </form>
      </div>


    <!-- Main Content -->
    <div class="container">
        <div class="fs-4 fw-bold text-center py-2 px-5" style="width: max-content;margin: 30px auto;border-bottom: 2px solid orangered;">
            Sản phẩm mới về
        </div>
        <div class="row g-4">
          <?php foreach ($products as $product): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="card h-100 shadow-sm border-0">
                <?php
                  // Tách để loại bỏ phần "uploads/products/" bị trùng (nếu có)
                  $imagePath = str_replace('uploads/products/', '', $product['image']);
                ?>
                <img src="/trang/admin/uploads/products/<?= htmlspecialchars($imagePath) ?>"  
                    style="width: 100%; height: 250px; object-fit: cover; display: block;" alt="Ảnh sản phẩm">
                <div class="card-body">
                  <h6>
                    <a href="index.php?act=detail&id=<?= $product['id'] ?>"
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
       <!-- Banner giữa -->
        <div class="my-5">
            <img src="./uploads/home1.png" class="img-fluid rounded-3" alt="Banner giữa">
        </div>

        <!-- top product views -->
        <div class="fs-4 fw-bold text-center py-2 px-5" style="width: max-content;margin: 30px auto;border-bottom: 2px solid orangered;">
            Top sản phẩm nhiều lượt xem
        </div>
        <div class="row g-4">
            <div class="row g-4">
          <?php foreach ($products_view as $product): ?>
            <div class="col-sm-6 col-md-4 col-lg-3">
              <div class="card h-100 shadow-sm border-0">
                <?php
                  // Tách để loại bỏ phần "uploads/products/" bị trùng (nếu có)
                  $imagePath = str_replace('uploads/products/', '', $product['image']);
                ?>
                <img src="/trang/admin/uploads/products/<?= htmlspecialchars($imagePath) ?>"  
                    style="width: 100%; height: 250px; object-fit: cover; display: block;" alt="Ảnh sản phẩm">
                <div class="card-body">
                  <h6>
                    <!-- <a href="index.php?act=detail&id=<?//= $product['id'] ?>" -->
                    <a href="?act=detail&id=<?= $product['id'] ?>"

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
          <!-- Banner cuối -->
          <div class="my-5">
              <img src="./uploads/home2.png" class="img-fluid rounded-3" alt="Banner cuối">
          </div>
        </div>
    </div>
    <!-- Footer -->
   
    <?php require 'views/clients/layouts/footer.php'; ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Trang chủ - Shop Quần Áo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

  <header class="border-bottom bg-white">
    <div style="background-color: #3b3a4a;" class="text-warning py-2 text-center fs-6 fw-semibold">
      <span>ĐỔI HÀNG MIỄN PHÍ - TẠI TẤT CẢ CỬA HÀNG TRONG 30 NGÀY</span>
    </div>

    <div class="container p-3">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

        <!-- Logo -->
        <a href="<?= BASE_URL ?>" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
          <img src="./uploads/logo2.png" alt="Logo" width="100" />
        </a>

        <!-- Menu -->
       <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 fw-semibold" style="font-size: 14px; margin-left: 30px;">
            <!-- Danh mục Nữ và Nam hiển thị ngang nhau -->
            <li class="nav-item">
              <a class="nav-link text-dark" href="?act=category_female">Nữ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="?act=category_male">Nam</a>
            </li>


              <!-- VOUCHERS -->
              <li class="nav-item">
                <a href="#" class="nav-link px-2 link-body-emphasis">KHO VOUCHERS</a>
              </li>

              <!-- Mũi tên xuống rỗng nếu không dùng -->
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <!-- Bạn có thể thêm nội dung mũi tên xuống ở đây -->
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item fw-semibold" style="font-size: 13px;" href="#">Mục dropdown</a></li>
                </ul>
              </li>
            </ul>


        <!-- Tài khoản + Giỏ hàng -->
        <div class="d-flex align-items-center">
          <?php if (isset($_SESSION['user_client'])): ?>
            <div class="dropdown me-4">
              <button class="btn btn-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <small style="font-size: 13px"><?= $_SESSION['user_client']['name'] ?></small>
              </button>
              <ul class="dropdown-menu" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="<?= BASE_URL . '?act=profile' ?>">Thông tin tài khoản</a></li>
                <li><a class="dropdown-item" href="<?= BASE_URL . '?act=history' ?>">Đơn hàng của tôi</a></li>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="<?= BASE_URL . '?act=logout' ?>">Đăng xuất</a></li>
              </ul>
            </div>
          <?php else: ?>
            <button class="btn btn-primary me-4">
              <a href="<?= BASE_URL . '?act=login' ?>" class="text-light text-decoration-none">
                <small style="font-size: 13px">Đăng nhập</small>
              </a>
            </button>
          <?php endif; ?>

          <a href="<?= BASE_URL . '?act=cart' ?>" class="text-dark text-decoration-none position-relative d-flex flex-column align-items-center">
            <i class="bi bi-bag fs-6"></i>
            <small style="font-size: 13px">Giỏ hàng</small>
          </a>
        </div>

      </div>
    </div>
  </header>
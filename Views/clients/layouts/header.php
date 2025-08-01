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
    <header class="border-bottom bg-white">
        <div style="background-color: #3b3a4a;" class=" text-warning py-2 text-center fs-6 fw-semibold">
            <span>ĐỔI HÀNG MIỄN PHÍ - TẠI TẤT CẢ CỬA HÀNG TRONG 30 NGÀY</span>
        </div>
        <div class="container p-3 ">
            <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="index.php" class="d-flex align-items-center mb-2 mb-lg-0 link-body-emphasis text-decoration-none">
                    <img src="uploads/logo2.png" alt="Logo" class="" width="100" />
                </a>
                <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 fw-semibold" style=" font-size: 14px">
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle text-dark" href="#" id="navbarDropdown" role="button">

                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <li><a href="#" class="dropdown-item fw-semibold" style="font-size: 13px" href="#"></a></li>
                        </ul>
                    </li>
                    <li><a href="#" class="nav-link px-2 link-body-emphasis">KHO VOUCHERS</a></li>
                </ul>
                <form class="col-12 col-lg-auto mb-3 mb-lg-0 me-lg-3" role="search" method="post" action="">
                    <div class="input-group">
                        <input
                            name="key"
                            type="search"
                            class="form-control"
                            placeholder="Tìm kiếm"
                            aria-label="Tìm kiếm" />
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
                <div class="d-flex align-items-center">
                    <a href="#" class="text-dark text-decoration-none me-4 d-flex flex-column align-items-center">
                        <i class="bi bi-shop fs-6"></i>
                        <small style="font-size: 13px">Đơn hàng</small>
                    </a>
                    <div class="dropdown">
                        <div class="me-2 btn btn-light dropdown-toggle">
                            <a href="#"><img src="" alt="Avatar" class="rounded-circle" width="40" height="40"></a>
                        </div>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Đăng xuất</a></li>
                            <li><a class="dropdown-item" href="#">Truy cập trang quản trị</a></li>
                        </ul>
                    </div>
                    <button class="btn btn-primary me-4">
                        <a href="#" class="text-light">
                            <small style="font-size: 13px">Đăng nhập</small>
                        </a>
                    </button>
                    <a href="#" class="text-dark text-decoration-none position-relative d-flex flex-column align-items-center">
                        <i class="bi bi-bag fs-6"></i>
                        <small style="font-size: 13px">Giỏ hàng</small>
                    </a>
                </div>
            </div>
        </div>
    </header>
    <!-- Banner Carousel -->
    <div id="bannerCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="uploads/banner_1.webp" class="d-block w-100 rounded-3" alt="Banner 1">
            </div>
            <div class="carousel-item">
                <img src="uploads/banner_2.webp" class="d-block w-100 rounded-3" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="uploads/banner_3.webp" class="d-block w-100 rounded-3" alt="Banner 2">
            </div>
            <div class="carousel-item">
                <img src="uploads/banner_4.webp" class="d-block w-100 rounded-3" alt="Banner 3">
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
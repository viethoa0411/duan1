  <div class="admin-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h5 class="text-center py-3 border-bottom border-secondary">Quản trị</h5>
      <a href="<?=BASE_URL_ADMIN?>" class="active"><i class="bi bi-house-door-fill me-2"></i> Dashboard</a>
      <a href="<?=BASE_URL_ADMIN . '?act=categories'?>"><i class="bi bi-folder-plus me-2"></i>Danh mục</a>
      <a href="<?=BASE_URL_ADMIN . '?act=products'?>"><i class="bi bi-box-seam me-2"></i> Sản phẩm</a>
      <a href="<?=BASE_URL_ADMIN . '?act=orders'?>"><i class="bi bi-cart-fill me-2"></i> Đơn hàng</a>
      <ul class="nav nav-pills flex-column mb-sm-auto mb-0">
        <li>
                <a class="nav-link text-white" data-bs-toggle="collapse" href="#userSubmenu" role="button" aria-expanded="false" aria-controls="userSubmenu">
                    <i class="bi bi-people-fill me-2"></i>Người dùng
                    <i class="fas fa-angle-down float-end"></i>
                </a>
                <div class="collapse ps-3" id="userSubmenu">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a href="<?= BASE_URL_ADMIN . '?act=accounts' ?>" class="nav-link text-white">
                                <i class="fas fa-user-cog me-2"></i> Tài khoản quản trị
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?=BASE_URL_ADMIN . '?act=users'?>" class="nav-link text-white">
                                <i class="fas fa-user me-2"></i> Tài khoản khách hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
      </ul>
      <a href="#"><i class="bi bi-gear-fill me-2"></i> Cài đặt</a>
    </aside>
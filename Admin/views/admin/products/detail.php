<?php require './views/admin/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row flex-nowrap">
        <!-- Sidebar -->
        <?php include './views/admin/layouts/sidebar.php'; ?>
       
        <main class="content">

          <!-- Main content -->
          <!-- <div class="col py-3"> -->
              <div class="card shadow-sm">
                  <h2 class="bx-4">
                      <h4 class="detail mb-0">Chi tiết sản phẩm</h4>
                  </h2>
                  <div class="card-body">
                      <?php if (!empty($product)): ?>
                          <div class="row">
                              <div class="col-md-4 text-center">
                                  <?php if (!empty($product['image'])): ?>
                                      <img src="<?= htmlspecialchars($product['image']) ?>" class="img-fluid rounded shadow-sm" alt="Ảnh sản phẩm">
                                  <?php else: ?>
                                      <img src="https://via.placeholder.com/300?text=No+Image" class="img-fluid rounded" alt="Không có ảnh">
                                  <?php endif; ?>
                              </div>
                              <div class="col-md-8">
                                  <table class="table table-borderless">
                                      <tr>
                                          <th>ID:</th>
                                          <td><?= htmlspecialchars($product['id']) ?></td>
                                      </tr>
                                      <tr>
                                          <th>Tên sản phẩm:</th>
                                          <td><?= htmlspecialchars($product['name']) ?></td>
                                      </tr>
                                      <tr>
                                          <th>Danh mục:</th>
                                          <td><?= htmlspecialchars($product['category_name']) ?></td>
                                      </tr>
                                      <tr>
                                          <th>Giá:</th>
                                          <td><strong class="text-danger"><?= number_format($product['price']) ?> đ</strong></td>
                                      </tr>
                                      <tr>
                                          <th>Giá giảm:</th>
                                          <td><strong class="text-success"><?= number_format($product['price_sale']) ?> đ</strong></td>
                                      </tr>
                                      <tr>
                                          <th>Số lượng:</th>
                                          <td><?= htmlspecialchars($product['quantity']) ?></td>
                                      </tr>
                                      <tr>
                                          <th>Mô tả:</th>
                                          <td><?= nl2br(htmlspecialchars($product['description'])) ?></td>
                                      </tr>
                                      <tr>
                                          <th>Ngày tạo:</th>
                                          <td><?= htmlspecialchars($product['created_at']) ?></td>
                                      </tr>
                                      <tr>
                                          <th>Ngày cập nhật:</th>
                                          <td><?= htmlspecialchars($product['updated_at']) ?></td>
                                      </tr>
                                  </table>
                              </div>
                          </div>
                          <a href="<?= BASE_URL_ADMIN . '?act=products' ?>" class="btn btn-secondary mt-3">
                              <i class="bi bi-arrow-left"></i> Quay lại danh sách
                          </a>
                      <?php else: ?>
                          <div class="alert alert-danger mt-3">Không tìm thấy sản phẩm.</div>
                      <?php endif; ?>
                  </div>
              </div>
          <!-- </div> -->
        </main>
    </div>
</div>

<?php include './views/admin/layouts/footer.php'; ?>

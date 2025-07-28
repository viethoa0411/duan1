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
                                  
                                      
                                            <?php
                                                $mainImage = $product['image'] ?? 'https://via.placeholder.com/300?text=No+Image';
                                                $imageList = json_decode($product['image_list'] ?? '[]', true);
                                            ?>

                                            <!-- Ảnh chính -->
                                            <div class="mb-3 d-flex justify-content-center">
                                                <div style="width: 600px; height: 400px;" class="border rounded shadow-sm d-flex align-items-center justify-content-center">
                                                    <img id="mainImage"
                                                        src="<?= htmlspecialchars($mainImage) ?>"
                                                        alt="Ảnh chính"
                                                        style="width: 100%; height: 100%; object-fit: contain;">
                                                </div>
                                            </div>


                                            <!-- Ảnh phụ -->
                                            <?php if (!empty($imageList)): ?>
                                                <div class="d-flex flex-wrap gap-2 justify-content-center">
                                                    <?php foreach ($imageList as $imgPath): ?>
                                                        <img 
                                                            src="<?= htmlspecialchars($imgPath) ?>" 
                                                            class="img-thumbnail border"
                                                            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;"
                                                            onclick="changeMainImage('<?= htmlspecialchars($imgPath) ?>')"
                                                        >
                                                    <?php endforeach; ?>
                                                </div>
                                            <?php else: ?>
                                                <p class="text-muted text-center">Không có ảnh phụ.</p>
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
                                            <?//php var_dump($category_name) ;
                                            //   die(); ?>
                                            
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
                                            <td><?= !empty($product['description']) ? (htmlspecialchars($product['description'])) : '' ?></td>
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

                <!-- comment -->
                <h3 class="mt-4">Bình luận</h3>
                    <?php if (!empty($reviews)) : ?>
                        <ul>
                            <?php foreach ($reviews as $review) : ?>
                                <li>
                                    <strong><?= htmlspecialchars($review['user_name']) ?></strong> 
                                    (<?= $review['rating'] ?>/5): 
                                    <?= htmlspecialchars($review['comment']) ?> 
                                    <br><small><i><?= $review['create_at'] ?></i></small>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>Chưa có bình luận nào cho sản phẩm này.</p>
                    <?php endif; ?>

            <!-- </div> -->
                <script>
                    function changeMainImage(src) {
                        document.getElementById('mainImage').src = src;
                    }
                </script>

            </main>
        </div>
    </div>

    <?php include './views/admin/layouts/footer.php'; ?>

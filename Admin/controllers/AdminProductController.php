<?php

require_once 'models/AdminProduct.php';
require_once 'models/AdminCategory.php';
require_once 'models/AdminReview.php';
require_once 'models/AdminProductImage.php';

class AdminProductController
{
    private $Product;
    private $Category;
    private $Review;
    private $ProductImage;

    public function __construct()
    {
        $this->Product = new AdminProduct();
        $this->Category = new AdminCategory();
        $this->Review = new AdminReview();
        $this->ProductImage = new ProductImage();
    }

    public function list()
    {
        $products = $this->Product->getAllProduct();
        require_once './views/admin/products/list.php';
    }

    public function detail($id)
    {
        $product = $this->Product->getProductById($id);
        if (!$product) {
            echo "Không có sản phẩm này.";
            return;
        }
        $reviews = $this->Review->getReviewsByProductId($id);
        require_once './views/admin/products/detail.php';
    }

    public function formadd()
    {
        $categories = $this->Category->getAllCategory();
        require_once './views/admin/products/add.php';
    }

    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $price_sale = floatval($_POST['price_sale'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 0);
            $category_id = intval($_POST['category_id'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $errors = [];

            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống!";
            if ($price <= 0) $errors[] = "Giá sản phẩm phải lớn hơn 0!";
            if ($price_sale > $price) $errors[] = "Giá khuyến mãi không được lớn hơn giá gốc!";
            if ($quantity < 0) $errors[] = "Số lượng không được âm!";
            if ($category_id <= 0) $errors[] = "Vui lòng chọn danh mục!";

            // Khởi tạo biến ảnh chính và ảnh phụ
            $image = '';
            $imageListPaths = [];

            // Thư mục upload
            $upload_dir = 'uploads/products/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            // Xử lý ảnh phụ trước
            if (!empty($_FILES['image_list']) && is_array($_FILES['image_list']['name'])) {
                $imageCount = count($_FILES['image_list']['name']);
                if ($imageCount > 10) {
                    $errors[] = "Chỉ được chọn tối đa 10 ảnh phụ!";
                } else {
                    foreach ($_FILES['image_list']['tmp_name'] as $key => $tmpName) {
                        if (!empty($tmpName)) {
                            $file_ext = pathinfo($_FILES['image_list']['name'][$key], PATHINFO_EXTENSION);
                            $file_name = uniqid() . '.' . $file_ext;
                            $target_path = $upload_dir . $file_name;

                            if (move_uploaded_file($tmpName, $target_path)) {
                                $imageListPaths[] = $target_path;
                            }
                        }
                    }
                }
            }

            // Xử lý ảnh chính
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image = $upload_path;
                }
            }

            // Nếu không có ảnh chính, dùng ảnh phụ đầu tiên làm ảnh chính
            if (empty($image) && !empty($imageListPaths)) {
                $image = $imageListPaths[0];
            }

            // Nếu có lỗi, thông báo và quay lại form
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<script>alert('$error');</script>";
                }
                $this->formadd(); // Gọi lại form nếu có lỗi
                return;
            }

            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            // Gọi model để thêm sản phẩm
            $result = $this->Product->addProduct(
                $name,
                $price,
                $price_sale,
                $quantity,
                $description,
                $image,
                json_encode($imageListPaths),
                $created_at,
                $updated_at,
                $category_id
            );

            if ($result) {
                echo '<script>alert("Thêm sản phẩm thành công!");</script>';
                header('Location: ' . BASE_URL_ADMIN . '?act=products');
                exit();
            } else {
                echo '<script>alert("Có lỗi khi thêm sản phẩm!");</script>';
            }
        } else {
            $this->formadd(); // Hiển thị form nếu chưa submit
        }
    }


    public function editProduct($id)
    {
        $product = $this->Product->getProductById($id);
        $listCategory = $this->Category->getAllCategory();
        require_once './views/admin/products/edit.php';
    }

    public function updateProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
            $id = $_POST['id'];
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $quantity = intval($_POST['quantity'] ?? 0);
            $category_id = intval($_POST['category_id'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $updated_at = date('Y-m-d H:i:s');

            $errors = [];

            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống!";
            if ($price <= 0) $errors[] = "Giá sản phẩm phải lớn hơn 0!";
            if ($quantity < 0) $errors[] = "Số lượng không được âm!";
            if ($category_id <= 0) $errors[] = "Vui lòng chọn danh mục!";

            $upload_dir = 'uploads/products/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            // Ảnh phụ mới
            $imageListPaths = [];

            if (!empty($_FILES['image_list']) && is_array($_FILES['image_list']['name'])) {
                $imageCount = count($_FILES['image_list']['name']);
                if ($imageCount > 10) {
                    $errors[] = "Chỉ được chọn tối đa 10 ảnh phụ!";
                } else {
                    foreach ($_FILES['image_list']['tmp_name'] as $key => $tmpName) {
                        if (!empty($tmpName)) {
                            $file_ext = pathinfo($_FILES['image_list']['name'][$key], PATHINFO_EXTENSION);
                            $file_name = uniqid() . '.' . $file_ext;
                            $target_path = $upload_dir . $file_name;

                            if (move_uploaded_file($tmpName, $target_path)) {
                                $imageListPaths[] = $target_path;
                            }
                        }
                    }
                }
            }

            // Ảnh chính
            $image = $_POST['old_image'] ?? '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image = $upload_path;
                }
            }

            // Nếu không có ảnh chính mới → dùng ảnh phụ đầu tiên nếu có
            if (empty($image) && !empty($imageListPaths)) {
                $image = $imageListPaths[0];
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<script>alert('$error');</script>";
                }
                $product = $this->Product->getProductById($id);
                $listCategory = $this->Category->getAllCategory();
                require './views/admin/products/edit.php';
                return;
            }

            // Nếu không upload ảnh phụ mới → giữ nguyên ảnh phụ cũ
            $productOld = $this->Product->getProductById($id);

            $imageListJson = !empty($imageListPaths) ? json_encode($imageListPaths) : $productOld['image_list'];

            $result = $this->Product->updateProduct(
                $id,
                $name,
                $price,
                $quantity,
                $image,
                $imageListJson,
                $updated_at,
                $category_id,
                $description
            );

            if ($result) {
                echo '<script>alert("Cập nhật sản phẩm thành công!");</script>';
                header('Location: ' . BASE_URL_ADMIN . '?act=products');
                exit();
            } else {
                $error = "Có lỗi xảy ra khi cập nhật sản phẩm!";
                $product = $this->Product->getProductById($id);
                $listCategory = $this->Category->getAllCategory();
                require './views/admin/products/edit.php';
            }
        }
    }


    public function uploadImages()
    {
        $productId = $_POST['product_id'];
        $defaultIndex = (int)($_POST['default_index'] ?? 1);

        // Kiểm tra số lượng tối đa
        $stmt = connectDB()->prepare("SELECT COUNT(*) FROM product_images WHERE product_id = ?");
        $stmt->execute([$productId]);
        $currentCount = $stmt->fetchColumn();

        $files = $_FILES['images'];
        $newCount = count($files['name']);

        if ($currentCount + $newCount > 10) {
            echo "Mỗi sản phẩm chỉ được tối đa 10 ảnh.";
            return;
        }

        // Gỡ ảnh mặc định cũ
        if ($defaultIndex >= 1 && $defaultIndex <= $newCount) {
            $this->ProductImage->unsetDefaultImage($productId);
        }

        $uploadDir = __DIR__ . '/../../public/uploads/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        for ($i = 0; $i < $newCount; $i++) {
            $tmpName = $files['tmp_name'][$i];
            $fileName = uniqid() . '_' . basename($files['name'][$i]);
            $destination = $uploadDir . $fileName;

            if (move_uploaded_file($tmpName, $destination)) {
                $isDefault = ($i + 1 == $defaultIndex) ? 1 : 0;

                $stmt = connectDB()->prepare("INSERT INTO product_images (product_id, image_path, is_default) VALUES (?, ?, ?)");
                $stmt->execute([$productId, '/uploads/products/' . $fileName, $isDefault]);
            }
        }

        // Kiểm tra ít nhất 3 ảnh
        if (!$this->ProductImage->checkMinimumImages($productId)) {
            echo "⚠️ Sản phẩm cần có ít nhất 3 ảnh!";
            return;
        }

        echo "✅ Tải ảnh thành công!";
    }

    public function deleteProduct($id)
    {
        $result = $this->Product->deleteProduct($id);
        if ($result) {
            echo '<script>alert("Xóa sản phẩm thành công!");</script>';
        } else {
            echo '<script>alert("Có lỗi khi xóa sản phẩm!");</script>';
        }
        header('Location: ' . BASE_URL_ADMIN . '?act=products');
        exit();
    }
}

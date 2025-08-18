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
        // Lấy từ khóa tìm kiếm (nếu có)
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

        // Gọi hàm lấy sản phẩm kèm điều kiện tìm kiếm
        $products = $this->Product->getAllProduct($keyword);

        require_once './views/admin/products/list.php';
    }


    public function detail($id)
    {
        $product = $this->Product->getProductById($id);
        if (!$product) {
            echo "Không có sản phẩm này.";
            return;
        }

        $sizes = $this->Product->getAllSizes();
        $colors = $this->Product->getAllColors();
        $variants = $this->Product->getVariantsByProductId($id);
        $totalStock = $this->Product->getTotalStockByProductId($id);
        $reviews = $this->Review->getReviewsByProductId($id);

        require_once './views/admin/products/detail.php';
    }



    public function formadd()
    {
        $categories = $this->Category->getAllCategory();
        $sizes = $this->Product->getAllSizes();   // Lấy danh sách size
        $colors = $this->Product->getAllColors(); // Lấy danh sách màu

        require_once './views/admin/products/add.php';
    }


    public function addProduct()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
            $name = trim($_POST['name'] ?? '');
            $price = floatval($_POST['price'] ?? 0);
            $price_sale = floatval($_POST['price_sale'] ?? 0);
            $category_id = intval($_POST['category_id'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $errors = [];

            // Validate cơ bản
            if (empty($name)) $errors[] = "Tên sản phẩm không được để trống!";
            if ($price <= 0) $errors[] = "Giá sản phẩm phải lớn hơn 0!";
            if ($price_sale > $price) $errors[] = "Giá khuyến mãi không được lớn hơn giá gốc!";
            if ($category_id <= 0) $errors[] = "Vui lòng chọn danh mục!";

            // Xử lý upload ảnh
            $image = '';
            $imageListPaths = [];
            $upload_dir = 'uploads/products/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            // Ảnh phụ
            if (!empty($_FILES['image_list']['name']) && is_array($_FILES['image_list']['name'])) {
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
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image = $upload_path;
                }
            }

            // Nếu không có ảnh chính thì dùng ảnh phụ đầu tiên
            if (empty($image) && !empty($imageListPaths)) {
                $image = $imageListPaths[0];
            }

            // Nếu có lỗi → quay lại form
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    echo "<script>alert('$error');</script>";
                }
                $this->formadd();
                return;
            }

            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            $product_id = $this->Product->addProduct(
                $name,
                $price,
                $price_sale,
                $description,
                $image,
                json_encode($imageListPaths),
                $created_at,
                $updated_at,
                $category_id
            );

            if ($product_id) {
                echo '<script>alert("Thêm sản phẩm thành công!");</script>';
                header('Location: ' . BASE_URL_ADMIN . '?act=products');
                exit();
            } else {
                echo '<script>alert("Có lỗi khi thêm sản phẩm!");</script>';
            }
        } else {
            $this->formadd();
        }
    }

    public function formaddVariant($id = null)
    {
        // Nếu không truyền id hoặc id không hợp lệ => lấy từ GET
        $id = $id ?? ($_GET['id'] ?? null);

        if (!$id || !is_numeric($id)) {
            echo "<script>alert('ID sản phẩm không hợp lệ!'); window.history.back();</script>";
            return;
        }

        $products = $this->Product->getProductById($id);
        if (!$products) {
            echo "<script>alert('Sản phẩm không tồn tại!'); window.history.back();</script>";
            return;
        }

        $sizes = $this->Product->getAllSizes();
        $colors = $this->Product->getAllColors();
        require_once './views/admin/products/variant.php';
    }

    public function addVariant()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_variant'])) {
            // Lấy id từ POST (ưu tiên) hoặc GET
            $id = $_POST['id'] ?? ($_GET['id'] ?? null);

            if (!$id || !is_numeric($id)) {
                echo "<script>alert('ID sản phẩm không hợp lệ!'); window.history.back();</script>";
                return;
            }

            $sizes = $_POST['sizes'] ?? [];
            $colors = $_POST['colors'] ?? [];
            $variant_stock = $_POST['variant_stock'] ?? [];

            if (empty($sizes) || empty($colors)) {
                echo "<script>alert('Vui lòng chọn ít nhất một size và một màu!');</script>";
                $this->formaddVariant($id);
                return;
            }

            foreach ($sizes as $size) {
                foreach ($colors as $color) {
                    // Kiểm tra stock tồn tại và hợp lệ
                    if (!isset($variant_stock[$size][$color]) || $variant_stock[$size][$color] < 0) {
                        echo "<script>alert('Số lượng không hợp lệ cho size: $size, màu: $color');</script>";
                        $this->formaddVariant($id);
                        return;
                    }

                    $stock = (int)$variant_stock[$size][$color];
                    $this->Product->addProductVariants($id, $size, $color, $stock);
                }
            }

            echo "<script>alert('Thêm biến thể thành công!');</script>";
            header('Location: ' . BASE_URL_ADMIN . '?act=products/detail&id=' . $id);
            exit;
        } else {
            // Nếu không phải POST thì gọi form
            $id = $_GET['id'] ?? null;
            $this->formaddVariant($id);
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
            $price_sale = floatval($_POST['price_sale'] ?? 0);
            if ($price_sale > $price) {
                $error = "Giá khuyến mãi không được lớn hơn giá gốc!";
                $product = $this->Product->getProductById($id);
                $listCategory = $this->Category->getAllCategory();
                require './views/admin/products/edit.php';
                return;
            }
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
                $price_sale,
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

        echo "Tải ảnh thành công!";
    }

    public function deleteProduct($id)
    {
        $result = $this->Product->deleteProduct($id);
        if ($result) {
            echo '<script>
        alert("Xóa sản phẩm thành công!");
        window.location.href = "' . BASE_URL_ADMIN . '?act=products";
    </script>';
        } else {
            echo '<script>
        alert("Có lỗi khi xóa sản phẩm!");
        window.location.href = "' . BASE_URL_ADMIN . '?act=products";
    </script>';
        }
        exit();
    }
}

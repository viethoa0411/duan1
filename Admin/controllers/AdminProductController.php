<?php

require_once 'models/AdminProduct.php';
require_once 'models/AdminCategory.php';

class AdminProductController
{
    private $Product;
    private $Category;
    public function __construct()
    {
        $this->Product = new AdminProduct();
        $this->Category = new AdminCategory();
    }
    public function list()
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        $products = $this->Product->getAllProduct($keyword);
        require_once './views/admin/products/list.php';
    }

    public function detail($id){
        $product = $this->Product->getProductById($id);
        if (!$product) {
            echo "Không có sản phẩm này.";
            return;
        }
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

            if (empty($name)) {
                $errors[] = "Tên sản phẩm không được để trống!";
            }
            if ($price <= 0) {
                $errors[] = "Giá sản phẩm phải lớn hơn 0!";
            }
            if ($price_sale > $price) {
                $errors[] = "Giá khuyến mãi không được lớn hơn giá gốc!";
            }
            if ($quantity < 0) {
                $errors[] = "Số lượng không được âm!";
            }
            if ($category_id <= 0) {
                $errors[] = "Vui lòng chọn danh mục!";
            }
            if ($description = trim($_POST['description'] ?? '') == '') {
                $errors[] = "Mô tả sản phẩm không được để trống!";
            }

            // Xử lý upload ảnh
            $image = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload_dir = 'uploads/products/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image = $upload_path;
                }
            }

            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            $result = $this->Product->addProduct(
                $name,
                $price,
                $price_sale,
                $quantity,
                $image,
                $created_at,
                $updated_at,
                $category_id,
                $description
            );

            if ($result) {
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
            $quantity = intval($_POST['quantity'] ?? 0);
            $category_id = intval($_POST['category_id'] ?? 0);
            $description = trim($_POST['description'] ?? '');
            $updated_at = date('Y-m-d H:i:s');

            // Xử lý upload ảnh
            $image = $_POST['old_image'] ?? '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $upload_dir = 'uploads/products/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $file_name = uniqid() . '.' . $file_extension;
                $upload_path = $upload_dir . $file_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                    $image = $upload_path;
                }
            }

            $result = $this->Product->updateProduct($id, $name, $price, $price_sale, $quantity, $image, $updated_at, $category_id, $description);
            if ($result) {
                echo '<script>alert("Cập nhật sản phẩm thành công!");</script>';
                header('Location: ' . BASE_URL_ADMIN . '?act=products');
                exit();
            } else {
                $error = "Có lỗi xảy ra khi cập nhật sản phẩm!";
                $product = $this->Product->getProductById($id);
                $listCategory = $this->Category->getAllCategory();
                require './Views/admin/products/edit.php';
            }
        }
    }


    public function deleteProduct($id) {
        $result = $this->Product->deleteProduct($id);
        if ($result) {
            echo '<script>alert("Xóa sản phẩm thành công!");</script>';
            header('Location: ' . BASE_URL_ADMIN . '?act=products');
            exit();
        } else {
            echo '<script>alert("Có lỗi khi xóa sản phẩm!");</script>';
            header('Location: ' . BASE_URL_ADMIN . '?act=products');
            exit();
        }
    }
}

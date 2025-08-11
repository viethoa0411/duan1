<?php 

require_once 'Models/Category.php';
class CategoryController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Hiển thị danh mục cha: Nữ và Nam
    public function showParentCategories() {
        // Hiện tại chỉ có 2 danh mục cha cứng là Nữ và Nam
        require './views/layouts/header.php';
    }
  
    // Hiển thị danh mục con thuộc Nữ kèm sản phẩm
    public function showFemaleCategories() {
        $categoryModel = new Category($this->db);
        $productModel = new Product($this->db);

        $gender = 'Nữ';  // Tiêu đề để hiển thị
        // Lấy danh mục con chứa từ khóa 'nữ'
        $categories = $categoryModel->getCategoriesByKeyword('nữ');

        // Kiểm tra nếu có category_id truyền lên thì lấy sản phẩm theo category đó, ngược lại lấy tất cả sản phẩm các danh mục con nữ
        $category_id = $_GET['category_id'] ?? null;
        if ($category_id) {
            $products = $productModel->getProductsByCategoryId($category_id);
        } else {
            $categoryIds = array_column($categories, 'id');
            $products = $productModel->getProductsByCategoryIds($categoryIds);
        }

        require_once './views/clients/child_categories.php';
    }

    // Hiển thị danh mục con thuộc Nam kèm sản phẩm
    public function showMaleCategories() {
        $categoryModel = new Category($this->db);
        $productModel = new Product($this->db);
        
          $gender = 'Nam';  

        $categories = $categoryModel->getCategoriesByKeyword('nam');

        $category_id = $_GET['category_id'] ?? null;
        if ($category_id) {
            $products = $productModel->getProductsByCategoryId($category_id);
        } else {
            $categoryIds = array_column($categories, 'id');
            $products = $productModel->getProductsByCategoryIds($categoryIds);
        }

        require_once './views/clients/child_categories.php';
    }

   
}

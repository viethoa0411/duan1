<?php
class ClientController
{
    private $conn;

    private $productModel;
    private $variantModel;
    private $cartModel;
    private $reviewModel;
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        $this->conn = getDBConnection();
        $this->productModel = new Product($this->conn);
        $this->variantModel = new Variant();
        $this->cartModel = new Cart();
        $this->reviewModel = new Review();
        $this->orderModel = new Order();
        $this->userModel = new Auth();
    }
    public function index()
    {
        $products = $this->productModel->getNewProducts();
        $products_view = $this->productModel->getTopView();
        require './views/clients/home.php';
    }

    public function detail($id)
    {
        if (!$id) {
            echo "Chưa có sản phẩm này!";
            return;
        }

        $product = $this->productModel->getProductById($id);
        if (!$product) {
            echo "Sản phẩm không tồn tại!";
            return;
        }

        $productVariants = $this->variantModel->getVariantsByProductId($id);
        $relatedProducts = $this->productModel->getRelatedProducts($product['category_id'], $product['id']);
        $reviews = $this->reviewModel->getByProductId($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
            $user_id = $_SESSION['user']['id'] ?? null;
            $rating = $_POST['rating'] ?? 5;
            $comment = trim($_POST['comment']);

            if ($user_id && !empty($comment)) {
                $this->reviewModel->create($id, $user_id, $rating, $comment);
                header("Location: index.php?act=detail&id=$id");
                exit;
            }
        }

        require './views/clients/detail.php';
    }

    public function search()
    {
        $keyword = $_GET['query'] ?? '';

        if (empty(trim($keyword))) {
            echo "Vui lòng nhập từ khóa tìm kiếm!";
            return;
        }

        $productModel = new Product($this->conn);
        $products = $productModel->searchProducts($keyword);

        require './views/clients/search.php';
    }

        public function userProfile()
    {
        
        if (!isset($_SESSION['user_client'])) {
            header("Location: " . BASE_URL . "?act=login");
            exit();
        }
        $user = $_SESSION['user_client'];
        require './views/clients/profile.php';
    }

        public function postUpdateProfile()
    {
        if (!isset($_SESSION['user_client'])) {
            header("Location: " . BASE_URL . "?act=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userId = $_SESSION['user_client']['id'];
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $address = trim($_POST['address']);

            $result = $this->userModel->updateUser($userId, $name, $email, $phone, $address);

            if ($result) {
                
                $_SESSION['user_client']['name'] = $name;
                $_SESSION['user_client']['email'] = $email;
                $_SESSION['user_client']['phone'] = $phone;
                $_SESSION['user_client']['address'] = $address;

                $_SESSION['success'] = 'Cập nhật thông tin thành công!';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại.';
            }
        }
        header("Location: " . BASE_URL . "?act=profile");
        exit();
    }

    
}

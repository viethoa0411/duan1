<?php
class CartController
{
    private $cartModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
    }


    public function add()
    {
        if (!isset($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = (int) $_SESSION['user_client']['id'];
            $productId = (int) ($_POST['product_id'] ?? 0);
            $variantId = (int) ($_POST['variant_id'] ?? 0);
            $quantity = (int) ($_POST['quantity'] ?? 1);

            if ($productId && $variantId && $quantity > 0) {
                // Lấy thông tin tồn kho từ bảng product_variants
                $variantData = $this->cartModel->getVariantStock($variantId);

                if (!$variantData) {
                    echo "<script>alert('Biến thể sản phẩm không tồn tại!');history.back();</script>";
                    exit;
                }

                $stock = (int) $variantData['stock'];

                // Lấy số lượng hiện có trong giỏ
                $currentInCart = $this->cartModel->getQuantityInCart($userId, $variantId);

                // Nếu giỏ đã đầy số lượng tồn
                if ($currentInCart >= $stock) {
                    echo "<script>alert('Sản phẩm này trong giỏ đã đạt số lượng tối đa trong kho!');history.back();</script>";
                    exit;
                }

                // Nếu số lượng muốn thêm vượt quá tồn kho còn lại → báo lỗi
                if ($currentInCart + $quantity > $stock) {
                    echo "<script>alert('Bạn đang thêm quá số lượng sản phẩm có sẵn vào giỏ hàng');history.back();</script>";
                    exit;
                }

                // Thêm vào giỏ nếu hợp lệ
                $this->cartModel->add($userId, $productId, $variantId, $quantity);
                $_SESSION['cart_count'] = $this->cartModel->getCartItemCount($userId);
                header('Location: ' . BASE_URL . '?act=cart');
                exit;
            }
        }
    }
    public function list()
    {
        if (!isset($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        $userId = $_SESSION['user_client']['id'];
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);

        require './views/clients/cart.php';
    }
    public function update()
    {
        if (!isset($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_client']['id'];
            $cartId = $_POST['cart_id'] ?? null;
            $newQuantity = $_POST['quantity'] ?? 1;

            if ($cartId && $newQuantity > 0) {
                $this->cartModel->updateQuantity($cartId, $newQuantity);
                $_SESSION['cart_count'] = $this->cartModel->getCartItemCount($userId);
            }
        }
        header('Location: ' . BASE_URL . '?act=cart');
        exit;
    }

    public function remove()
    {
        if (!isset($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }
        $userId = $_SESSION['user_client']['id'];
        if (isset($_GET['cart_id'])) {
            $cartId = $_GET['cart_id'];
            $this->cartModel->remove($cartId);
            $_SESSION['cart_count'] = $this->cartModel->getCartItemCount($userId);
        }
        header('Location: ' . BASE_URL . '?act=cart');
        exit;
    }
    public function checkout()
    {
        if (!isset($_SESSION['user_client'])) {
            header('Location: ' . BASE_URL . '?act=login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['selected_products']) && is_array($_POST['selected_products'])) {
                $_SESSION['selected_products'] = array_map('intval', $_POST['selected_products']);
                header("Location: " . BASE_URL . "?act=checkout");
                exit;
            } else {
                header("Location: " . BASE_URL . "?act=cart");
                exit;
            }
        }

        header("Location: " . BASE_URL . "?act=cart");
        exit;
    }
}

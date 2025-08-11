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
            $userId = $_SESSION['user_client']['id'];
            $productId = $_POST['product_id'] ?? null;
            $variantId = $_POST['variant_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1;

            if ($productId && $variantId && $quantity > 0) {
                $this->cartModel->add((int)$userId, (int)$productId, (int)$variantId, (int)$quantity);
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

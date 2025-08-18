<?php

class OrderController
{
    private $cartModel;
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        $this->userModel = new Auth();
        $this->cartModel = new Cart();
        $this->orderModel = new Order();
    }

    public function checkout()
    {
        if (!isset($_SESSION['user_client'])) {
            header("Location: " . BASE_URL . "?act=login");
            exit;
        }

        $userId = $_SESSION['user_client']['id'];
        $selected = $_SESSION['selected_products'] ?? [];

        if (empty($selected)) {
            echo '<script>alert("Bạn chưa chọn sản phẩm");</script>';
            header("Location: " . BASE_URL . "?act=cart");
            exit;
        }

        $allCartItems = $this->cartModel->getCartItemsByUserId($userId);
        $checkoutItems = [];
        foreach ($allCartItems as $item) {
            if (in_array($item['cart_id'], $selected)) {
                $checkoutItems[] = $item;
            }
        }

        if (empty($checkoutItems)) {
            echo '<script>alert("Bạn chưa chọn sản phẩm");</script>';
            header("Location: " . BASE_URL . "?act=cart");
            exit;
        }

        require './views/clients/checkout.php';
    }


    public function placeOrder()
    {
        if (!isset($_SESSION['user_client'])) {
            header("Location: " . BASE_URL . "?act=login");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user_client']['id'];
            $cartItems = $this->cartModel->getCartItemsByUserId($userId);
            $selectedCartIds = $_POST['selected_products'] ?? [];
            $checkoutItems = array_filter($cartItems, function ($item) use ($selectedCartIds) {
                return in_array($item['cart_id'], $selectedCartIds);
            });

            if (empty($checkoutItems)) {
                echo '<script>alert("Bạn chưa chọn sản phẩm");</script>';
                header("Location: " . BASE_URL . "?act=cart");
                exit;
            }

            $orderData = [
                'user_id' => $userId,
                'name' => $_POST['consignee'],
                'phone' => $_POST['phone'],
                'address' => $_POST['address'],
                'note' => $_POST['note'] ?? '',
                'total_amount' => $_POST['final_total_amount']
            ];

            $orderId = $this->orderModel->createOrder($orderData);

            if ($orderId) {
                foreach ($checkoutItems as $item) {
                    $this->orderModel->createOrderItem(
                        $orderId,
                        $item['product_id'],
                        $item['variant_id'],
                        $item['quantity'],
                        $item['price_sale']
                    );
                    $this->orderModel->decreaseStock($item['variant_id'], $item['quantity']);
                    $this->cartModel->remove($item['cart_id']);
                }

                // Xóa sản phẩm chọn trong session (nếu có)
                unset($_SESSION['selected_products']);

                // Cập nhật lại số lượng giỏ hàng
                $_SESSION['cart_count'] = $this->cartModel->countCartItemsByUserId($userId);

                $_SESSION['last_order_id'] = $orderId;

                header("Location: " . BASE_URL . "?act=order-success");
                exit;
            }
        }
        header("Location: " . BASE_URL . "?act=checkout");
        exit;
    }


    public function showOrderSuccessPage()
    {
        if (!isset($_SESSION['last_order_id'])) {
            header("Location: " . BASE_URL);
            exit;
        }
        $orderId = $_SESSION['last_order_id'];
        unset($_SESSION['last_order_id']);
        require './views/clients/order-success.php';
    }

    public function history()
    {
        if (!isset($_SESSION['user_client'])) {
            echo "Bạn chưa đăng nhập.";
            return;
        }

        $user = $_SESSION['user_client'];

        $user_id = $user['id'];

        $orders = $this->orderModel->getOrder($user_id);

        if (!$orders) {
            echo "Không có đơn hàng nào.";
            return;
        }

        require_once './views/clients/history.php';
    }


    public function orderDetail($id)
    {
        if (!isset($_SESSION['user_client'])) {
            echo "Bạn chưa đăng nhập.";
            return;
        }

        $order = $this->orderModel->getOrderById($id);

        if (!$order) {
            echo "Không tìm thấy đơn hàng.";
            return;
        }

        $orderItems = $this->orderModel->getOrderItems($id); // lấy sản phẩm theo đơn hàng

        require_once './views/clients/detailorder.php';
    }


    public function removeOrder($id)
    {
        if (!isset($_SESSION['user_client'])) {
            echo "<script>alert('Bạn chưa đăng nhập.'); window.history.back();</script>";
            return;
        }

        $user = $_SESSION['user_client'];
        $user_id = $user['id'];

        $order = $this->orderModel->getOrderById($id);

        if ($order && $order['user_id'] == $user_id) {
            if (in_array($order['status_id'], [1, 2, 3, 4, 5])) {

                // ✅ 1. Lấy sản phẩm trong đơn
                $orderItems = $this->orderModel->getOrderItems($id);

                // ✅ 2. Cộng lại số lượng vào product_variants.stock
                foreach ($orderItems as $item) {
                    $this->orderModel->increaseStock($item['variant_id'], $item['quantity']);
                }

                // ✅ 3. Cập nhật trạng thái đơn
                $this->orderModel->updateOrderStatus($id, 11);

                header("Location: " . BASE_URL . "?act=history");
                exit;
            } else {
                echo "<script>alert('Bạn không thể hủy đơn hàng này !!'); window.location.href='" . BASE_URL . "?act=history';</script>";
            }
        } else {
            echo "<script>alert('Bạn không có quyền hủy đơn hàng này.'); window.location.href='" . BASE_URL . "?act=history';</script>";
        }
    }


    public function refundOrder($id)
    {
        if (!isset($_SESSION['user_client'])) {
            echo "<script>alert('Bạn chưa đăng nhập.'); window.history.back();</script>";
            return;
        }

        $user = $_SESSION['user_client'];
        $user_id = $user['id'];

        $order = $this->orderModel->getOrderById($id);

        if ($order && $order['user_id'] == $user_id) {
            if (in_array($order['status_id'], [8])) {
                $this->orderModel->updateOrderStatus($id, 10);
                header("Location: " . BASE_URL . "?act=history");
                exit;
            } else {
                echo "<script>alert('Bạn không thể hoàn đơn hàng này !!'); window.location.href='" . BASE_URL . "?act=history';</script>";
            }
        } else {
            echo "<script>alert('Bạn không có quyền hủy đơn hàng này.'); window.location.href='" . BASE_URL . "?act=history';</script>";
        }
    }
}

<?php

require_once 'models/AdminOrder.php';

class AdminOrderController
{
    private $Order;
    public function __construct()
    {
        $this->Order = new AdminOrder();
    }
    public function list()
    {
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : null;
        $orders = $this->Order->getAllOrders($keyword);

        require_once './views/admin/orders/list.php';
    }

    public function detail()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id > 0) {
            $orders = $this->Order->getOrderById($id);
            $orderItems = $this->Order->getOrderItems($id);
            $liststatus = $this->Order->getAllStatus();
            require_once './views/admin/orders/detail.php';
        } else {
            echo "ID đơn hàng không hợp lệ.";
        }
    }

    public function updateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $order_id = $_POST['order_id'] ?? null;
            $status_id = $_POST['status_id'] ?? null;

            if ($order_id && $status_id) {
                $orderModel = new AdminOrder();
                $orderModel->updateOrderStatus($order_id, $status_id);

                // Lưu thông báo vào session
                $_SESSION['success_message'] = "Cập nhật trạng thái đơn hàng thành công!";

                // Redirect về lại trang chi tiết
                header("Location: " . BASE_URL_ADMIN . "?act=orders/detail&id=" . $order_id);
                exit;
            } else {
                echo "Thiếu dữ liệu!";
            }
        }
    }


    
}

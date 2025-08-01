<?php

class AdminController
{
    private $productModel;
    private $order;
    private $userModel;

    public function __construct()
    {
        $this->productModel = new AdminProduct();
        $this->order = new AdminOrder();
        $this->userModel = new AdminUser();
    }

    public function index()
    {
        // Tổng quan
        $orders = $this->order->getOrders();
        $totalProducts = $this->productModel->getTotalProducts();
        $totalOrders = $this->order->getTotalOrdersExcludeCanceled();
        $totalUsers = $this->userModel->getTotalUsers();

        // Lấy tháng và năm từ request hoặc mặc định là hiện tại
        $month = $_GET['month'] ?? date('m');
        $year = $_GET['year'] ?? date('Y');

        // Lấy doanh thu theo tháng/năm được chọn (đúng thứ tự tham số)
        $revenue = $this->order->getRevenue($year, $month);

        // Lấy doanh thu 12 tháng gần nhất (đảo ngược để hiển thị từ cũ đến mới)
        $revenueData = array_reverse($this->order->getRevenueLast12Months());

        // Render ra view
        require_once './views/admin/dashboard.php';
    }


    private function checkLogin()
    {
        session_start();
        if (!isset($_SESSION['user_admin'])) {
            header('Location: ' . BASE_URL_ADMIN . '?act=login');
            exit();
        }
    }
}

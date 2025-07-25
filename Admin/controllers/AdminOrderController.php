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
        $orders = $this->Order->getAllOrder();
        require_once './views/admin/orders/list.php';
    }


}
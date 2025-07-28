<?php

require_once 'AdminProduct.php';
class AdminOrder
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllOrders($keyword = null)
    {
        try {
            if (!empty($keyword)) {
                $keyword = '%' . $keyword . '%';
                $sql = "SELECT orders.*, status.name AS status_name
                    FROM orders
                    LEFT JOIN status ON orders.status_id = status.id
                    WHERE orders.order_code LIKE :keyword
                       OR orders.consignee LIKE :keyword
                       OR orders.phone LIKE :keyword
                    ORDER BY orders.id DESC";
                $stmt = $this->conn->prepare($sql);
                $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
            } else {
                $sql = "SELECT orders.*, status.name AS status_name
                    FROM orders
                    LEFT JOIN status ON orders.status_id = status.id
                    ORDER BY orders.id DESC";
                $stmt = $this->conn->prepare($sql);
            }

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return false;
        }
    }

    public function getOrderById($id)
    {
        $sql = "SELECT orders.*, 
                   status.name AS status_name, 
                   payment_methods.name AS payment_method_name
            FROM orders
            LEFT JOIN status ON orders.status_id = status.id
            LEFT JOIN payment_methods ON orders.payment_method = payment_methods.id
            WHERE orders.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    public function getOrderItems($orderId)
    {
        $sql = "SELECT 
                order_item.*, 
                products.name AS product_name, 
                products.image AS product_image
            FROM order_item
            INNER JOIN products ON order_item.product_id = products.id
            WHERE order_item.order_id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllStatus()
    {
        try {
            $sql  = 'SELECT * FROM status';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi truy vấn: " . $e->getMessage();
            return false;
        }
    }

    public function updateOrderStatus($order_id, $status_id)
    {
        $sql = "UPDATE orders SET status_id = :status_id WHERE id = :order_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status_id', $status_id, PDO::PARAM_INT);
        $stmt->bindParam(':order_id', $order_id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getOrdersByUserId($user_id)
    {
        $sql = "SELECT orders.*, 
                   status.name AS status_name, 
                   payment_methods.name AS payment_method_name
            FROM orders
            LEFT JOIN status ON orders.status_id = status.id
            LEFT JOIN payment_methods ON orders.payment_method = payment_methods.id
            WHERE orders.user_id = :user_id
            ORDER BY orders.order_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

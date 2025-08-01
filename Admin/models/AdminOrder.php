<?php

require_once 'AdminProduct.php';
class AdminOrder
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getRevenue($year, $month = null, $startMonth = null, $endMonth = null)
    {
        // Nếu lọc theo tháng cụ thể
        if ($month !== null) {
            $sql = "SELECT SUM(total_amount) AS total_revenue
                FROM orders
                WHERE status_id = 9
                AND YEAR(order_date) = :year
                AND MONTH(order_date) = :month";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':month', $month, PDO::PARAM_INT);
        }
        // Nếu lọc theo khoảng tháng (VD: từ tháng 3 đến tháng 6)
        elseif ($startMonth !== null && $endMonth !== null) {
            $sql = "SELECT MONTH(order_date) AS month, SUM(total_amount) AS total_revenue
                FROM orders
                WHERE status_id = 9
                AND YEAR(order_date) = :year
                AND MONTH(order_date) BETWEEN :startMonth AND :endMonth
                GROUP BY MONTH(order_date)
                ORDER BY MONTH(order_date)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':startMonth', $startMonth, PDO::PARAM_INT);
            $stmt->bindParam(':endMonth', $endMonth, PDO::PARAM_INT);
        }
        // Nếu không truyền tháng => lấy tất cả các tháng trước trong năm
        else {
            $sql = "SELECT MONTH(order_date) AS month, SUM(total_amount) AS total_revenue
                FROM orders
                WHERE status_id = 9
                AND YEAR(order_date) = :year
                GROUP BY MONTH(order_date)
                ORDER BY MONTH(order_date)";
            $stmt = $this->conn->prepare($sql);
        }

        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
        $stmt->execute();

        // Nếu lọc tháng cụ thể => trả về số
        if ($month !== null) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_revenue'] ?? 0;
        }

        // Nếu lọc khoảng tháng hoặc toàn bộ tháng => trả về danh sách
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getRevenueLast12Months()
    {
        $sql = "SELECT 
                MONTH(order_date) AS month, 
                YEAR(order_date) AS year,
                SUM(total_amount) AS total_revenue
            FROM orders
            WHERE status_id = 9
            AND order_date >= DATE_SUB(CURDATE(), INTERVAL 12 MONTH)
            GROUP BY YEAR(order_date), MONTH(order_date)
            ORDER BY year, month";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }




    public function getOrders()
    {
        $sql = "SELECT orders.*, 
                   users.name AS user_name, 
                   status.name AS status_name 
            FROM orders 
            INNER JOIN users ON orders.user_id = users.id 
            INNER JOIN status ON orders.status_id = status.id 
            ORDER BY orders.order_date DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalOrdersExcludeCanceled()
    {
        $sql = "SELECT COUNT(*) AS total 
            FROM orders 
            INNER JOIN status ON orders.status_id = status.id 
            WHERE status.name != 'Đã hủy'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
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
                   payment_methods.name AS payment_method_name,
                   users.name AS user_name,
                   users.email AS user_email,
                   users.phone AS user_phone
            FROM orders
            LEFT JOIN status ON orders.status_id = status.id
            LEFT JOIN payment_methods ON orders.payment_method = payment_methods.id
            LEFT JOIN users ON orders.user_id = users.id
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

<?php
require_once './core/database.php';

class Order
{

    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }
    public function createOrder(array $data)
    {
        $pdo = getDBConnection();
        $paymentMethodId = 1;
        $statusId = 1;
        $tempOrderCode = 'TEMP-' . uniqid();

        $sql = "INSERT INTO orders (user_id, consignee, phone, address, note, total_amount, payment_method, status_id, order_date, order_code)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([
            $data['user_id'],
            $data['name'],
            $data['phone'],
            $data['address'],
            $data['note'],
            $data['total_amount'],
            $paymentMethodId,
            $statusId,
            $tempOrderCode
        ]);

        if ($result) {
            $orderId = $pdo->lastInsertId();
            $orderCode = 'VH-' . $orderId;
            $sqlUpdateCode = "UPDATE orders SET order_code = ? WHERE id = ?";
            $stmtUpdateCode = $pdo->prepare($sqlUpdateCode);
            $stmtUpdateCode->execute([$orderCode, $orderId]);
            return $orderId;
        }
        return false;
    }

    public function createOrderItem($orderId, $productId, $variantId, $quantity, $price)
    {
        $pdo = getDBConnection();
        $sql = "INSERT INTO order_item (order_id, product_id, variant_id, quantity, price)
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$orderId, $productId, $variantId, $quantity, $price]);
    }

    public function decreaseStock($variantId, $quantity)
    {
        $pdo = getDBConnection();
        $sql = "UPDATE product_variants SET stock = stock - ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$quantity, $variantId]);
    }

    public function getOrder($user_id)
    {
        try {
            $sql = "SELECT 
                    orders.*, 
                    status.name AS status_name
                FROM orders 
                JOIN status ON orders.status_id = status.id
                WHERE orders.user_id = :user_id
            order by order_date  DEsc 

                ";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }


    public function getOrderById($id): array
    {
        $sql = "SELECT 
                o.*, 
                s.name AS status_name
            FROM orders o
            LEFT JOIN status s ON o.status_id = s.id
            WHERE o.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Đảm bảo bind đúng
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Trả về 1 dòng
    }

    public function getOrderItems($orderId): array
    {
        $sql = "SELECT 
                p.name AS product_name,
                oi.price,
                oi.quantity,
                s.name AS size,
                c.name AS color,
                (oi.price * oi.quantity) AS total_price
            FROM order_item oi
            JOIN products p ON oi.product_id = p.id
            LEFT JOIN product_variants v ON oi.variant_id = v.id
            LEFT JOIN sizes s ON v.size_id = s.id
            LEFT JOIN colors c ON v.color_id = c.id
            WHERE oi.order_id = :order_id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':order_id', $orderId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateOrderStatus($id, $status)
    {
        $sql = "UPDATE orders SET status_id = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $status, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}

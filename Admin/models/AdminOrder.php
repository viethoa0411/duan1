<?php

class AdminOrder
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllOrder()
    {
        try {
            // $sql = "SELECT orders.*, users.name AS user_name
            //         FROM orders
            //         LEFT JOIN orders ON orders.user_id = users.id
            //         ORDER BY orders.id DESC";
            $sql = "SELECT orders.*, users.name AS user_name
                    FROM orders
                    LEFT JOIN users ON orders.uesr_id = users.id
                    ORDER BY orders.id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

}
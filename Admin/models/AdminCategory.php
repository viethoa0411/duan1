<?php 

class AdminCategory {
    public $conn;
    public function __construct() {
        $this->conn = connectDB();
    }
    public function getAllCategory() {
        try {
            $sql = "SELECT * FROM categories";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }
}
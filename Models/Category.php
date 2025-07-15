<?php 

class Category {
    private $conn;
    

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
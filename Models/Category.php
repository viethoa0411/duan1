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

    // Lấy danh mục con có tên chứa từ khóa
    public function getCategoriesByKeyword($keyword) {
        $query = "SELECT * FROM categories WHERE name LIKE :keyword";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['keyword' => "%$keyword%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
   


}
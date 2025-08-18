<?php
require_once './core/database.php';

class Product
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllProducts()
    {
        $sql = "SELECT p.*, c.name as category_name 
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getProductById($id)
    {
        $pdo = getDBConnection();
        $sql = "
            SELECT p.*, c.name AS category_name 
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.id = ?
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo id danh mục
    public function getProductsByCategoryId($category_id)
    {
        $query = "  SELECT p.*, c.name AS category_name 
                    FROM products p
                    JOIN categories c ON p.category_id = c.id
                    WHERE category_id = :category_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['category_id' => $category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Lấy sản phẩm theo nhiều id danh mục
    public function getProductsByCategoryIds($category_ids)
    {
        if (empty($category_ids)) {
            return [];
        }
        $placeholders = implode(',', array_fill(0, count($category_ids), '?'));
        $query = "SELECT * FROM products WHERE category_id IN ($placeholders)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute($category_ids);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProducts($keyword)
    {
        $pdo = getDBConnection();
        $sql = "
            SELECT p.*, c.name AS category_name 
            FROM products p
            JOIN categories c ON p.category_id = c.id
            WHERE p.name LIKE :keyword
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRelatedProducts($category_id, $current_product_id, $limit = 4)
    {
        $pdo = getDBConnection();
        $limit = (int)$limit;
        $sql = "
            SELECT * FROM products 
            WHERE category_id = ? AND id != ?
            ORDER BY RAND() 
            LIMIT $limit
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$category_id, $current_product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNewProducts($limit = 12)
    {
        $pdo = getDBConnection();
        $limit = (int)$limit;
        $sql = "SELECT p.*, c.name AS category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                ORDER BY p.created_at DESC
                LIMIT $limit
                ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTopView($limit = 8)
    {
        $pdo = getDBConnection();
        $limit = (int)$limit;
        $sql = "SELECT p.*, c.name AS category_name FROM products p
                JOIN categories c ON p.category_id = c.id
                ORDER BY p.view_count DESC
                LIMIT $limit
                ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProductsByName($keyword)
    {
        $sql = "SELECT p.*, c.name AS category_name 
            FROM products p
            LEFT JOIN categories c ON p.category_id = c.id
            WHERE p.name LIKE :keyword";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['keyword' => '%' . $keyword . '%']);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

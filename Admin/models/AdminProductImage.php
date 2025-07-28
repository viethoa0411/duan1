<?php

class ProductImage
{
    protected $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function unsetDefaultImage($productId)
    {
        $stmt = $this->conn->prepare("UPDATE product_images SET is_default = 0 WHERE product_id = ?");
        $stmt->execute([$productId]);
    }

    public function checkMinimumImages($productId)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM product_images WHERE product_id = ?");
        $stmt->execute([$productId]);
        $count = $stmt->fetchColumn();
    
        return $count >= 3; // Trả về true nếu >= 2 ảnh
    }  
}

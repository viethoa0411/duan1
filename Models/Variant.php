<?php

class Variant
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getVariantsByProductId($productId)
    {
        try {
            $sql = "
                SELECT 
                    pv.id AS variant_id,
                    s.name AS size_name,
                    c.name AS color_name,
                    pv.stock
                FROM product_variants pv
                JOIN sizes s ON pv.size_id = s.id
                JOIN colors c ON pv.color_id = c.id
                WHERE pv.product_id = :productId
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':productId' => $productId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi truy vấn biến thể: " . $e->getMessage();
            return [];
        }
    }
}
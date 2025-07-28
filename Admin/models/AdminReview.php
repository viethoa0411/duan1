<?php
class AdminReview {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getReviewsByProductId($product_id) {
        try {
            $sql = "SELECT reviews.*, users.name AS user_name
                    FROM reviews 
                    LEFT JOIN users ON reviews.user_id = users.id
                    WHERE product_id = :product_id 
                    ORDER BY create_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':product_id' => $product_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi truy vấn bình luận: " . $e->getMessage();
            return false;
        }
    }
}

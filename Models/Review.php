<?php
require_once './core/database.php';

class Review {
    public function getByProductId($product_id) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT r.*, u.name as user_name 
                               FROM reviews r 
                               JOIN users u ON r.user_id = u.id 
                               WHERE r.product_id = ?");
        $stmt->execute([$product_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($product_id, $user_id, $rating, $comment) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO reviews (product_id, user_id, rating, comment) 
                               VALUES (?, ?, ?, ?)");
        return $stmt->execute([$product_id, $user_id, $rating, $comment]);
    }
}

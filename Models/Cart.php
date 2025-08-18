<?php
require_once './core/database.php';

class Cart
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function add($userId, $productId, $variantId, $quantity = 1)
    {
        try {
            $sql = "SELECT * FROM carts WHERE user_id = :userId AND product_id = :productId AND variant_id = :variantId";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':userId'    => $userId,
                ':productId' => $productId,
                ':variantId' => $variantId
            ]);
            $existingCartItem = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($existingCartItem) {
                $newQuantity = $existingCartItem['quantity'] + $quantity;
                $sql = "UPDATE carts SET quantity = :quantity, added_at = NOW() WHERE id = :cartId";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':quantity' => $newQuantity,
                    ':cartId'   => $existingCartItem['id'],
                ]);
            } else {
                $sql = "INSERT INTO carts (user_id, product_id, variant_id, quantity, added_at) VALUES (:userId, :productId, :variantId, :quantity, NOW())";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    ':userId'    => $userId,
                    ':productId' => $productId,
                    ':variantId' => $variantId,
                    ':quantity'  => $quantity,
                ]);
            }
            return true;
        } catch (PDOException $e) {
            echo "Lỗi: " . $e->getMessage();
            return false;
        }
    }

    public function clearCartByUserId($userId)
    {
        $pdo = getDBConnection();
        $sql = "DELETE FROM carts WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
    }
    public function countCartItemsByUserId($userId)
    {
        $sql = "SELECT COUNT(*) AS total FROM carts WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result['total'];
    }


    public function getCartItemsByUserId($userId)
    {
        try {
            $sql = "
            SELECT 
                c.id AS cart_id, 
                c.product_id,
                c.variant_id,
                c.quantity, 
                p.name AS product_name, 
                p.image AS product_image,
                p.price,
                p.price_sale,
                s.name AS size_name,
                co.name AS color_name,
                pv.stock
            FROM carts c
            JOIN products p ON c.product_id = p.id
            JOIN product_variants pv ON c.variant_id = pv.id
            JOIN sizes s ON pv.size_id = s.id
            JOIN colors co ON pv.color_id = co.id
            WHERE c.user_id = :userId
        ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':userId' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Lỗi truy vấn giỏ hàng: " . $e->getMessage();
            return [];
        }
    }

    public function updateQuantity($cartId, $newQuantity)
    {
        try {
            $sql = "UPDATE carts SET quantity = :quantity WHERE id = :cartId";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':quantity' => $newQuantity, ':cartId' => $cartId]);
        } catch (PDOException $e) {
            echo "Lỗi cập nhật giỏ hàng: " . $e->getMessage();
            return false;
        }
    }

    public function remove($cartId)
    {
        try {
            $sql = "DELETE FROM carts WHERE id = :cartId";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':cartId' => $cartId]);
        } catch (PDOException $e) {
            echo "Lỗi xóa sản phẩm khỏi giỏ hàng: " . $e->getMessage();
            return false;
        }
    }

    // Models/Cart.php

    public function getVariantStock($variantId)
    {
        $stmt = $this->conn->prepare("
        SELECT id, stock 
        FROM product_variants 
        WHERE id = :variant_id
    ");
        $stmt->execute([':variant_id' => $variantId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getQuantityInCart($userId, $variantId)
    {
        $stmt = $this->conn->prepare("
        SELECT quantity 
        FROM carts 
        WHERE user_id = :user_id AND variant_id = :variant_id
    ");
        $stmt->execute([
            ':user_id' => $userId,
            ':variant_id' => $variantId
        ]);
        return (int) $stmt->fetchColumn();
    }




    public function getCartItemCount($userId)
    {
        try {
            $sql = "SELECT COUNT(*) FROM carts WHERE user_id = :userId";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':userId' => $userId]);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            echo "Lỗi truy vấn số lượng giỏ hàng: " . $e->getMessage();
            return 0;
        }
    }
}

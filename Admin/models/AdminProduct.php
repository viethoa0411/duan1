<?php

class AdminProduct
{
    private $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllProduct()
    {
        try {
            // $sql = "SELECT * FROM products";
            $sql = "SELECT products.*, categories.name AS category_name
                    FROM products
                    LEFT JOIN categories ON products.category_id = categories.id
                    ORDER BY products.updated_at DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

    public function addProduct($name, $price, $price_sale, $quantity, $image, $created_at, $updated_at, $category_id)
    {
        try {
            $quantity = (int)$quantity;
            $sql = 'INSERT INTO `products` (`name`, `price`, `price_sale`, `quantity`, `image`, `created_at`, `updated_at`, `category_id`) 
                    VALUES (:name, :price, :price_sale, :quantity, :image, :created_at, :updated_at, :category_id)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':price_sale' => $price_sale,
                ':quantity' => $quantity,
                ':image' => $image,
                ':created_at' => $created_at,
                ':updated_at' => $updated_at,
                ':category_id' => $category_id
            ]);
            return $this->conn->lastInsertId();
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

    public function getProductById($id)
    {
        try {
            $sql = "SELECT * FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

        public function updateProduct($id, $name, $price, $price_sale, $quantity, $image, $updated_at, $category_id, $description) {
        try {
            $sql = "UPDATE products SET 
                        name = :name,
                        price = :price,
                        price_sale = :price_sale,
                        quantity = :quantity,
                        image = :image,
                        updated_at = :updated_at,
                        category_id = :category_id,
                        description = :description
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':price' => $price,
                ':price_sale' => $price_sale,
                ':quantity' => $quantity,
                ':image' => $image,
                ':updated_at' => $updated_at,
                ':category_id' => $category_id,
                ':description' => $description
            ]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }




    public function deleteProduct($id)
    {
        try {
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return true;
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }
}

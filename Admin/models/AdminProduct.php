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

    public function addProduct($name, $price, $price_sale, $quantity, $description, $image, $image_list, $created_at, $updated_at, $category_id)
    {
        try {
            $quantity = (int)$quantity;
            $sql = 'INSERT INTO `products` 
                    (`name`, `price`, `price_sale`, `quantity`, `description`, `image`, `image_list`, `created_at`, `updated_at`, `category_id`) 
                    VALUES 
                    (:name, :price, :price_sale, :quantity, :description, :image, :image_list, :created_at, :updated_at, :category_id)';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':price' => $price,
                ':price_sale' => $price_sale,
                ':quantity' => $quantity,
                ':description' => $description,
                ':image' => $image,
                ':image_list' => $image_list, // thêm dòng này
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
            $sql = "SELECT products.*, categories.name AS category_name
                    FROM products
                    LEFT JOIN categories ON products.category_id = categories.id
                    WHERE products.id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            echo "Lỗi truy vấn bị sai: " . $e->getMessage();
            return false;
        }
    }

    public function updateProduct($id, $name, $price, $price_sale, $quantity, $image, $image_list, $updated_at, $category_id, $description)
    {
        try {
            $sql = "UPDATE products SET 
                        name = :name,
                        price = :price,
                        price_sale = :price_sale,
                        quantity = :quantity,
                        description = :description,
                        image = :image,
                        image_list = :image_list,
                        updated_at = :updated_at,
                        category_id = :category_id
                    WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':id' => $id,
                ':name' => $name,
                ':price' => $price,
                ':price_sale' => $price_sale,
                ':quantity' => $quantity,
                ':description' => $description,
                ':image' => $image,
                ':image_list' => $image_list,
                ':updated_at' => $updated_at,
                ':category_id' => $category_id,
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
            // Xóa order_item liên quan qua product_variants
            $sql_order_item = "DELETE oi FROM order_item oi 
                           INNER JOIN product_variants pv ON oi.variant_id = pv.id 
                           WHERE pv.product_id = :id";
            $stmt_order_item = $this->conn->prepare($sql_order_item);
            $stmt_order_item->execute([':id' => $id]);

            // Xóa reviews
            $sql_reviews = "DELETE FROM reviews WHERE product_id = :id";
            $stmt_reviews = $this->conn->prepare($sql_reviews);
            $stmt_reviews->execute([':id' => $id]);

            // Xóa variants
            $sql_variant = "DELETE FROM product_variants WHERE product_id = :id";
            $stmt_variant = $this->conn->prepare($sql_variant);
            $stmt_variant->execute([':id' => $id]);

            // Xóa product
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return true;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return false;
        }
    }
}
